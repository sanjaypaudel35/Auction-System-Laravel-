<?php

namespace App\Http\Controllers\admin;

use App\Core\Controllers\BaseController;
use App\Http\Requests\CategoryRequest;
use App\Http\Services\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends BaseController
{
    protected string $viewBasePath = "dashboard.category";
    protected string $baseRoute = "dashboard.categories";

    public function __construct(
        protected CategoryService $categoryService,
    ) {
        parent::__construct();
    }

    public function index(Request $request)
    {
        try {
            $filterable = $request->query();
            $filterable = array_merge([
                "no_paginate" => true,
                "sort_by" => "position",
                "sort_order" => "asc"
            ], $filterable);
            $categories = $this->categoryService->index($filterable);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $data = [];
        return view($this->viewBasePath.".index", compact("categories"));
    }

    public function create(Request $request)
    {
        try {
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        $function = __FUNCTION__;
        return view("dashboard.category.{$function}");
    }

    public function store(CategoryRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $this->categoryService->store($data);
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

    public function edit(Request $request, string $categoryId)
    {
        try {
            $category = $this->categoryService->show($categoryId);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        DB::commit();
        $function = __FUNCTION__;
        return view("dashboard.category.{$function}", compact("category"));
    }

    public function update(CategoryRequest $request, string $categoryId)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $this->categoryService->update($categoryId, $data);
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
            $category = $this->categoryService->show($categoryId);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        // return $this->successResponse(
        //     payload: $this->cartRuleResource->make($cartRule)
        // );
    }

    public function destroy(string $categoryId)
    {
        DB::beginTransaction();

        try {
            $this->categoryService->delete($categoryId);
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
