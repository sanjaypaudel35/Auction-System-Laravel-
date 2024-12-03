<?php

namespace Sanjaypaudel\Esewa\Services;

use App\Repositories\UserBidRepository;

class EsewaService
{
    public function __construct()
    {
    }

    public function payWithEsewa(array $data)
    {
        return $data;
    }

    public function esewaPaymentVerification(array $data)
    {
        $refId = $data["refId"];
        $productId = $data["oid"];
        $scd = "EPAYTEST";
    }
}