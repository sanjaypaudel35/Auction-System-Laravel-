<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\FundController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UserAuctionController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\profile\ProfileController as AdminProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get("dashboard/profile", [ProfileController::class, "edit"])->name("profile.edit");
Route::patch("dashboard/profile", [ProfileController::class, "update"])->name("profile.update");
Route::delete("dashboard/profile", [ProfileController::class, "destroy"])->name("profile.destroy");

Route::prefix("dashboard")
    ->middleware("dashboard")
    ->name("dashboard.")
    ->group(function () {
        Route::get("/", DashboardController::class)->name("dashboard");

        Route::get("/profile", [AdminProfileController::class, "editProfile"])->name("profile.edit");
        Route::post("/profile", [AdminProfileController::class, "updateProfile"])->name("profile.update");

        Route::resource("categories", CategoryController::class);
        Route::get("funds/transfer/pending", [FundController::class, "pendingFundTransfer"])->name("fund.transfer.pending");
        Route::get("funds/transfer/{user_bid}/mark_paid", [FundController::class, "updateTransferStatus"])->name("fund.transfer.paid");

        Route::resource("users", UsersController::class)->except(["create", "destroy"]);
        // Route::resource("users/{user_id}/auctions/live", [UsersController::class], "liveAuctions")->except(["create", "destroy"]);
        Route::get("users/{user_id}/auctions/live", [UserAuctionController::class, "liveAuctions"])->name("users.auction.live");
        Route::get("users/{user_id}/auctions/pending", [UserAuctionController::class, "pendingAuctions"])->name("users.auction.pending");
        Route::get("users/{user_id}/auctions/upcoming", [UserAuctionController::class, "upcomingAuctions"])->name("users.auction.upcoming");
        Route::get("users/{user_id}/auctions/history", [UserAuctionController::class, "auctionHistory"])->name("users.auction.history");
        Route::get("users/{user_id}/bids/live", [UserAuctionController::class, "liveBids"])->name("users.bid.live");
        Route::get("users/{user_id}/bids/history", [UserAuctionController::class, "bidHistory"])->name("users.bid.history");



        Route::get("users/{user_id}/delete-user-permanently", [UsersController::class, "destroy"])->name("users.destroy");
        Route::resource("admins", AdminController::class);
        Route::resource("products", ProductController::class);
        Route::get("pending/products", [ProductController::class, "pendingProducts"])->name("products.pending");
        Route::get("live/products", [ProductController::class, "liveProducts"])->name("products.live");
        Route::get("upcoming/products", [ProductController::class, "upcomingProducts"])->name("products.upcoming");
        Route::get("history/products", [ProductController::class, "auctionHistory"])->name("products.history");
        Route::get("products/{product_id}/users/{user_id}/bid/{payment_status}/payment-status", [ProductController::class, "updatePaymentStatus"])->name("bids.payment.status");

        Route::get("pending/products{product_id}/approval", [ProductController::class, "approve"])->name("products.pending.approve");

});

require __DIR__."/auth.php";
