<?php

namespace App\Http\Services;

use App\Repositories\ProductRepository;
use App\Repositories\UserBidRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProfileService
{
    public function __construct(
        protected UserRepository $userRepository,
        protected ProductRepository $productRepository,
        protected UserBidRepository $userBidRepository
    ) {
    }

    public function profileBids(array $filterable = []): object
    {
        $userBids = auth()->user()->bids()->with(['product'])->get();

        $currentDateTime = Carbon::now()->toDateTimeString();

        $filterLive = false;
        if (
            isset($filterable["bid_type"])
            && $filterable["bid_type"] == "live"
        ) {
            $filterLive = true;
        }
        $userBids = auth()->user()
            ->bids()
            ->whereHas("product", function ($query) use ($currentDateTime, $filterLive) {
                ($filterLive)
                    ? $query->where("start_date", "<=", $currentDateTime)
                            ->where("end_date", ">=", $currentDateTime)
                            ->where("expired_early", 0)
                            ->where("approved", 1)
                    : $query->where("end_date", "<=", $currentDateTime)->orWhere("expired_early", 1);
            }
        )->get();

        return $userBids;
    }

    public function fetch(array $filterable = [])
    {
        $user = $this->userRepository->fetch(auth()->user()->id, $filterable);
        return $user;
    }

    public function updateProfile(array $data)
    {
        $this->userRepository->update($data, auth()->user()->id);
    }

    public function updatePassword(array $data)
    {
        $this->userRepository->update($data, auth()->user()->id);
    }

    public function profileInfo()
    {
        $profileInfo = $this->userRepository->fetch(auth()->user()->id, ["products.bids", "bids"]);
        $profileInfo->totalBids = count($profileInfo->bids);
        $profileInfo->totalProducts = count($profileInfo->products);
        $profileInfo->totalSuccessBids = count($profileInfo->bids->where("granted", 1));
        $profileInfo->totalSuccessUnpaidBids = count($profileInfo->bids->where("granted", 1)->where("paid", 0));
        $profileInfo->totalSuccessPaidBids = count($profileInfo->bids->where("granted", 1)->where("paid", 1));


        $productIds = $profileInfo->products->pluck("id")?->toArray();

        $profileInfo->totalSuccessPaidAds = count($this->successBids($productIds));
        $profileInfo->totalSuccessUnPaidAds = count($this->userBidRepository->getProductSuccessUnpaidAds($productIds));
        $currentDateTime = Carbon::now()->toDateTimeString();
        $profileInfo->totalFailedAds = $this->productRepository->model::where("end_date", "<", $currentDateTime)
            ->where("user_id", auth()->user()->id)
            ->orWhere("expired_early", 1)
            ->with(["bids"])
            ->get()
            ->filter(fn ($product) => $product->bids->isEmpty())->count();

        $profileInfo->totalSuccessAds = count($this->userBidRepository->getProductGrantedAds($productIds));
        $profileInfo->totalPendingAds = count($profileInfo->products->where("approved", 0));
        $profileInfo->totalUpcomingAds = count(
            $profileInfo->products
                ->where("start_date", ">", $currentDateTime)
                ->where("status", 1)
                ->where("approved", 1)
        );
        $profileInfo->totalLiveAds = count(
            $profileInfo->products
                ->where("start_date", "<", $currentDateTime)
                ->where("end_date", "<", $currentDateTime)
                ->where("expired_early", 0)
                ->where("status", 1)
                ->where("approved", 1)
        );

        return $profileInfo;
    }

    public function expiredProducts(string $userId): array
    {
        $profileInfo = $this->userRepository->fetch($userId, ["products.bids", "bids"]);
        $productIds = $profileInfo->products->pluck("id")?->toArray();
        $totalSuccessPaidAds = $this->userBidRepository->getProductSuccessAds($productIds, ["product"]);
        $totalSuccessUnPaidAds = $this->userBidRepository->getProductSuccessUnpaidAds($productIds, ["product"]);
        $totalUnsuccessAds = $this->productRepository->getProductUnsuccessAds($productIds);

        return [
            "total_success_paid_ads" => $totalSuccessPaidAds,
            "total_success_unpaid_ads" => $totalSuccessUnPaidAds,
            "total_unsuccess_ads" => $totalUnsuccessAds,
        ];
    }

    public function successBids(array $productIds = [])
    {
        return $this->userBidRepository->getProductSuccessAds($productIds);
    }
}
