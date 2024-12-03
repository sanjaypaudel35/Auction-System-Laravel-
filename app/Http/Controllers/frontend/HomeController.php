<?php

namespace App\Http\Controllers\frontend;

use App\Core\Controllers\BaseController;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    protected string $basePath = "frontend.pages";
    public function __construct(
        protected ProductRepository $productRepository
    ) {
        parent::__construct();
    }

    public function home(Request $request) {

        try {
            $products = $this->productRepository->fetchAll(with: ["topBids"]);
        } catch (Exception $exception) {
            return $this->handleException($exception);
        }

        $function = __FUNCTION__;
        return view("{$this->basePath}.{$function}", compact("products"));
    }

    public function pageNotFound() {
        $file = "404";
        return view("{$this->basePath}.{$file}");
    }
}
