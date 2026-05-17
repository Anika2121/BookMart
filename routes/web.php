<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewHelpfulController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\SocialiteController;

// ── Homepage ───────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Dashboard redirect ─────────────────────────────────
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware('auth')->name('dashboard');

// ── Social Login ───────────────────────────────────────
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

// ── Book Routes — Public ───────────────────────────────
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/compare', [BookController::class, 'compare'])->name('books.compare');

// ── Book Routes — Seller Only (BEFORE {book} wildcard) ─
Route::middleware(['auth', 'seller.only'])->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});

// ── Book Show — Public (AFTER static routes) ───────────
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// ── Compare Routes — Auth ──────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/books/{book}/compare/add', [BookController::class, 'addToCompare'])->name('books.compare.add');
    Route::delete('/books/{book}/compare/remove', [BookController::class, 'removeFromCompare'])->name('books.compare.remove');
});

// ── Auth Middleware Routes ─────────────────────────────
Route::middleware('auth')->group(function () {

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
    Route::get('/received-orders', [OrderController::class, 'receivedOrders'])->name('orders.received');

    // Seller only — status update
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus')
        ->middleware('seller.only');

    // Buyer only — cancel (শুধু pending এ)
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])
        ->name('orders.cancel')
        ->middleware('buyer.only');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::get('/invoice/{order}', [PaymentController::class, 'downloadInvoice'])->name('payment.invoice');

    // Seller — Seller Only
    Route::middleware('seller.only')->group(function () {
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
        Route::patch('/seller/books/{book}/toggle', [SellerController::class, 'toggleAvailability'])->name('seller.toggle');
    Route::get('/seller/profile', [SellerController::class, 'profile'])->name('seller.profile');
Route::post('/seller/profile', [SellerController::class, 'updateProfile'])->name('seller.profile.update');
Route::post('/seller/password', [SellerController::class, 'updatePassword'])->name('seller.password.update');

Route::get('/seller/profile', [SellerController::class, 'profile'])->name('seller.profile');
Route::post('/seller/profile', [SellerController::class, 'updateProfile'])->name('seller.profile.update');
Route::post('/seller/password', [SellerController::class, 'updatePassword'])->name('seller.password.update');

        });

    // Buyer
    Route::prefix('buyer')->name('buyer.')->group(function () {
        Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [BuyerController::class, 'editProfile'])->name('profile');
        Route::post('/profile', [BuyerController::class, 'updateProfile'])->name('profile.update');
        Route::post('/delete-request', [BuyerController::class, 'requestDeletion'])->name('delete.request');
        Route::post('/cancel-delete', [BuyerController::class, 'cancelDeletion'])->name('delete.cancel');
    });

    // Addresses
    Route::prefix('addresses')->name('addresses.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::put('/{address}', [AddressController::class, 'update'])->name('update');
        Route::patch('/{address}/default', [AddressController::class, 'setDefault'])->name('default');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
    });

    // Reviews
    Route::post('/reviews/{bookId}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{review}/helpful', [ReviewHelpfulController::class, 'toggle'])->name('reviews.helpful');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{bookId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Coupon
    Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
    Route::delete('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');
});

// ── Payment Callbacks (No Auth) ────────────────────────
Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::post('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/mock-confirm', [PaymentController::class, 'mockConfirm'])->name('payment.mock.confirm');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');

// ── Admin Routes ───────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/ban', [AdminController::class, 'banUser'])->name('users.ban');
    Route::patch('/users/{user}/unban', [AdminController::class, 'unbanUser'])->name('users.unban');

    // Books
    Route::get('/books', [AdminController::class, 'books'])->name('books');
    Route::patch('/books/{book}/approve', [AdminController::class, 'approveBook'])->name('books.approve');
    Route::patch('/books/{book}/reject', [AdminController::class, 'rejectBook'])->name('books.reject');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::patch('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
});

// ── Auth Routes ────────────────────────────────────────
require __DIR__.'/auth.php';