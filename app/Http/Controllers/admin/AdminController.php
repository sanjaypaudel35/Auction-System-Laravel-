<?php

namespace App\Http\Controllers\admin;

use App\Core\Controllers\BaseController;
use App\Http\Requests\Auth\AdminUserRequest;
use App\Http\Services\UserService;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends BaseController
{
    protected string $viewBasePath = "dashboard.admins";
    protected string $baseRoute = "dashboard.admins";

    public function __construct(
        protected UserService $userService,
    ) {
        parent::__construct();
    }

    public function index(Request $request)
    {
        try {
            $filterable = $request->query();
            $filterable = array_merge([
                "__eq_role_id" => Role::where("slug", "super-admin")->first()?->id,
            ], $filterable);
            $users = $this->userService->index($filterable, ["createdBy"]);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return view($this->viewBasePath.".index", compact("users"));
    }

    public function create(Request $request)
    {
        $this->allow(__FUNCTION__);
        try {
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        $function = __FUNCTION__;
        return view("{$this->viewBasePath}.{$function}");
    }

    public function store(AdminUserRequest $request)
    {
        $this->allow(__FUNCTION__);
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $this->userService->store($data);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        DB::commit();
        return $this->successRedirect(
            message: $this->lang("create-success"),
            redirectRoute: "{$this->baseRoute}.index"
        );
    }

    public function edit(Request $request, string $userId)
    {
        try {
            $user = $this->userService->show($userId);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $function = __FUNCTION__;
        return view("{$this->viewBasePath}.{$function}", compact("user"));
    }

    public function update(CategoryRequest $request, string $categoryId)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $this->userService->update($categoryId, $data);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        DB::commit();
        return $this->successRedirect(
            message: $this->lang("update-success"),
            redirectRoute: "{$this->baseRoute}.index"
        );
    }

    public function show(string $categoryId)
    {
        try {
            $category = $this->userService->show($categoryId);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        // return $this->successResponse(
        //     payload: $this->cartRuleResource->make($cartRule)
        // );
    }

    public function destroy(string $admin)
    {
        $this->allow(__FUNCTION__);
        DB::beginTransaction();

        try {
            $this->userService->delete($admin);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exception: {$message["message"]}");
        }

        DB::commit();
        return $this->successRedirect(
            message: $this->lang("delete-success"),
            redirectRoute: "{$this->baseRoute}.index"
        );
    }
}
