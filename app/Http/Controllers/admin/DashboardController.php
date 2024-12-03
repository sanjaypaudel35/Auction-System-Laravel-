<?php

namespace App\Http\Controllers\admin;

use App\Core\Controllers\BaseController;
use App\Http\Services\FundTransferService;
use App\Http\Services\ProductService;
use App\Repositories\ProductRepository;
use App\Repositories\UserBidRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends BaseController
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected UserBidRepository $userBidRepository,
        protected UserRepository $userRepository,
        protected ProductService $productService,
        protected FundTransferService $fundTransferService
    ) {
    }

    protected function commonData(): array {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $expiredProducts = $this->expiredProducts();
        $systemAdmins = $this->userRepository->model::whereHas("role", function ($query) {
            return $query->where("slug", "super-admin");
        })->count();
        $registeredUsers = $this->userRepository->model::whereHas("role", function ($query) {
            return $query->where("slug", "customer");
        })->count();

        $pendingFundTransferCount = $this->fundTransferService->pendingFundTransfer()?->count();
        return [
            "pending_auctions" => count($this->productService->index([
                "no_paginate" => true,
                "__eq_approved" => 0,
            ], ["category", "user"])),

            "live_auctions" => count($this->productService->index([
                "__lte_start_date" => $currentDateTime,
                "__gte_end_date" => $currentDateTime,
                "__eq_approved" => 1,
                "__eq_status" => 1,
                "__eq_expired_early" => 0,
                "no_paginate" => true,
            ])),
            "upcoming_auctions" => count($this->productService->index([
                "__gt_start_date" => $currentDateTime,
                "__eq_approved" => 1,
                "no_paginate" => true,
            ])),
            "expiredProducts" => $expiredProducts,
            "system_admins" => $systemAdmins,
            "registered_users" => $registeredUsers,
            "pending_fund_transfer" => $pendingFundTransferCount,
        ];
    }

    private function expiredProducts(): array
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $expiredProducts = $this->productRepository->model::where("end_date", "<", $currentDateTime)
            ->orWhere("expired_early", 1)
            ->with("bids")->get();
        $noBidProducts = $this->productService->oldAuctionNoBids();
        $expiredPaidAuctions = $expiredProducts->filter(function ($value, $key) {
            return $value->bids->contains("granted", 1) && $value->bids->contains("paid", 1);
        });

        $expiredUnPaidAuctions = $expiredProducts->filter(function ($value, $key) {
            return $value->bids->contains("granted", 1) && $value->bids->contains("paid", 0);
        });

        return [
            "expired_with_zero_bids" => $noBidProducts,
            "expired_with_unpaid" => $expiredUnPaidAuctions,
            "expired_with_paid" => $expiredPaidAuctions,
        ];
    }

    public function __invoke(Request $request)
    {
        try {

        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return parent::view("dashboard");
    }
}
