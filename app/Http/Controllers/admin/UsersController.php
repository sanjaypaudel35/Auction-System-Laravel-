<?php

namespace App\Http\Controllers\admin;

use App\Core\Controllers\BaseController;
use App\Http\Requests\Auth\AdminUserRequest;
use App\Http\Requests\User\CustomerRequest;
use App\Http\Services\UserService;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends BaseController
{
    protected string $viewBasePath = "dashboard.users";
    protected string $baseRoute = "dashboard.users";

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
                "__eq_role_id" => Role::where("slug", "customer")->first()?->id,
            ], $filterable);
            $users = $this->userService->index($filterable);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return view($this->viewBasePath.".index", compact("users"));
    }

    public function store(AdminUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $this->userService->store($data);
        } catch (Exception $exception) {
            DB::rollBack();
            $message = $this->handleException($exception);
            return redirect()->back()->with("error", "Exceptions: {$message["message"]}");
        }

        DB::commit();
        return $this->successRedirect(
            message: $this->lang("create-successs"),
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

        DB::commit();
        $function = __FUNCTION__;
        return view("{$this->viewBasePath}.{$function}", compact("user"));
    }

    public function update(CustomerRequest $request, string $userId)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $this->userService->update($userId, $data);
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

    public function destroy(string $userId)
    {
        DB::beginTransaction();

        try {
            $this->userService->delete($userId);
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
