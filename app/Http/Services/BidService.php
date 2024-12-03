<?php

namespace App\Http\Services;

use App\Repositories\UserBidRepository;
use Illuminate\Support\Carbon;

class BidService
{
    public function __construct(
        protected UserBidRepository $userBidRepository
    ) {
    }

    public function userBidsHistory(string $userId): object
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $userBids = $this->userBidRepository->model->where("user_id", $userId)->whereHas("product", function ($query) use ($currentDateTime) {
            $query->where("end_date", "<", $currentDateTime)
                ->orWhere("expired_early", 1);
        })->get();

        return $userBids;
    }

    public function userBidsLive(string $userId): object
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $userBids = $this->userBidRepository->model->where("user_id", $userId)->whereHas("product", function ($query) use ($currentDateTime) {
            $query->where("end_date", ">=", $currentDateTime)
                ->where("start_date", "<=", $currentDateTime)
                ->where("expired_early", 0);
        })->get();

        return $userBids;
    }
}
