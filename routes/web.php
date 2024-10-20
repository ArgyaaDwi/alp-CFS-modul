<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryLubricantController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\FGMController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\QMController;
use App\Http\Controllers\SalesManagerController;
use App\Http\Controllers\SubCategoryLubricantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',  [AuthController::class, 'login'])->name('login');
Route::post('/login',  [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/register',  [AuthController::class, 'register'])->name('register');
Route::post('/register',  [AuthController::class, 'registerProcess'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/waiting', [MainController::class, 'waiting'])->name('waiting');

Route::middleware(['auth', 'user-access:1', 'check-verified'])->group(function () {
    Route::get('/dashboard/sales', [MainController::class, 'dashboardSalesManager'])->name('dashboard.sales');
    // Route untuk kebutuhan kelola distributor
    Route::get('/sales/view_distributor', [SalesManagerController::class, 'viewDistributor'])->name('sales.distributor.index');
    Route::get('/sales/detail_distributor/{id}', [SalesManagerController::class, 'detailDistributor'])->name('sales.distributor.detail');
    Route::get('/sales/add_distributor', [SalesManagerController::class, 'addDistributor'])->name('sales.distributor.add');
    Route::post('/sales/save_distributor', [SalesManagerController::class, 'saveDistributor'])->name('sales.distributor.save');
    Route::get('/sales/edit_distributor/{id}', [SalesManagerController::class, 'editDistributor'])->name('sales.distributor.edit');
    Route::put('/sales/update_distributor/{id}', [SalesManagerController::class, 'updateDistributor'])->name('sales.distributor.update');
    Route::delete('/sales/delete_distributor/{id}', [SalesManagerController::class, 'deleteDistributor'])->name('sales.distributor.delete');
    // Route untuk kebutuhan kelola complaint
    Route::get('/sales/view_complaint', [SalesManagerController::class, 'viewComplaint'])->name('sales.complaint.index');
    Route::get('/sales/detail_complaint/{id}', [SalesManagerController::class, 'detailComplaint'])->name('sales.complaint.detail');
    Route::get('sales/add_complaint', [SalesManagerController::class, 'addComplaint'])->name('sales.complaint.add');
    Route::post('sales/save_complaint', [SalesManagerController::class, 'saveComplaint'])->name('sales.complaint.save');
    Route::get('sales/edit_complaint/{id}', [SalesManagerController::class, 'editComplaint'])->name('sales.complaint.edit');
    Route::put('sales/update_complaint/{id}', [SalesManagerController::class, 'updateComplaint'])->name('sales.complaint.update');
    Route::delete('sales/delete_complaint/{id}', [SalesManagerController::class, 'deleteComplaint'])->name('sales.complaint.delete');
});
Route::middleware(['auth', 'user-access:2'])->group(function () {
    Route::get('/dashboard/admin',  [MainController::class, 'dashboardAdmin'])->name('dashboard.admin');
    // Route untuk kebutuhan kelola user
    Route::get('admin/view_user', [UserController::class, 'viewUser'])->name('admin.user.index');
    Route::get('admin/detail_user/{id}', [UserController::class, 'detailUser'])->name('admin.user.detail');
    Route::get('admin/add_user', [UserController::class, 'addUser'])->name('admin.user.add');
    Route::post('admin/save_user', [UserController::class, 'saveUser'])->name('admin.user.save');
    Route::get('admin/edit_user/{id}', [UserController::class, 'editUser'])->name('admin.user.edit');
    Route::put('admin/update_user/{id}', [UserController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('admin/delete_user/{id}', [UserController::class, 'deleteUser'])->name('admin.user.delete');
    Route::put('/admin/distributor/{id}/verificationUser', [UserController::class, 'verificationUser'])->name('admin.distributor.verification');
    Route::put('/admin/distributor/{id}/updateStatus', [UserController::class, 'updateStatusUser'])->name('admin.distributor.updateStatus');
    // Route untuk kebutuhan kelola distributor
    Route::get('admin/view_distributor', [DistributorController::class, 'viewDistributor'])->name('admin.distributor.index');
    Route::get('admin/detail_distributor/{id}', [DistributorController::class, 'detailDistributor'])->name('admin.distributor.detail');
    Route::get('admin/add_distributor', [DistributorController::class, 'addDistributor'])->name('admin.distributor.add');
    Route::post('admin/save_distributor', [DistributorController::class, 'saveDistributor'])->name('admin.distributor.save');
    Route::get('admin/edit_distributor/{id}', [DistributorController::class, 'editDistributor'])->name('admin.distributor.edit');
    Route::put('admin/update_distributor/{id}', [DistributorController::class, 'updateDistributor'])->name('admin.distributor.update');
    Route::delete('admin/delete_distributor/{id}', [DistributorController::class, 'deleteDistributor'])->name('admin.distributor.delete');

    // Route untuk kebutuhan kelola kategori pelumas
    Route::get('admin/view_category_lub', [CategoryLubricantController::class, 'viewCategoryLubricant'])->name('admin.category.index');
    Route::get('admin/add_category_lub',  [CategoryLubricantController::class, 'addCategoryLubricant'])->name('admin.category.add');
    Route::post('admin/save_category_lub',  [CategoryLubricantController::class, 'saveCategoryLubricant'])->name('admin.category.save');
    Route::get('admin/edit_category_lub/{id}',  [CategoryLubricantController::class, 'editCategoryLubricant'])->name('admin.category.edit');
    Route::put('admin/update_category_lub/{id}',  [CategoryLubricantController::class, 'updateCategoryLubricant'])->name('admin.category.update');
    Route::delete('admin/delete_category_lub/{id}',  [CategoryLubricantController::class, 'deleteCategoryLubricant'])->name('admin.category.delete');

    // Route untuk kebutuhan kelola subkategori pelumas
    Route::get('admin/view_subcategory_lub', [SubCategoryLubricantController::class, 'viewSubCategoryLubricant'])->name('admin.subcategory.index');
    Route::get('admin/add_subcategory_lub',  [SubCategoryLubricantController::class, 'addSubCategoryLubricant'])->name('admin.subcategory.add');
    Route::post('admin/save_subcategory_lub',  [SubCategoryLubricantController::class, 'saveSubCategoryLubricant'])->name('admin.subcategory.save');
    Route::get('admin/edit_subcategory_lub/{id}',   [SubCategoryLubricantController::class, 'editSubCategoryLubricant'])->name('admin.subcategory.edit');
    Route::put('admin/update_subcategory_lub/{id}',  [SubCategoryLubricantController::class, 'updateSubCategoryLubricant'])->name('admin.subcategory.update');
    Route::delete('admin/delete_subcategory_lub/{id}',  [SubCategoryLubricantController::class, 'deleteSubCategoryLubricant'])->name('admin.subcategory.delete');

    // Route untuk kebutuhan kelola produk pelumas
    Route::get('admin/view_product_lub', [ProductController::class, 'viewProductLubricant'])->name('admin.product.index');
    Route::get('admin/detail_product_lub/{id}', [ProductController::class, 'detailProductLubricant'])->name('admin.product.detail');
    Route::get('admin/add_product_lub',  [ProductController::class, 'addProductLubricant'])->name('admin.product.add');
    Route::post('admin/save_product_lub',  [ProductController::class, 'saveProductLubricant'])->name('admin.product.save');
    Route::get('admin/edit_product_lub/{id}',  [ProductController::class, 'editProductLubricant'])->name('admin.product.edit');
    Route::put('admin/update_product_lub/{id}',  [ProductController::class, 'updateProductLubricant'])->name('admin.product.update');
    Route::delete('admin/delete_product_lub/{id}',  [ProductController::class, 'deleteProductLubricant'])->name('admin.product.delete');

    // Route untuk kebutuhan kelola transaksi
    Route::get('admin/view_transaction', [TransactionController::class, 'viewTransaction'])->name('admin.transaction.index');
    Route::get('admin/detail_transaction/{id}', [TransactionController::class, 'detailTransaction'])->name('admin.transaction.detail');
    Route::delete('admin/delete_transaction/{id}', [TransactionController::class, 'deleteTransaction'])->name('admin.transaction.delete');
    // Ajax
    Route::get('/get-subcategory/{categoryId}', [ProductController::class, 'getSubCategoryLubricant'])->name('admin.ajax.getSubCategoryLubricant');

    // Route untuk kebutuhan kelola aduan
    Route::get('admin/view_complaint', [ComplaintController::class, 'viewComplaint'])->name('admin.complaint.index');
    Route::get('admin/detail_complaint/{id}', [ComplaintController::class, 'detailComplaint'])->name('admin.complaint.detail');
});
Route::middleware(['auth', 'user-access:3'])->group(function () {
    Route::get('/dashboard/qm',  [MainController::class, 'dashboardQualityManager'])->name('dashboard.qm');
    Route::get('qm/view_complaint', [QMController::class, 'viewComplaint'])->name('qm.complaint.index');
    ROute::get('qm/detail_complaint/{id}', [QMController::class, 'detailComplaint'])->name('qm.complaint.detail');
    Route::put('qm/updatestatuscomplaint/{id}', [QMController::class, 'updateComplaintStatus'])->name('qm.update.status');
});
Route::middleware(['auth', 'user-access:4'])->group(function () {
    Route::get('/dashboard/fgm',  [MainController::class, 'dashboardFGM'])->name('dashboard.fgm');
    Route::get('fgm/view_complaint', [FGMController::class, 'viewComplaint'])->name('fgm.complaint.index');
    Route::get('fgm/detail_complaint/{id}', [FGMController::class, 'detailComplaint'])->name('fgm.complaint.detail');
    Route::put('fgm/updatestatuscomplaint/{id}', [FGMController::class, 'updateComplaintStatus'])->name('fgm.update.status');
});
