<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Event;
use App\Exceptions\PaymentFailed;
use App\Repositories\UserBidRepository;
use GuzzleHttp\Client;

class EsewaService
{
    public function __construct(
        protected UserBidRepository $userBidRepository
    ) {
    }

    public function payWithEsewaGetData(string $userBid, array $relationships = [])
    {
        $userBidWithProduct = $this->userBidRepository->fetch($userBid, $relationships);
        throw_if(
            condition: ($userBidWithProduct->paid == 1),
            exception: new PaymentFailed("Payment is already done")
        );
        $data = [
            "tAmt" => $userBidWithProduct->bid_amount,
            "amt" => $userBidWithProduct->bid_amount,
            "txAmt" => 0,
            "psc" => 0,
            "pdc" => 0,
            "scd" => "EPAYTEST",
            "pid" => $userBidWithProduct->id,
        ];

        return $data;
    }

    public function esewaPaymentVerification(array $data): void
    {
        $refId = $data["refId"];
        $userBidId = $data["oid"];
        $userBid = $this->userBidRepository->fetch($userBidId);
        $amountToBePaid = $this->userBidRepository->fetch($userBidId)?->bid_amount;
        $scd = "EPAYTEST";

        $data = [
            'amt' => $amountToBePaid,
            'rid' => $refId,
            'pid' => $userBidId,
            'scd' => $scd,
        ];

        $client = new Client();

        $response = $client->post("https://uat.esewa.com.np/epay/transrec", [
            "form_params" => $data
        ]);

        $statusCode = $response->getStatusCode();
        $responseContent = $response->getBody()->getContents();
        $xmlResponse = simplexml_load_string($responseContent);
        $responseCode = trim($xmlResponse->response_code);

        throw_unless(
            condition: ($responseCode == "Success" || $statusCode == "200"),
            exception: PaymentFailed::class,
        );

        $userBid->paid = 1;
        $userBid->save();

        $data = [
            "product_id" => $userBid->product_id,
            "product_name" => $userBid->product?->name,
            "user_name" => $userBid?->user?->name,
            "user_email" => $userBid?->user?->email,
            "bid_amount" => $userBid->bid_amount,
            "product_owner_email" => $userBid?->product->user?->email,
            "date" => $userBid->getFormattedBidDateAttribute(),
        ];

        Event::dispatch("payment.success", [$data]);
    }
}
