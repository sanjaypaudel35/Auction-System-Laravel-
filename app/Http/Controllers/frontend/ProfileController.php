<?php

namespace App\Http\Controllers\frontend;

use App\Core\Controllers\BaseController;
use App\Exceptions\ProductIsLiveException;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Services\ProductService;
use App\Http\Services\ProfileService;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class  ProfileController extends BaseController
{
    protected string $basePath = "frontend.pages.profile.auctions";
    protected string $baseRoute = "profile.products";

    protected string $accountBasePath = "frontend.pages.profile.account";
    protected string $accountBaseRoute = "profile.account";


    public function __construct(
        protected ProductService $productService,
        protected ProfileService $profileService
    ) {
        parent::__construct();
    }

    protected function commonData(): array {
        $userId = auth()->user()->id;
        $currentDateTime = Carbon::now()->toDateTimeString();

        $expiredProducts = $this->profileService->expiredProducts($userId);
        $oldAuctionCount = count($expiredProducts["total_success_paid_ads"]) + count($expiredProducts["total_success_unpaid_ads"]);

        return [
            "_pending_auctions" => count($this->productService->index([
                "no_paginate" => true,
                "__eq_approved" => 0,
                "__eq_user_id" => $userId,
            ], ["category", "user"])),

            "_live_auctions" => count($this->productService->index([
                "__lte_start_date" => $currentDateTime,
                "__gte_end_date" => $currentDateTime,
                "__eq_user_id" => $userId,
                "__eq_approved" => 1,
                "per_page" => 4,
            ])),
            "_upcoming_auctions" => count($this->productService->index([
                "__gt_start_date" => $currentDateTime,
                "__eq_user_id" => $userId,
                "no_paginate" => true,
            ])),
            "_old_auctions" => $oldAuctionCount,
        ];
    }

    public function editProfile()
    {
        try {
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        return view("{$this->accountBasePath}.edit");
    }

    public function editPassword()
    {
        try {
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        return view("{$this->accountBasePath}.update-password");
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $this->profileService->updatePassword($validated);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        return $this->successRedirect(
            redirectRoute: "{$this->accountBaseRoute}.edit",
            message: "Password updated successfully"
        );
    }

    public function profileInfo()
    {
        try {
            $profileInfo = $this->profileService->profileInfo();
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        return view("{$this->accountBasePath}.info", compact("profileInfo"));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $this->profileService->updateProfile($data);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        return $this->successRedirect(
            redirectRoute: "{$this->accountBaseRoute}.edit",
            message: "Profile updated successfully"
        );
    }

    public function editProduct(Request $request, string $productId)
    {
        try {
            $product = $this->productService->show($productId);

            throw_if(
                condition: (
                    $product->is_live
                    || $product->expired
                    || $product->is_upcoming
                    || $product->expired_early
                ),
                exception: new ProductIsLiveException("Edit to this product is restricted.")
            );
        } catch (Exception $exception) {
            $exceptionResponse = $this->handleException($exception);
            return $this->successRedirect(
                redirectRoute: "products.show",
                message: $exceptionResponse["message"],
                routeParam: $productId,
                errorMessage: true
            );
        }

        DB::commit();
        return view("{$this->basePath}.edit", compact("product"));
    }

    /**
     * Resubmit product from.
     *
     * @param Request $request
     * @param string $productId
     * @return void
     */
    public function resubmitProduct(Request $request, string $productId)
    {
        try {
            $product = $this->productService->show($productId);

            throw_if(
                condition: (
                    $product->is_live
                    || $product->is_upcoming
                    || !$product->approved
                ),
                exception: new ProductIsLiveException("Edit to this product is restricted.")
            );
        } catch (Exception $exception) {
            $exceptionResponse = $this->handleException($exception);
            return $this->successRedirect(
                redirectRoute: "products.show",
                message: $exceptionResponse["message"],
                routeParam: $productId,
                errorMessage: true
            );
        }

        DB::commit();
        return view("{$this->basePath}.resubmit", compact("product"));
    }

    /**
     * Resubmit the product put method
     *
     * @param ProductRequest $request
     * @param string $productId
     * @return void
     */
    public function putResubmitProduct(ProductRequest $request, string $productId)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data["approved"] = 0;
            $this->productService->resubmitProduct($productId, $data);
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

    public function profile()
    {
        try {
            $user = $this->profileService->fetch(["bids", "products"]);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        return view("{$this->accountBasePath}.edit", compact("user"));
    }

    public function deleteProduct(string $productId)
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

    public function liveProducts(Request $request)
    {
        try {
            $filterable = $request->query();

            $currentDateTime = Carbon::now()->toDateTimeString();

            $filterableLive = array_merge($filterable, [
                "__lte_start_date" => $currentDateTime,
                "__gte_end_date" => $currentDateTime,
                "__eq_user_id" => auth()->user()->id,
                "__eq_approved" => 1,
                "__eq_expired_early" => 0,
                "__eq_status" => 1,
            ]);
            $info = [
                "title" => "Live Auctions",
                "route" => Route::currentRouteName()
            ];
            $products = $this->productService->index($filterableLive, ["category", "user"]);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view($this->basePath.".index", ["products" => $products, "info" => $info]);
    }

    public function expiredProducts(Request $request)
    {
        try {
            $info = [
                "title" => "Expired Auction",
                "route" => Route::currentRouteName()
            ];
            // $products = $this->productService->index($filterableLive, ["category", "user"]);
            $userId = auth()->user()->id;
            $expiredProducts = $this->profileService->expiredProducts($userId);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view($this->basePath.".history", ["expiredProducts" => $expiredProducts, "info" => $info]);
    }

    public function profileBids(Request $request)
    {
        try {
            $filterable = $request->query();

            $info = [
                "title" => "My Bids",
                "route" => Route::currentRouteName()
            ];
            $products = $this->profileService->profileBids($filterable);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view($this->basePath.".bids", ["products" => $products, "info" => $info]);
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
                "__eq_user_id" => auth()->user()->id,
            ]);
            $info = [
                "title" => "Upcoming Auction",
                "route" => Route::currentRouteName()
            ];
            $products = $this->productService->index($filterableLive, ["category", "user"]);

        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view($this->basePath.".index", ["products" => $products, "info" => $info]);
    }

    public function pendingProducts(Request $request)
    {
        try {
            $filterable = $request->query();
            $filterable = array_merge([
                "no_paginate" => true,
                "__eq_approved" => 0,
                "__eq_user_id" => auth()->user()->id,
            ], $filterable);
            $info = [
                "title" => "Pending Auctions",
                "route" => Route::currentRouteName(),
            ];
            $products = $this->productService->index($filterable, ["category", "user"]);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view($this->basePath.".index", ["products" => $products, "info" => $info]);
    }
}
