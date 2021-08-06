<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth
Route::get('/vendor', 'Auth\VendorLoginController@showLoginForm');
Route::get('/vendor/register', 'Auth\VendorRegisterController@showRegistrationForm')->name('vendor.register');
Route::post('/vendor/register', 'Auth\VendorRegisterController@createVendor')->name('vendor.register.post');
Route::get('/vendor/login', 'Auth\VendorLoginController@showLoginForm')->name('vendor.login');
Route::post('/vendor/login', 'Auth\VendorLoginController@login')->name('vendor.login.post');
Route::post('/vendor/logout', '\App\Http\Controllers\Auth\VendorLoginController@logout')->name('vendor.logout');

Route::get('/vendor/password/reset', 'Auth\VendorForgotPasswordController@showLinkRequestForm')->name('vendor.password.request');
Route::post('/vendor/password/email', 'Auth\VendorForgotPasswordController@sendResetLinkEmail')->name('vendor.password.email');
Route::get('/vendor/password/reset/{token}', 'Auth\VendorResetPasswordController@showResetForm')->name('vendor.password.reset');
Route::post('/vendor/password/reset', 'Auth\VendorResetPasswordController@reset')->name('vendor.password.update');

// Route::get('/vendor/email/verify', 'Auth\VendorVerificationController@show')->name('vendor.verification.notice');
// Route::get('/vendor/email/verify/{id}/{hash}', 'Auth\VendorVerificationController@verify')->name('vendor.verification.verify');
// Route::post('/vendor/email/resend', 'Auth\VendorVerificationController@resend')->name('vendor.verification.resend');

