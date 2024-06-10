<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HobbiesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Employee\ProductController as EmployeeProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'showDiscountedProducts'])->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/products/headphones', [ProductController::class, 'showHeadphones'])->name('products.headphones');
Route::get('/products/monitors', [ProductController::class, 'showMonitors'])->name('products.monitors');
Route::get('/products/phones', [ProductController::class, 'showPhones'])->name('products.phones');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hobbies Routes
    Route::resource('hobbies', HobbiesController::class);

    // Cities Routes
    Route::resource('cities', CitiesController::class);

    // Countries Routes
    Route::resource('countries', CountriesController::class);

    Route::resource('products', ProductController::class)->except(['index', 'show', 'search']); // Exclude routes that are outside the auth middleware

    // Admin User Management Routes
    Route::middleware('role:Administrator')->prefix('admin')->name('admin.')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('users/{id}/edit-roles', [UserController::class, 'editRoles'])->name('users.editRoles');
        Route::post('users/{id}/update-roles', [UserController::class, 'updateRoles'])->name('users.updateRoles');
        Route::resource('users', UserController::class)->except(['create', 'store', 'edit', 'update']);
        Route::resource('roles', RoleController::class)->except(['show']);
    });

    Route::middleware(['auth', 'role:Administrator|Employee'])->prefix('employee')->name('employee.')->group(function () {
        Route::resource('products', EmployeeProductController::class);
        Route::delete('products/images/{image}', [EmployeeProductController::class, 'destroyImage'])->name('products.destroyImage');
    });
});

Route::get('/api/cities', [CityController::class, 'index']);

require __DIR__ . '/auth.php';
