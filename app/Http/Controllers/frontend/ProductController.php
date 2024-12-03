<?php

namespace App\Http\Controllers\frontend;

use App\Core\Controllers\BaseController;
use App\Http\Requests\ProductBidRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    protected string $basePath = "frontend.pages.product";
    protected string $baseRoute = "products";

    public function __construct(
        protected ProductService $productService,
    ) {
        parent::__construct();
    }

    public function index(Request $request) {

        try {
            $filterable = ["__eq_status" => 1, "__eq_approved" => 1];

            $currentDateTime = Carbon::now()->toDateTimeString();
            $filterable1 = array_merge($filterable, [
                "__lte_start_date" => $currentDateTime,
                "__gte_end_date" => $currentDateTime,
                "__eq_expired_early" => 0,
                "per_page" => 6,
            ]);
            $productsLive = $this->productService->index(
                filterable: $filterable1,
                relationships: ["topBids"]
            );

            $filterable2 = array_merge($filterable, [
                "__gt_start_date" => $currentDateTime,
                "per_page" => 3,
            ]);
            $productsUpcoming = $this->productService->index($filterable2);
            $products = [
                "live" => $productsLive,
                "upcoming" => $productsUpcoming,
            ];
        } catch (Exception $exception) {
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        $function = __FUNCTION__;
        return view("{$this->basePath}.{$function}", compact("products"));
    }

    public function liveAuctions(Request $request) {

        try {
            $filterable = ["__eq_status" => 1, "__eq_approved" => 1];

            $filterable = array_merge($request->query(), $filterable);
            $categoryId = null;
            if (isset($filterable["__eq_category_id"])) {
                $categoryId = $filterable["__eq_category_id"];
            }
            $currentDateTime = Carbon::now()->toDateTimeString();
            $filterable1 = array_merge($filterable, [
                "__lte_start_date" => $currentDateTime,
                "__gte_end_date" => $currentDateTime,
                "__eq_expired_early" => 0,
                "per_page" => 4,
            ]);
            $products = $this->productService->index(
                filterable: $filterable1,
                relationships: ["topBids"]
            );
        } catch (Exception $exception) {
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        return view("{$this->basePath}.live", compact("products", "categoryId"));
    }

    public function upcomingAuctions(Request $request) {

        try {
            $filterable = ["__eq_status" => 1, "__eq_approved" => 1];

            $filterable = array_merge($request->query(), $filterable);

            $categoryId = null;
            if (isset($filterable["__eq_category_id"])) {
                $categoryId = $filterable["__eq_category_id"];
            }
            $currentDateTime = Carbon::now()->toDateTimeString();

            $filterable = array_merge($filterable, [
                "__gt_start_date" => $currentDateTime,
                "per_page" => 3,
            ]);
            $products = $this->productService->index(
                filterable: $filterable,
                relationships: ["topBids"]
            );
        } catch (Exception $exception) {
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        return view("{$this->basePath}.upcoming", compact("products", "categoryId"));
    }

    public function auctionsHistory(Request $request) {

        try {
            $filterable = ["__eq_status" => 1, "__eq_approved" => 1];

            $filterable = array_merge($request->query(), $filterable);

            $categoryId = null;
            if (isset($filterable["__eq_category_id"])) {
                $categoryId = $filterable["__eq_category_id"];
            }
            $products = $this->productService->auctionHistoryIndexStoreFront(
                filterable: $filterable,
                relationships: ["topBids"]
            );
        } catch (Exception $exception) {
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        return view("{$this->basePath}.history", compact("products", "categoryId"));
    }


    public function create(Request $request)
    {
        try {
        } catch (Exception $exception) {
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        DB::commit();
        $function = __FUNCTION__;
        return view("{$this->basePath}.{$function}");
    }

    public function bidProduct(ProductBidRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $this->productService->bidProduct($data);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        DB::commit();
        return $this->successRedirect(
            message: $this->lang("bid-success"),
            redirectRoute: "{$this->baseRoute}.show",
            routeParam: $data["product_id"]
        );
    }

    public function store(ProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data["start_date"] = date('Y-m-d H:i:s', strtotime($data["start_date"]));
            $data["end_date"] = date('Y-m-d H:i:s', strtotime($data["end_date"]));

            $this->productService->store($data);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        session()->pull("filepath");
        DB::commit();
        return $this->successRedirect(
            message: $this->lang("create-success"),
            redirectRoute: "profile.products.pending"
        );
    }

    public function update(ProductRequest $request, string $productId)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data["start_date"] = date('Y-m-d H:i:s', strtotime($data["start_date"]));
            $data["end_date"] = date('Y-m-d H:i:s', strtotime($data["end_date"]));
            $this->productService->update($productId, $data);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return $this->successRedirect(
                redirectRoute: "profile.products.edit",
                message: "Exception: {$message["message"]}",
                routeParam: $productId,
                errorMessage: true
            );
        }

        session()->pull("filepath");
        DB::commit();
        if ($path = session()->pull("filePathToDelete")) {
            $this->productService->deleteImageFile($path);
        }

        return $this->successRedirect(
            message: $this->lang("update-success"),
            redirectRoute: "profile.products.edit",
            routeParam: $productId
        );
    }

    public function show(string $productId)
    {
        try {
        //     $data = [
        //     "product_id" => "23",
        //     "product_name" => "test",
        //     "user_name" => "sanjay",
        //     "user_email" => "jaysanpaudel35@gmail.com",
        //     "bid_amount" => "100",
        //     "product_owner_email" => "jaysanpaduel35@gmail.com",
        //     "date" => now(),
        // ];

        // Event::dispatch("payment.success", [$data]);
            $product = $this->productService->show($productId, ["topBids.user"]);
        } catch (Exception $exception) {
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        $function = __FUNCTION__;
        return view("{$this->basePath}.{$function}", compact("product"));
    }

    public function destroy(string $ProductId)
    {
        DB::beginTransaction();

        try {
            $this->productService->delete($ProductId);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        DB::commit();
        return $this->successRedirect(
            message: $this->lang("delete-success"),
            redirectRoute: "{$this->baseRoute}.index"
        );
    }
}
