<?php

namespace App\Jobs;

use App\Http\Services\ProductService;
use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleProductBidEnds
{
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        ProductService $productService,
        ProductRepository $productRepository
    ): void
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $products = $productRepository->fetchAll([
            "__eq_approved" => 1,
            "__eq_status" => 1,
            "__lte_start_date" => $currentDateTime,
        ]);
        foreach ($products as $product) {
            $productService->show($product->id, ["topBids.user"]);
        }
    }
}
