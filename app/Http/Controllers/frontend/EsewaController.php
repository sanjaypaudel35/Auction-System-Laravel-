<?php

namespace App\Http\Controllers\frontend;

use App\Core\Controllers\BaseController;
use App\Http\Services\EsewaService;
use Exception;
use Illuminate\Http\Request;

class EsewaController extends BaseController
{
    protected string $basePath = "frontend.pages.payments";
    public function __construct(
        protected EsewaService $esewaService
    ) {
        parent::__construct();
    }

    public function payWithEsewa(Request $request, string $userBidId)
    {
        try {
            $paymentData = $this->esewaService->payWithEsewaGetData($userBidId, ["product"]);
        } catch (Exception $exception) {
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        return view("{$this->basePath}.esewa", compact("paymentData"));
    }

    public function success(Request $request)
    {
        try {
            $requestQuery = $request->query();
            $this->esewaService->esewaPaymentVerification($requestQuery);
        } catch (Exception $exception) {
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        return view("{$this->basePath}.success");

    }

    public function failure(Request $request)
    {
        return view("{$this->basePath}.failure");
    }
}
