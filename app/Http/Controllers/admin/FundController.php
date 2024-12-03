<?php

namespace App\Http\Controllers\admin;

use App\Core\Controllers\BaseController;
use Exception;
use App\Http\Services\FundTransferService;
use Illuminate\Http\Request;

class FundController extends BaseController
{
    protected string $viewBasePath = "dashboard.funds";

    public function __construct(
        protected FundTransferService $fundTransferService
    ) {
    }

    public function pendingFundTransfer(Request $request)
    {
        try {
            $filterable = $request->query();
            $userBids = $this->fundTransferService->pendingFundTransfer($filterable);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return view("{$this->viewBasePath}.pending", compact("userBids"));
    }

    public function updateTransferStatus(string $userBidId)
    {
        try {
            $this->fundTransferService->updateTransferStatus($userBidId);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return redirect()->back()->with("success", "Mark as transferred successfully.");
    }
}
