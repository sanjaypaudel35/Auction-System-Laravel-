<?php

use App\Http\Controllers\frontend\EsewaController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\ProfileController;
use App\Http\Controllers\ProfileController as SystemProfileController;
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

Route::middleware("web")
    ->group(function () {
        Route::get("/", [ProductController::class, "index"])->name("products.index");
        Route::get("/404", [HomeController::class, "pageNotFound"])->name("page.not.found");
        Route::resource('products', ProductController::class)->except(["index", "store"]);
        Route::resource('products', ProductController::class)->except(["index", "store"]);

        Route::prefix("auctions")
            ->name("auctions.")
            ->group(function () {
                Route::get('live', [ProductController::class, "liveAuctions"])->name("live");
                Route::get('upcoming', [ProductController::class, "upcomingAuctions"])->name('upcoming');
                Route::get('history',  [ProductController::class, "auctionsHistory"])->name('history');
            }
        );
    }
);

Route::get("/checkout/payment/esewa/success", [EsewaController::class, "success"])->name("payment.esewa.success");
Route::get("/checkout/payment/esewa/failure", [EsewaController::class, "failure"])->name("payment.esewa.failure");
//protected route
Route::middleware(["frontend", "verified"])
    ->group(function () {
        Route::get("/checkout/payment/esewa/{user_bid_id}", [EsewaController::class, "payWithEsewa"])->name("payment.esewa");
        Route::get("/profile/info", [ProfileController::class, "profileInfo"])->name("profile.account.info");
        Route::get("/profile/edit", [ProfileController::class, "editProfile"])->name("profile.account.edit");
        Route::get("/profile/update-password", [ProfileController::class, "editPassword"])->name("profile.account.password.edit");
        Route::patch("/profile/update-password", [ProfileController::class, "updatePassword"])->name("profile.account.password.edit");
        Route::patch("/profile", [ProfileController::class, "updateProfile"])->name("profile.account.update");
        Route::delete("/profile", [ProfileController::class, "destroy"])->name("profile.account.destroy");

        Route::post('products/create', [ProductController::class, "store"])->name("products.store");
        Route::put('products/{product_id}/update', [ProductController::class, "update"])->name("products.update");
        Route::post('products/auction/bid', [ProductController::class, "bidProduct"])->name("products.bid");
        Route::prefix("profile")
            ->name("profile.")
            ->group(function () {
                Route::prefix("bids")
                    ->name("products.")
                    ->group(function () {
                        Route::get("{product}/edit", [ProfileController::class, "editProduct"])->name("edit");
                        Route::get("{product}/resubmit", [ProfileController::class, "resubmitProduct"])->name("resubmit");
                        Route::put("{product}/resubmit", [ProfileController::class, "putResubmitProduct"])->name("put.resubmit");

                        Route::get("{product}/delete", [ProfileController::class, "deleteProduct"])->name("delete");
                        Route::get("live", [ProfileController::class, "liveProducts"])->name("live");
                        Route::get("pending", [ProfileController::class, "pendingProducts"])->name("pending");
                        Route::get("upcoming", [ProfileController::class, "upcomingProducts"])->name("upcoming");
                        Route::get("expired", [ProfileController::class, "expiredProducts"])->name("expired");
                        Route::get("", [ProfileController::class, "profileBids"])->name("bids");
                    }
                );
                Route::get("/", [ProfileController::class, "profile"])->name("account");
            }
        );
    }
);

require __DIR__.'/auth.php';
