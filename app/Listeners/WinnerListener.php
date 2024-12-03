<?php

namespace App\Listeners;

use App\Mail\PaymentReceiptMail;
use App\Mail\PaymentSuccessMail;
use App\Mail\WinnerDeclaredMail;
use Illuminate\Contracts\Queue\ShouldQueue;

class WinnerListener implements ShouldQueue
{
    public function __construct()
    {
    }

    public function sendWinnerNotification(mixed $data) {
        \Mail::to($data["owner_email"])->send(new WinnerDeclaredMail($data, true));
        \Mail::to($data["winner_email"])->send(new WinnerDeclaredMail($data));
    }
}
