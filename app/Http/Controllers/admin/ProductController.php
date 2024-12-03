<?php

namespace App\Http\Controllers\admin;

use App\Core\Controllers\BaseController;
use App\Exceptions\ProductIsLiveException;
use App\Http\Requests\ProductRequest;
use App\Http\Services\ProductService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ProductController extends BaseController
{
    protected string $viewBasePath = "dashboard.products";
    protected string $baseRoute = "dashboard.products";

    public function __construct(
        protected ProductService $productService,
    ) {
        parent::__construct();
    }

    public function approve(string $productId, Request $request)
    {
        try {
           $this->productService->approveProduct($productId);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];

        return $this->successRedirect(
            redirectRoute: "{$this->baseRoute}.pending"
        );
    }

    public function updatePaymentStatus(
        string $productId,
        string $userId,
        bool $paymentStatus
    ) {
        try {
           $this->productService->updatePaymentStatus(
                productId: $productId,
                userId: $userId,
                paymentStatus: $paymentStatus
            );
        } catch (Exception $exception) {
            $exceptionResponse = $this->handleException($exception);
            return $this->successRedirect(
                redirectRoute: "{$this->baseRoute}.show",
                message: $exceptionResponse["message"],
                routeParam: $productId,
                errorMessage: true
            );
        }

        return $this->successRedirect(
            redirectRoute: "{$this->baseRoute}.show",
            message: "Payment status updated successfully",
            routeParam: $productId,
        );
    }

    public function edit(string $productId)
    {
        try {
            $product = $this->productService->show($productId);
            throw_if(
                condition: ($product->is_live || $product->expired),
                exception: ProductIsLiveException::class
            );
        } catch (Exception $exception) {
            $exceptionResponse = $this->handleException($exception);
            return $this->successRedirect(
                redirectRoute: "{$this->baseRoute}.show",
                message: $exceptionResponse["message"],
                routeParam: $productId,
                errorMessage: true
            );
        }

        return view($this->viewBasePath.".edit", compact("product"));
    }

    public function pendingProducts(Request $request)
    {
        try {
            $filterable = $request->query();
            $filterable = array_merge([
                "no_paginate" => true,
                "__eq_approved" => 0,
            ], $filterable);
            $info = [
                "title" => "Pending Products",
                "route" => Route::currentRouteName(),
            ];
            $products = $this->productService->index($filterable, ["category", "user"]);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return view($this->viewBasePath.".index", compact("products", "info"));
    }


    public function auctionHistory(Request $request) {

        try {
            $filterable = $request->query();

            $currentDateTime = Carbon::now()->toDateTimeString();

            $filterable = array_merge($filterable, [
                "no_paginate" => true
            ]);
            $info = [
                "title" => "Auction History",
                "route" => Route::currentRouteName(),
            ];
            $products = $this->productService->auctionHistoryIndexStoreFront(
                filterable: $filterable,
                relationships: ["topBids"]
            );
            $oldPaidAuction = $this->productService->oldPaidAuction();
            $oldUnPaidAuction = $this->productService->oldUnPaidAuction();
            $oldAuctionNoBids = $this->productService->oldAuctionNoBids();
            $products = [
                "products" => $products,
                "old_paid_auctions" => $oldPaidAuction,
                "old_unpaid_auctions" => $oldUnPaidAuction,
                "old_auction_no_bids" => $oldAuctionNoBids,
            ];
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return view("{$this->viewBasePath}.history", compact("products", "info"));
    }

    /**
     * This function is currently not in used
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        try {
            $filterable = $request->query();
            $filterable = array_merge([
                "no_paginate" => true,
                "__eq_approved" => 0
            ], $filterable);

            $currentDateTime = Carbon::now()->toDateTimeString();

            $filterableLive = [
                "__lte_start_date" => $currentDateTime,
                "__gte_end_date" => $currentDateTime,
                "__eq_status" => 1,
                "__eq_approved" => 1,
            ];
            $pendingProducts = $this->productService->index($filterable, ["category", "user"]);
            $liveProducts = $this->productService->index($filterableLive, ["category", "user"]);
            $products = [
                "pending_products" => $pendingProducts,
                "live_products" => $liveProducts,
            ];
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return view($this->viewBasePath.".index", compact("products"));
    }

    public function liveProducts(Request $request)
    {
        try {
            $filterable = $request->query();

            $currentDateTime = Carbon::now()->toDateTimeString();

            $filterableLive = array_merge($filterable, [
                "__lte_start_date" => $currentDateTime,
                "__gte_end_date" => $currentDateTime,
                "__eq_expired_early" => 0,
                "__eq_approved" => 1,
            ]);
            $info = [
                "title" => "Live Auction",
                "route" => Route::currentRouteName()
            ];
            $products = $this->productService->index($filterableLive, ["category", "user"]);

        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return view($this->viewBasePath.".index", compact("products", "info",));
    }

    public function upcomingProducts(Request $request)
    {
        try {
            $filterable = $request->query();

            $currentDateTime = Carbon::now()->toDateTimeString();

            $filterableLive = array_merge($filterable, [
                "__eq_status" => 1,
                "__eq_approved" => 1,
                "__gt_start_date" => $currentDateTime,
            ]);
            $info = [
                "title" => "Upcoming Auction",
                "route" => Route::currentRouteName()
            ];
            $products = $this->productService->index($filterableLive, ["category", "user"]);

        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return view($this->viewBasePath.".index", compact("products", "info",));
    }

    public function create(Request $request)
    {
        try {
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        $function = __FUNCTION__;
        return view("{$this->viewBasePath}.{$function}");
    }

    public function store(ProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();

            $this->productService->store($data);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        DB::commit();
        return $this->successRedirect(
            message: $this->lang("create-success"),
            redirectRoute: "{$this->baseRoute}.index"
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
                redirectRoute: "{$this->baseRoute}.show",
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
            redirectRoute: "{$this->baseRoute}.show",
            routeParam: $productId
        );
    }

    public function show(string $productId)
    {
        try {
            $product = $this->productService->show($productId, ["topBids.user"]);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return view($this->viewBasePath.".show", compact("product"));
    }

    public function destroy(string $productId)
    {
        DB::beginTransaction();

        try {
            $this->productService->delete($productId);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        DB::commit();
        return $this->successRedirect(
            message: $this->lang("delete-success"),
            redirectRoute: "{$this->baseRoute}.live"
        );
    }
}
