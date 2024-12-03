<?php

namespace App\Http\Services;
use App\Repositories\UserBidRepository;


class FundTransferService
{
    public function __construct(
        protected UserBidRepository $userBidRepository
    ) {
    }

    public function pendingFundTransfer(array $filterable = []): object
    {
        return $this->userBidRepository->queryBuilder(function ($row) {
            return $row->whereGranted(1)
                ->with(["product.category", "user", "product.user"])
                ->wherePaid(1)
                ->whereFundTransferred(0)
                ->get();
        });
    }

    public function updateTransferStatus(string $userBidId): void
    {
        $this->userBidRepository->update(["fund_transferred" => 1], $userBidId);
    }
}
