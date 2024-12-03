<?php

namespace App\Http\Controllers\admin\profile;

use DB;
use Exception;
use App\Core\Controllers\BaseController;
use App\Http\Requests\AdminProfileUpdateRequest;
use App\Http\Services\ProfileService;

class ProfileController extends BaseController
{
    protected string $viewBasePath = "dashboard.profile";

    public function __construct(
        protected ProfileService $profileService
    ) {
    }

    public function editProfile()
    {
        try {
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        return view("{$this->viewBasePath}.edit");
    }

    public function updateProfile(AdminProfileUpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $this->profileService->updateProfile($data);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->handleException($exception);
        }

        DB::commit();
        return $this->successRedirect(
            redirectRoute: "{$this->viewBasePath}.edit",
            message: "Profile updated successfully"
        );
    }
}
