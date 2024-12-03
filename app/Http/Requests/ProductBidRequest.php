<?php

namespace App\Http\Requests;

use App\Core\Requests\BaseRequest;
use App\Rules\BidAmountRule;
use App\Rules\BidderAndOwnerRule;
use Illuminate\Support\Facades\Auth;

class ProductBidRequest extends BaseRequest
{
    public function __construct(
        protected BidAmountRule $bidAmountRule,
        protected BidderAndOwnerRule $bidderAndOwnerRule
    ) {

    }

    protected function store(): array
    {
        $this->merge(["user_id" => Auth::user()->id]);
        return [
            "user_id" => ["required", "exists:users,id", $this->bidderAndOwnerRule],
            "product_id" => "required|string|exists:products,id,status,1,approved,1",
            "bid_amount" => [$this->bidAmountRule],
        ];
    }

    protected function update(): array
    {
        $storeRule = $this->store();
        return $storeRule;
    }
}
