<?php

namespace App\Http\Controllers\admin;

use App\Core\Controllers\BaseController;
use App\Http\Services\BidService;
use App\Http\Services\ProductService;
use App\Http\Services\ProfileService;
use App\Http\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UserAuctionController extends BaseController
{
    protected string $basePath = "dashboard.users.auction";
    protected string $bidBasePath = "dashboard.users.bid";
    protected string $baseRoute = "dashboard.users.auction";

    public function __construct(
        protected ProductService $productService,
        protected ProfileService $profileService,
        protected BidService $bidService,
        protected UserService $userService
    ) {
        parent::__construct();
    }

    protected function commonData(): array {
        $userId = Route::current()->parameter("user_id");
        $currentDateTime = Carbon::now()->toDateTimeString();

        $expiredProducts = $this->profileService->expiredProducts($userId);
        $oldAuctionCount = count($expiredProducts["total_success_paid_ads"])
            + count($expiredProducts["total_success_unpaid_ads"])
            + count($expiredProducts["total_unsuccess_ads"]);

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
                "__eq_expired_early" => 0,
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

    public function liveAuctions(Request $request, string $userId)
    {
        try {
            $filterable = [
                "__eq_status" => 1,
                "__eq_approved" => 1,
                "__eq_expired_early" => 0,
                "__eq_user_id" => $userId
            ];

            $user = $this->userService->show($userId);
            $filterable = array_merge($request->query(), $filterable);
            $categoryId = null;
            if (isset($filterable["__eq_category_id"])) {
                $categoryId = $filterable["__eq_category_id"];
            }
            $currentDateTime = Carbon::now()->toDateTimeString();
            $filterable = array_merge($filterable, [
                "__lte_start_date" => $currentDateTime,
                "__gte_end_date" => $currentDateTime,
                "no_paginate" => true,
            ]);
            $products = $this->productService->index(
                filterable: $filterable,
                relationships: ["topBids"]
            );
            $info["title"] = "Live auction";
            $info["route"] = Route::currentRouteName();
            $info["user"] = $user;

        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view("{$this->basePath}.live", ["products" => $products, "info" => $info]);
    }


    public function upcomingAuctions(Request $request, string $userId)
    {
        try {
            $filterable = ["__eq_status" => 1, "__eq_approved" => 1, "__eq_user_id" => $userId];

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
            $user = $this->userService->show($userId);
            $info["title"] = "Live auction";
            $info["route"] = Route::currentRouteName();
            $info["user"] = $user;
            $products = $this->productService->index(
                filterable: $filterable,
                relationships: ["topBids"]
            );
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view("{$this->basePath}.upcoming", ["products" => $products, "info" => $info]);
    }

    public function auctionHistory(Request $request, string $userId)
    {
        try {
            $user = $this->userService->show($userId);
            $info["title"] = "Live auction";
            $info["route"] = Route::currentRouteName();
            $info["user"] = $user;
            $expiredProducts = $this->profileService->expiredProducts($userId);
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view($this->basePath.".history", ["expiredProducts" => $expiredProducts, "info" => $info]);
    }

    public function pendingAuctions(Request $request, string $userId)
    {
        try {
            $filterable = $request->query();
            $filterable = array_merge([
                "no_paginate" => true,
                "__eq_approved" => 0,
                "__eq_user_id" => $userId,
            ], $filterable);

            $user = $this->userService->show($userId);
            $info["title"] = "Pending Auction";
            $info["route"] = Route::currentRouteName();
            $info["user"] = $user;
            $products = $this->productService->index($filterable, ["category", "user"]);
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return parent::view($this->basePath.".pending", ["products" => $products, "info" => $info]);
    }

    ##BIDS

    public function liveBids(Request $request, string $userId)
    {
        try {
            $filterable = $request->query();
            $user = $this->userService->show($userId);

            $info = [
                "route" => Route::currentRouteName()
            ];
            $info["user"] = $user;
            $_old_bids = count($this->bidService->userBidsHistory($userId));
            $products = $this->bidService->userBidsLive($userId);
            $_live_bids = count($products);
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

        return view($this->bidBasePath.".live", compact("products", "info", "_old_bids", "_live_bids"));
    }

    public function bidHistory(Request $request, string $userId)
    {
        try {
            $user = $this->userService->show($userId);
            $filterable = $request->query();
            $currentDateTime = Carbon::now()->toDateTimeString();

            $info = [
                "route" => Route::currentRouteName()
            ];
            $info["user"] = $user;
            $_live_bids = count($this->bidService->userBidsLive($userId));
            $products = $this->bidService->userBidsHistory($userId);
            $_old_bids = count($products);
        } catch (\Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return view($this->bidBasePath.".history", compact("products", "info", "_live_bids", "_old_bids"));
    }
}
