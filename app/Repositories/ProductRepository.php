<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\Product;
use Carbon\Carbon;

class ProductRepository extends BaseRepository
{

    public function __construct(
        Product $product
    ) {
        $this->model = $product;

        parent::__construct();
    }

    public function auctionHistoryIndexStoreFront(array $filterable = []): object
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $products = $this->queryBuilder(function ($rows) use ($currentDateTime, $filterable) {
            $rows = $rows->where("end_date", "<", $currentDateTime)
                ->where("status", 1)
                ->where("approved", 1)
                ->orWhere("expired_early", 1);
            return $this->getFiltered($rows, $filterable);
        });

        return $products;
    }

    public function getProductUnsuccessAds(array $productIds, array $with = []): ?object
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        return $this->model::whereIn("id", $productIds)
            ->where("status", 1)
            ->where("approved", 1)
            ->where("end_date", "<", $currentDateTime)
            ->doesntHave("bids")->get();
    }
}