<?php

namespace App\Listeners;

use App\Mail\PaymentReceiptMail;
use App\Mail\PaymentSuccessMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentListener implements ShouldQueue
{
    public function __construct()
    {
    }

    public function sendEmailNotification(mixed $data) {
        \Mail::to($data["product_owner_email"])->send(new PaymentSuccessMail($data));
        \Mail::to($data["user_email"])->send(new PaymentReceiptMail($data));
    }
}
