<?php

namespace App\Http\Services;

use App\Core\Traits\ImageUpload;
use App\Enums\ImageTypeEnums;
use App\Enums\RolesEnum;
use App\Exceptions\DeleteForbiddenException;
use App\Exceptions\InvalidBidTimeException;
use App\Exceptions\InvalidPaymentStatusException;
use App\Exceptions\ProductIsLiveException;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserBidRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProductService
{
    use ImageUpload;

    public function __construct(
        protected ProductRepository $productRepository,
        protected CategoryRepository $categoryRepository,
        protected UserBidRepository $userBidRepository
    ) {
    }

    /**
     * List products
     *
     * @param array $filterable
     * @param array $relationships
     * @return object
     */
    public function index(array $filterable = [], array $relationships = []): object
    {
        $products = $this->productRepository->fetchAll($filterable, $relationships);

        return $products;
    }

    public function auctionHistoryIndexStoreFront(array $filterable = [], array $relationships = []): object
    {
        $products = $this->productRepository->auctionHistoryIndexStoreFront($filterable);

        return $products;
    }

    public function oldPaidAuction(): ?object
    {
        $oldPaidAuction = $this->productRepository->model::whereHas("bids",  function ($query) {
            $query->where("granted", 1)->where("paid", 1);
        })->get();

        return $oldPaidAuction;
    }

    public function oldUnPaidAuction(): ?object
    {
        $oldPaidAuction = $this->productRepository->model::whereHas("bids",  function ($query) {
            $query->where("granted", 1)->where("paid", 0);
        })->get();

        return $oldPaidAuction;
    }

    public function oldAuctionNoBids(): ?object
    {
        $currentDateTime = Carbon::now()->toDateTimeString();

        $oldPaidAuction = $this->productRepository->model::where("end_date", "<", $currentDateTime)
            ->orWhere("expired_early", 1)
            ->with(["bids"])
            ->get()
            ->filter(fn ($product) => $product->bids->isEmpty());

        return $oldPaidAuction;
    }

    public function approveProduct(string $productId): void
    {
        $this->productRepository->update(["approved" => 1], $productId);
    }

    public function updatePaymentStatus(
        string $productId,
        string $userId,
        int $paymentStatus
    ) {
        $userBidPaid = $this->userBidRepository->fetchPaidProduct($productId);
        $condition = ($paymentStatus == 1 && $userBidPaid);
        throw_unless(
            condition: ($paymentStatus == 0 || $paymentStatus == 1),
            exception: new InvalidPaymentStatusException("Invalid payment status")
        );
        throw_if(
            condition: $condition,
            exception:  new InvalidPaymentStatusException("Invalid operation! This product is already sold out and paid.")
        );

        $userBid = $this->userBidRepository->fetchByUserAndProduct($userId, $productId);
        $this->userBidRepository->update(["paid" => $paymentStatus], $userBid->id);
    }

    /**
     * Store cart rule
     *
     * @param array $data
     * @return Product
     */
    public function store(array $data): void
    {
        $folderName = ImageTypeEnums::PRODUCT->value;
        $subFolderName = $this->categoryRepository->fetch($data["category_id"])->name;
        $finalFolder = $folderName."/".$subFolderName;

        $data["image"] = $this->imageUpload($data["image"], $finalFolder);
        $data["user_id"] = Auth::user()->id;
        if (isset($data["price_limit"]) && $data["price_limit"] == 1) {
            $data["end_price"] = null;
        }
        $this->productRepository->store($data);
        // Event::dispatch("product.store.after", $data);
    }

    public function bidProduct(array $data): void
    {
        $currentDateTime = Carbon::now()->toDateTimeString();
        $productId = $data["product_id"];
        $product = $this->productRepository->fetch($productId);

        throw_if(
            condition: (
                $product->start_date > $currentDateTime
                || $product->end_date < $currentDateTime
                || $product->approved != 1
                || $product->status != 1
            ),
            exception: InvalidBidTimeException::class
        );
        $this->userBidRepository->updateOrStore([
            "user_id" => Auth::user()->id,
            "product_id" => $data["product_id"]
        ], $data);
    }

    /**
     * Show Product
     *
     * @param string $ProductId
     * @param array $relationships
     * @return Product
     */
    public function show(string $productId, array $relationships = []): Product
    {
        $product = $this->productRepository->fetch($productId, $relationships);

        $currentDateTime = Carbon::now()->toDateTimeString();

        $currentTopBidAmount = $product->topBids->first()?->bid_amount;
        $minBidIncrementAmount = $product->bid_increment_amount;

        if ($currentDateTime > $product->end_date) {
            $product = $this->makeWinner($product);
        } elseif(!$product->price_limit && $product->end_price) {
            $diffEndPriceToCurrentBid = $product->end_price - $currentTopBidAmount;
            if ($diffEndPriceToCurrentBid < (float) $minBidIncrementAmount) {
                $product = $this->makeWinner($product);
            }
        }

        return $product;
    }

    private function makeWinner(object $product): object
    {
        $topBidder = $product->topBids->where("granted", 1)->first();
        if (!$topBidder && $product->topBids->first()) {
            $topBidder = $product->topBids->first();
            $topBidder->granted = 1;
            $product->expired_early = 1;
            $product->save();
            $topBidder->save();
            $appUrl = env("APP_URL");
            $data = [
                "product_id" => $product->id,
                "product_name" => $product->name,
                "winner_name" => $topBidder->user->name,
                "winner_email" => $topBidder->user->email,
                "bid_amount" => $topBidder->bid_amount,
                "owner_name" => "{$product->user->name} ({$product->user->email})",
                "owner_email" => $product->user->email,
                "product_url" => "{$appUrl}/products/{$product->id}",
            ];
            Event::dispatch("winner.selected", [$data]);
        }
        $product->fresh();

        return $product;
    }

    /**
     * Update Product
     *
     * @param string $ProductId
     * @param array $data
     * @return Product
     */
    public function update(string $productId, array $data): Product
    {
        $product = $this->productRepository->fetch($productId);

        if (isset($data["price_limit"]) && $data["price_limit"] == 1) {
            $data["end_price"] = null;
        }
        throw_if(
            condition: ($product->is_live || $product->expired || $product->expired_early),
            exception: ProductIsLiveException::class
        );

        if (isset($data["image"])) {
            $folderName = ImageTypeEnums::PRODUCT->value;
            $subFolderName = $this->categoryRepository->fetch($product->category_id)->name;
            $finalFolder = $folderName."/".$subFolderName;
            $data["image"] = $this->imageUpload($data["image"], $finalFolder);
            $imagePathToDelete = $product->image;
            session()->put("filePathToDelete", $imagePathToDelete);
        }
        $product = $this->productRepository->update($data, $productId);

        return $product;
    }

   public function resubmitProduct(string $productId, array $data): Product
   {
       $product = $this->productRepository->fetch($productId);

       if (isset($data["price_limit"]) && $data["price_limit"] == 1) {
           $data["end_price"] = null;
       }
       throw_if(
            condition: (
                $product->is_live
                || $product->is_upcoming
                || !$product->approved
            ),
            exception: new ProductIsLiveException("Edit to this product is restricted.")
        );

        throw_if(
            condition: $product->expired && $product->bids->count() > 0,
            exception: new ProductIsLiveException("Edit to this product is restricted.")
        );

       if (isset($data["image"])) {
           $folderName = ImageTypeEnums::PRODUCT->value;
           $subFolderName = $this->categoryRepository->fetch($product->category_id)->name;
           $finalFolder = $folderName."/".$subFolderName;
           $data["image"] = $this->imageUpload($data["image"], $finalFolder);
           $imagePathToDelete = $product->image;
           session()->put("filePathToDelete", $imagePathToDelete);
       }
       $product = $this->productRepository->update($data, $productId);

       return $product;
   }

    /**
     * Deletes an existing cart rule
     *
     * @param string $Product
     * @return void
     */
    public function delete(string $productId): void
    {
        $record = $this->productRepository->fetch($productId);
        if (auth()->user()->role->slug != RolesEnum::SUPER_ADMIN->value) {
            throw_if(
                condition: ($record->is_live || $record->expired || $record->expired_early),
                exception: DeleteForbiddenException::class
            );
        }
        $this->productRepository->delete($productId);
        $this->deleteImageFile($record->image);
    }

    public function deleteImageFile(string $path)
    {
        $this->deleteImage($path);
    }
}
