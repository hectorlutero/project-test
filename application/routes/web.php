<?php

use App\Helpers\RouterHelper;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StoreController;

use Illuminate\Support\Facades\Route;

// Route::redirect('/', 'login');
Route::view('/', 'home')->name('home');
Route::view('/busca', 'search-page');
Route::get("/busca/", [SearchController::class, 'search'])->name("search.index");

Route::get('/loja/{companySlug}/produtos/{productSlug}', [StoreController::class, 'showProduct'])
    ->name('store.product.show');
Route::get('/loja/{companySlug}/service/{serviceSlug}', [StoreController::class, 'showService'])
    ->name('store.service.show');
Route::get('/loja/{companySlug}/', [StoreController::class, 'showCompany'])
    ->name('store.company.show');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get("/read-all-notifications", [])->name('user.read-all-notifications');

    Route::middleware('check.admin.user')->prefix('admin')->group(function () {

        RouterHelper::addAdminRouteBlock("admin.role", "RolesController");
        RouterHelper::addAdminRouteBlock('admin.plans', "PlansController");
        RouterHelper::addAdminRouteBlock("admin.company", "CompaniesController");
        RouterHelper::addAdminRouteBlock("admin.product", "ProductsController");
        RouterHelper::addAdminRouteBlock("admin.service", "ServicesController");
        RouterHelper::addAdminRouteBlock("admin.services-categories", "ServicesCategoriesController");
        RouterHelper::addAdminRouteBlock("admin.products-categories", "ProductsCategoriesController");
        RouterHelper::addAdminRouteBlock("admin.services-tags", "ServicesTagsController");
        RouterHelper::addAdminRouteBlock("admin.products-tags", "ProductsTagsController");
        RouterHelper::addAdminRouteBlock("admin.midia", "MediasController");
        RouterHelper::addAdminRouteBlock("admin.company-categories", "CompanyCategoryController");
        RouterHelper::addAdminRouteBlock("admin.user", "UserController");

        Route::get("/company/manage-ban/{id}", [CompaniesController::class, 'manageBan'])->name('admin.company.manage-ban');

    });

    Route::middleware('role:client')->prefix('client')->group(function () {
        RouterHelper::addCustomerRouteBlock("customer.user", "BePartnerController");
    });

    Route::middleware('role:partner')->prefix('partner')->group(function () {
        RouterHelper::addPartnerRouteBlock("partner.business", "BusinessController");
        RouterHelper::addPartnerRouteBlock("partner.product", "ProductsController");
        RouterHelper::addPartnerRouteBlock("partner.service", "ServicesController");
        RouterHelper::addPartnerRouteBlock("partner.midia", "MediasController");
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::fallback(function () {
        return view('pages/utility/404');
    });
});


require __DIR__ . '/auth.php';