Route::group(['prefix' => 'vendor', 'middleware' => ['auth:vendor','verified','active_user'],'namespace' =>'Vendor' ], function () {
    //welcome
    Route::get('/welcome','\App\Http\Controllers\Auth\VendorLoginController@welcome')->name('vendor-welcome');

    //product
    Route::get('/product','ProductController@Product')->name('vendor-product');
    Route::get('/product/pending','ProductController@ProductNotVerified')->name('vendor-product-pending');
    Route::get('/product/verified','ProductController@ProductVerified')->name('vendor-product-verified');
    Route::get('/product/add','ProductController@ShowAddproduct')->name('show-vendor-add-product');
    Route::post('/product/add','ProductController@Addproduct')->name('vendor-add-product');
    Route::get('/product/update/{id?}', 'ProductController@ShowUpdateProduct')->name("show-vendor-update-product");
    Route::post('/product/update/{id?}', 'ProductController@Updateproduct')->name("vendor-update-product");

    //dashboard
    Route::get('/dashboard', 'StatisticsController@Dashboard')->name('vendor-dashboard');
    Route::get('/top-sales', 'StatisticsController@TopSales')->name('vendor-top-sales');

    //order
    Route::get('/order/to-verify', 'OrderController@OrderToVerify')->name('vendor-order-to-verify');
    Route::get('/order/waiting-approval', 'OrderController@WaitingApproval')->name('vendor-order-waiting-approval');
    Route::get('/order/clarified', 'OrderController@OrderClarified')->name('vendor-order-clarified');
    Route::get('/order/canceled', 'OrderController@OrderCanceled')->name('vendor-order-canceled');
    Route::get('/order/finished', 'OrderController@OrderCompleted')->name('vendor-order-finished');
    Route::get('/order/approved', 'OrderController@OrderApproved')->name('vendor-order-approved');

    Route::get('/order/to-verify/{id?}', 'OrderController@OrderShow')->name('vendor-order-show');
    Route::get('/order/clarify/{id?}', 'OrderController@OrderShowClarify')->name('vendor-order-show-clarify');
    Route::get('/order/shipped/{id?}', 'OrderController@OrderShowShipped')->name('vendor-order-show-shipped');
    Route::get('/order/approved/{id?}', 'OrderController@OrderShowApproved')->name('vendor-order-show-approved');
    Route::get('/order/finished/{id?}', 'OrderController@OrderShowFinished')->name('vendor-order-show-finished');
    Route::get('/order/canceled/{id?}', 'OrderController@OrderShowCanceled')->name('vendor-order-show-canceled');

    Route::post('/order/deny/{id?}', 'OrderController@Deny')->name("vendor-order-deny");
    Route::post('/order/approve/{id?}', 'OrderController@Approve')->name('vendor-order-approve');
    Route::post('/order/shippe/{id?}', 'OrderController@shippe')->name('vendor-order-shippe');
    Route::post('/order/finish/{id?}', 'OrderController@finish')->name('vendor-order-finish');

    Route::post('/order/clarified', 'OrderController@clarify')->name('show-vendor-order-clarify');
    Route::post('/order/clarify/{id?}', 'OrderController@clarify')->name('vendor-order-clarify');
    Route::get('/order/waiting-shipping', 'OrderController@WaitingShipping')->name('vendor-order-waiting-shipping');
    Route::post('/order/add-status/{id?}', 'OrderController@addOrderStatus')->name('vendor-order-add-status');

    //employee
    Route::get('/employee', 'EmployeeController@Employee')->name('vendor-employee-list');
    Route::get('/employee/add', 'EmployeeController@ShowAddEmployee')->name('show-vendor-employee-add');
    Route::post('/employee/add', 'EmployeeController@EmployeeAdd')->name('vendor-employee-add');
    Route::get('/employee/{id?}', 'EmployeeController@EmployeeShow')->name('vendor-employee-show');
    Route::post('/employee/{id?}', 'EmployeeController@EmployeeUpdate')->name('vendor-employee-update');

    //role
    Route::get('/role', 'EmployeeController@Role')->name('vendor-role-list');
    Route::get('/role/add', 'EmployeeController@ShowAddRole')->name('show-vendor-role-add');
    Route::post('/role/add', 'EmployeeController@RoleAdd')->name('vendor-role-add');
    Route::get('/role/{id?}', 'EmployeeController@RoleShow')->name('vendor-role-show');
    Route::post('/role/{id?}', 'EmployeeController@RoleUpdate')->name('vendor-role-update');

    //permission
    Route::get('/permission', 'EmployeeController@Permission')->name('vendor-permission-list');
    Route::get('/permission/add', 'EmployeeController@ShowAddPermission')->name('show-vendor-permission-add');
    Route::post('/permission/add', 'EmployeeController@PermissionAdd')->name('vendor-permission-add');
    Route::get('/permission/{id?}', 'EmployeeController@PermissionShow')->name('vendor-permission-show');
    Route::post('/permission/{id?}', 'EmployeeController@PermissionUpdate')->name('vendor-permission-update');

    //manufacturer
    Route::get('/manufacturer', 'ManufacturerController@manufacturer')->name('vendor-manufacturer-list');
    Route::get('/manufacturer/add', 'ManufacturerController@showAddManufacturer')->name('show-vendor-manufacturer-add');
    Route::post('/manufacturer/add', 'ManufacturerController@addManufacturer')->name('vendor-manufacturer-add');
    Route::get('/manufacturer/{id?}', 'ManufacturerController@showUpdateManufacturer')->name('vendor-manufacturer-show');
    Route::post('/manufacturer/{id?}', 'ManufacturerController@updateManufacturer')->name('vendor-manufacturer-update');
    
    //supplier
    Route::get('/supplier', 'SupplierController@supplier')->name('vendor-supplier-list');
    Route::get('/supplier/add', 'SupplierController@showAddSupplier')->name('show-vendor-supplier-add');
    Route::post('/supplier/add', 'SupplierController@addSupplier')->name('vendor-supplier-add');
    Route::get('/supplier/{id?}', 'SupplierController@showUpdateSupplier')->name('vendor-supplier-show');
    Route::post('/supplier/{id?}', 'SupplierController@updateSupplier')->name('vendor-supplier-update');

    //suggest category
    Route::get('/category', 'CategoryController@category')->name('vendor-category-list');
    Route::get('/category/add', 'CategoryController@showAddCategory')->name('show-vendor-category-add');
    Route::post('/category/add', 'CategoryController@addCategory')->name('vendor-category-add');
    Route::get('/category/{id?}', 'CategoryController@showUpdateCategory')->name('vendor-category-show');
    Route::post('/category/{id?}', 'CategoryController@updateCategory')->name('vendor-category-update');
 
    //invoice
    Route::get('/invoice', 'InvoiceController@invoice')->name('vendor-invoice-list');
    Route::get('/invoice/{id?}', 'InvoiceController@showInvoice')->name('vendor-invoice-show');
    Route::get('/invoice-search','InvoiceController@search')->name('vendor-invoice-search');
    Route::get('/invoice/pdf/{id?}','InvoiceController@printInvoicePDF')->name('vendor-invoice-pdf');
    Route::get('/invoice/create/{id?}','InvoiceController@createInvoice')->name('vendor-invoice-create');

    Route::get('/documents/pdf-document/{id}', 'AccountController@getDocument')->name('vendor-document');

    //order depot
    Route::get('/orders/finished', 'OrderDepotController@OrderCompleted')->name('vendor-order-depot-finished');
    Route::get('/orders/approved', 'OrderDepotController@OrderApproved')->name('vendor-order-depot-approved');
    Route::get('/orders/shipped', 'OrderDepotController@WaitingShipping')->name('vendor-order-depot-shipped');
    Route::get('/orders/setdelivery/{id}/{method}', 'OrderDepotController@SetDeliveyMethod')->name('vendor-order-depot-set-delivery');
    Route::get('/orders/removedelivery/{id}', 'OrderDepotController@RemoveDeliveyMethod')->name('vendor-order-depot-remove-delivery');
    // Route::post('/orders/delivery/{id}/ariba', 'OrderDepotController@SetDeliveyMethodAriba')->name('vendor-order-depot-delivery-ariba');
   
    Route::get('/orders/courier', 'OrderDepotController@GetCourier')->name('vendor-order-depot-courier');

    Route::get('/orders/shipped/{id?}', 'OrderDepotController@OrderShowShipped')->name('vendor-order-depot-show-shipped');
    Route::get('/orders/approved/{id?}', 'OrderDepotController@OrderShowApproved')->name('vendor-order-depot-show-approved');
    Route::get('/orders/finished/{id?}', 'OrderDepotController@OrderShowFinished')->name('vendor-order-depot-show-finished');

    Route::post('/orders/shippe/{id?}', 'OrderDepotController@shippe')->name('vendor-order-depot-shippe');
    Route::post('/orders/finish/{id?}', 'OrderDepotController@finish')->name('show-vendor-order-depot-finish');
    Route::post('/order/cancel/{id?}', 'OrderDepotController@cancel')->name("vendor-order-depot-cancel");

    Route::get('/orders/finish/{id?}', 'OrderDepotController@finish')->name('vendor-order-depot-finish');

    // Vendor Stock
      Route::get('/stock/search-product','StockController@showSearch')->name('vendor-stock-search-product');
      Route::get('/stock/get-product-list','StockController@productList')->name('vendor-stock-get-product-list');
      Route::get('/stock/get-product/{id?}','StockController@searchforplace')->name('vendor-stock-get-product');
      Route::get('/stock/give_place', 'StockController@give_place')->name('vendor-give_place');
      Route::get('/stock/place_save', 'StockController@place_save')->name('vendor-place_save');
      Route::post('/stock/stock_save/{id?}', 'StockController@stock_save')->name('vendor-stock_save');
      Route::post('/stock/update_stocks/{id?}', 'StockController@update_stocks')->name('vendor-update_stocks');

    //Vendor Review
    Route::get('/review', 'ReviewVendorController@review')->name('vendor-review');

    //Product Review
    Route::get('/product/review', 'ReviewProductController@review')->name('vendor-product-review');
    
});

Route::group(['prefix' => 'vendor', 'middleware' => ['auth:vendor','verified','active_user'],'namespace' =>'Vendor' ], function () {
    //account
    Route::get('/account', 'AccountController@account')->name('vendor-account');
    Route::get('/account/edit', 'AccountController@showUpdateAccount')->name('show-vendor-account-update');
    Route::post('/account/edit', 'AccountController@UpdateAccount')->name('vendor-account-update');
});

