<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\UserBid;
use Illuminate\Support\Carbon;

class UserBidRepository extends BaseRepository
{

    public function __construct(
        UserBid $userBid
    ) {
        $this->model = $userBid;

        parent::__construct();
    }

    public function fetchByUserAndProduct(string $userId, string $productId): ?object
    {
        return $this->model::whereProductId($productId)
            ->whereUserId($userId)
            ->firstOrFail();
    }

    public function fetchPaidProduct(string $productId): ?object
    {
        return $this->model::whereProductId($productId)
            ->wherePaid(1)
            ->first();
    }

    public function getProductSuccessAds(array $productBids, array $with = [])
    {
        return $this->model::with($with)
            ->whereGranted(1)
            ->wherePaid(1)
            ->whereIn("product_id", $productBids)
            ->get();
    }

    public function getAllProductSuccessAds(array $with = [])
    {
        return $this->model::with($with)
            ->whereGranted(1)
            ->wherePaid(1)
            ->get();
    }

    public function getProductSuccessUnpaidAds(array $productBids, array $with = [])
    {
        return $this->model::with($with)
            ->whereGranted(1)
            ->wherePaid(0)
            ->whereIn("product_id", $productBids)
            ->get();
    }

    public function getAllProductSuccessUnpaidAds(array $productBids, array $with = [])
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $expired = 0;
        if ($currentDateTime > $this->end_date) {
            $expired = 1;
        }

        return $this->model::with($with)
            ->whereGranted(1)
            ->wherePaid(0)
            ->get();
    }

    public function getProductGrantedAds(array $productBids, array $with = [])
    {
        return $this->model::with($with)
            ->whereGranted(1)
            ->whereIn("product_id", $productBids)
            ->get();
    }
}