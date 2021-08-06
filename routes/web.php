<?php


use App\User;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;

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

Route::group(['prefix' => 'admin', 'middleware' => ['auth:web','fw-block-blacklisted','fw-block-attacks'] ], function () {
    
    //optimize
    Route::get('/optimize', 'Admin\ProductController@optimize')->name("optimize");

    //product
    Route::delete('/product/delete/{id?}', 'Admin\ProductController@Deleteproduct')->name("remove-product");
    Route::get('/product/add', 'Admin\ProductController@ShowAddproduct')->name("show-add-product");
    Route::post('/product/add', 'Admin\ProductController@Addproduct')->name("add-product");
    Route::get('/product/verify/{id?}', 'Admin\ProductController@ShowVerifyProduct')->name("show-verify-product");
    Route::post('/product/verify/{id?}', 'Admin\ProductController@VerifyProduct')->name("verify-product");
    Route::get('/product/update/{id?}', 'Admin\ProductController@ShowUpdateProduct')->name("show-update-product");
    Route::post('/product/update/{id?}', 'Admin\ProductController@Updateproduct')->name("update-product");
    Route::get('/product', 'Admin\ProductController@Product')->name('admin-product');
    Route::get('/product/pending', 'Admin\ProductController@ProductNotVerified')->name('product-pending');
    Route::get('/product/verified', 'Admin\ProductController@ProductVerified')->name('product-verified');
    Route::get('/product/check', 'Admin\ProductController@ProductCheck')->name('product-checked');

    //vendor
    Route::get('/vendor/add', 'Admin\VendorController@ShowAddVendor')->name("show-add-vendor");
    Route::post('/vendor/add', 'Admin\VendorController@AddVendor')->name("add-vendor");
    Route::post('/vendor/approve/{id?}', 'Admin\VendorController@Approve')->name("approve-vendor");
    Route::post('/vendor/disapprove/{id?}', 'Admin\VendorController@Disapprove')->name("disapprove-vendor");
    Route::get('/vendor/update/{id?}', 'Admin\VendorController@ShowUpdateVendor')->name("verify-vendor");
    Route::post('/vendor/update/{id?}', 'Admin\VendorController@UpdateVendor')->name("update-vendor");
    Route::get('/vendor', 'Admin\VendorController@Vendor')->name('vendor');
    Route::get('/vendor/first-approval', 'Admin\VendorController@VendorFirstApproval')->name('vendor-first-approval');
    Route::get('/vendor/second-approval', 'Admin\VendorController@VendorSecondApproval')->name('vendor-second-approval');
    Route::get('/vendor/pending', 'Admin\VendorController@VendorPending')->name('vendor-pending');
    Route::get('/vendor/verified', 'Admin\VendorController@VendorVerified')->name('vendor-verified');
    Route::get('/vendor/add/zones/{id?}', 'Admin\VendorController@GetZones')->name("get-zones");

    //sales Agent
    Route::post('/sales-agent/firstApprove/{id?}', '\App\Http\Controllers\Admin\SalesAgentController@FirstApprove')->name("first-approve-sales-agent");
    Route::post('/sales-agent/secondApprove/{id?}', '\App\Http\Controllers\Admin\SalesAgentController@SecondApprove')->name("second-approve-sales-agent");
    Route::post('/sales-agent/disapprove/{id?}', '\App\Http\Controllers\Admin\SalesAgentController@Disapprove')->name("disapprove-sales-agent");
    Route::get('/sales-agent/first-approval', 'Admin\SalesAgentController@SalesAgentFirstApprove')->name('sales-agent-first-approval');
    Route::get('/sales-agent/pending/{id?}', 'Admin\SalesAgentController@SalesAgentPending')->name("pending-sales-agent");
    Route::get('/sales-agent/second-approval', 'Admin\SalesAgentController@SalesAgentSecondApprove')->name('sales-agent-second-approval');
    Route::get('/sales-agent/approved', 'Admin\SalesAgentController@SalesAgentApproved')->name('sales-agent-approved');
    Route::get('/sales-agent/blocked', 'Admin\SalesAgentController@SalesAgentBlocked')->name('sales-agent-blocked');
    Route::get('/sales-agent/update/{id?}', 'Admin\SalesAgentController@ShowUpdateSalesAgent')->name("verify-sales-agent");
    Route::get('/sales-agent/approved/update/{id?}', 'Admin\SalesAgentController@ShowUpdateSalesAgentApproved')->name("verify-sales-agent-approved");
    Route::get('/sales-agent/blocked/update/{id?}', 'Admin\SalesAgentController@ShowUpdateSalesAgentBlocked')->name("verify-sales-agent-blocked");
    Route::post('/sales-agent/update/{id?}', '\App\Http\Controllers\Admin\SalesAgentController@UpdateSalesAgent')->name("update-sales-agent");
    Route::post('/sales-agent/approved/update/{id?}', '\App\Http\Controllers\Admin\SalesAgentController@UpdateSalesAgentApproved')->name("update-sales-agent-approved");
    Route::post('/sales-agent/blocked/update/{id?}', '\App\Http\Controllers\Admin\SalesAgentController@UpdateSalesAgentBlocked')->name("update-sales-agent-blocked");
    Route::post('/sales-agent/send-email', '\App\Http\Controllers\Admin\SalesAgentController@SendEmail')->name("send-email");

    //customer
    Route::get('/customer/add', 'Admin\CustomerController@ShowAddcustomer')->name("show-add-customer");
    Route::post('/customer/add', 'Admin\CustomerController@AddCustomer')->name("add-customer");
    Route::get('/customer/update/{id?}', 'Admin\CustomerController@ShowUpdateCustomer')->name("show-update-customer");
    Route::post('/customer/update/{id?}', 'Admin\CustomerController@UpdateCustomer')->name("update-customer");
    Route::get('/customer', 'Admin\CustomerController@Customer')->name('customer');
    Route::get('/customer/blocked', 'Admin\CustomerController@CustomerBlocked')->name('customer-blocked');
    Route::get('/customer/blocked/update/{id?}', 'Admin\CustomerController@ShowUpdateBlockedCustomer')->name("show-update-blocked-customer");
    Route::post('/customer/blocked/update/{id?}', 'Admin\CustomerController@UpdateBlockedCustomer')->name("update-blocked-customer");

    //order
    Route::get('/order/to-verify', 'Admin\OrderController@OrderToVerify')->name('order-to-verify');
    Route::get('/order/waiting-approval', 'Admin\OrderController@WaitingApproval')->name('order-waiting-approval');
    Route::get('/order/denied', 'Admin\OrderController@OrderDenied')->name('order-denied');
    Route::get('/order/canceled', 'Admin\OrderController@OrderCanceled')->name('order-canceled');
    Route::get('/order/finished', 'Admin\OrderController@OrderCompleted')->name('order-finished');
    Route::get('/order/approved', 'Admin\OrderController@OrderApproved')->name('order-approved');
    Route::get('/order/to-verify/{id?}', 'Admin\OrderController@OrderShow')->name('order-show');
    Route::get('/order/waiting/{id?}', 'Admin\OrderController@OrderShowWaiting')->name('order-show-waiting');
    Route::post('/order/deny/{id?}', 'Admin\OrderController@Deny')->name("order-deny");
    Route::post('/order/approve/{id?}', 'Admin\OrderController@Approve')->name('order-approve');
    Route::get('/order/waiting-shipping', 'Admin\OrderController@WaitingShipping')->name('order-waiting-shipping');

    //employee
    Route::get('/employee', 'Admin\EmployeeController@Employee')->name('employee-list');
    Route::get('/employee/add', 'Admin\EmployeeController@ShowAddEmployee')->name('show-employee-add');
    Route::post('/employee/add', 'Admin\EmployeeController@EmployeeAdd')->name('employee-add');
    Route::get('/company', 'Admin\EmployeeController@Company')->name('company');
    Route::get('/company/{id?}', 'Admin\EmployeeController@CompanyShow')->name('company-show');
    Route::get('/company-search', 'Admin\EmployeeController@CompanySearch')->name('company-search');

    //user
    Route::get('/user', 'Admin\UserController@User')->name('user-list');
    Route::get('/user/add', 'Admin\UserController@ShowAddUser')->name('show-user-add');
    Route::post('/user/add', 'Admin\UserController@UserAdd')->name('user-add');
    Route::get('/user/{id?}', 'Admin\UserController@UserShow')->name('user-show');
    Route::post('/user/{id?}', 'Admin\UserController@UserUpdate')->name('user-update');

    //role
    Route::get('/role', 'Admin\UserController@Role')->name('role-list');
    Route::get('/role/add', 'Admin\UserController@ShowAddRole')->name('show-role-add');
    Route::post('/role/add', 'Admin\UserController@RoleAdd')->name('role-add');
    Route::get('/role/{id?}', 'Admin\UserController@RoleShow')->name('role-show');
    Route::post('/role/{id?}', 'Admin\UserController@RoleUpdate')->name('role-update');

    //permission
    Route::get('/permission', 'Admin\UserController@Permission')->name('permission-list');
    Route::get('/permission/add', 'Admin\UserController@ShowAddPermission')->name('show-permission-add');
    Route::post('/permission/add', 'Admin\UserController@PermissionAdd')->name('permission-add');
    Route::get('/permission/{id?}', 'Admin\UserController@PermissionShow')->name('permission-show');
    Route::post('/permission/{id?}', 'Admin\UserController@PermissionUpdate')->name('permission-update');

    //category
    Route::get('/category', 'Admin\CategoryController@Category')->name('category-list');
    Route::get('/category/add', 'Admin\CategoryController@ShowAddCategory')->name('show-category-add');
    Route::post('/category/add', 'Admin\CategoryController@CategoryAdd')->name('category-add');
    Route::get('/category/{id?}', 'Admin\CategoryController@CategoryShow')->name('category-show');
    Route::post('/category/{id?}', 'Admin\CategoryController@CategoryUpdate')->name('category-update');

    //zone
     Route::get('/zone', 'Admin\ZoneController@Zone')->name('zone-list');
     Route::get('/city', 'Admin\ZoneController@City')->name('city-list');
     Route::get('/on-change-zones', 'Admin\ZoneController@OnChange')->name('on-change-zones');
     Route::get('/search-zones', 'Admin\ZoneController@Search')->name('search-zones');

    //dashboard
    Route::get('/dashboard', 'Admin\StatisticsController@Dashboard')->name('dashboard');
    Route::get('/top-sales', 'Admin\StatisticsController@TopSales')->name('top-sales');
    Route::get('/online-customer', 'Admin\StatisticsController@getOnlineCustomers')->name('online-customer');

    //search for product in master database
    Route::get('/search-details', 'Admin\ProductController@SearchDetails')->name('search-details');
    Route::get('/search', 'Admin\ProductController@Search')->name('search');

    //reseller archive
    Route::get('/depot', 'Admin\ResellerArchiveController@Depot')->name('depot');
    Route::get('/depot/add', 'Admin\ResellerArchiveController@ShowAddDepot')->name('show-depot-add');
    Route::post('/depot/add', 'Admin\ResellerArchiveController@DepotAdd')->name('depot-add');
    Route::get('/depot/{id?}', 'Admin\ResellerArchiveController@DepotShow')->name('depot-show');
    Route::post('/depot/{id?}', 'Admin\ResellerArchiveController@DepotUpdate')->name('depot-update');

    Route::get('/reseller-archive', 'Admin\ResellerArchiveController@ResellerArchive')->name('reseller-archive');
    Route::get('/reseller-archive/add', 'Admin\ResellerArchiveController@ShowAddArchive')->name('show-reseller-archive-add');
    Route::post('/reseller-archive/add', 'Admin\ResellerArchiveController@ArchiveAdd')->name('reseller-archive-add');
    Route::get('/reseller-archive/{id?}', 'Admin\ResellerArchiveController@ArchiveShow')->name('reseller-archive-show');
    Route::post('/reseller-archive/{id?}', 'Admin\ResellerArchiveController@ArchiveUpdate')->name('reseller-archive-update');

    // Stock
    Route::get('/stock/search-product','Admin\StockController@showSearch')->name('stock-search-product');
    Route::get('/stock/get-product/{id?}','Admin\StockController@searchforplace')->name('stock-get-product');
    Route::get('/stock/get-product-list','Admin\StockController@productList')->name('stock-get-product-list');
    Route::get('/stock/give_place', 'Admin\StockController@give_place')->name('give_place');
    Route::get('/stock/place_save', 'Admin\StockController@place_save')->name('place_save');
    Route::post('/stock/stock_save', 'Admin\StockController@stock_save')->name('stock_save');
    Route::post('/stock/update_stocks/{id?}', 'Admin\StockController@update_stocks')->name('update_stocks');
    
    //Courier
    Route::get('/courier', 'Admin\CourierController@courier')->name('courier');
    Route::get('/courier/add', 'Admin\CourierController@ShowAddCourier')->name("show-add-courier");
    Route::post('/courier/add', 'Admin\CourierController@AddCourier')->name("add-courier");
    Route::get('/courier/update/{id?}', 'Admin\CourierController@ShowUpdateCourier')->name("show-update-courier");
    Route::post('/courier/update/{id?}', 'Admin\CourierController@UpdateCourier')->name("update-courier");
   
    //invoice
    Route::get('/invoice', 'Admin\InvoiceController@invoice')->name('invoice-list');
    Route::get('/invoice/{id?}', 'Admin\InvoiceController@showInvoice')->name('invoice-show');
    Route::get('/invoice-search','Admin\InvoiceController@search')->name('invoice-search');
    Route::get('/invoice/pdf/{id?}','Admin\InvoiceController@printInvoicePDF')->name('invoice-pdf');
    Route::get('/invoice/create/{id?}','Admin\InvoiceController@createInvoice')->name('invoice-create');

    //test
    Route::get('/test', 'Admin\ProductController@test')->name('test');

    //order depot
    Route::get('/orders/finished', 'Admin\OrderDepotController@OrderCompleted')->name('order-depot-finished');
    Route::get('/orders/approved', 'Admin\OrderDepotController@OrderApproved')->name('order-depot-approved');
    Route::get('/orders/shipped', 'Admin\OrderDepotController@WaitingShipping')->name('order-depot-shipped');
    Route::get('/orders/removedelivery/{id}', 'Admin\OrderDepotController@RemoveDeliveyMethod')->name('order-depot-remove-delivery');
    Route::post('/orders/deliveryman/{id}/ariba', 'Admin\OrderDepotController@SetDeliveyManAriba')->name('order-depot-deliveryman-ariba');
    Route::get('/orders/deliveryman/{id}/ariba/remove', 'Admin\OrderDepotController@RemoveDeliveryManAriba')->name('order-depot-deliveryman-ariba-remove');

    Route::get('/orders/courier', 'Admin\OrderDepotController@GetCourier')->name('order-depot-courier');

    Route::get('/orders/shipped/{id?}', 'Admin\OrderDepotController@OrderShowShipped')->name('order-depot-show-shipped');
    Route::get('/orders/approved/{id?}', 'Admin\OrderDepotController@OrderShowApproved')->name('order-depot-show-approved');
    Route::get('/orders/finished/{id?}', 'Admin\OrderDepotController@OrderShowFinished')->name('order-depot-show-finished');

    Route::post('/orders/shippe/{id?}', 'Admin\OrderDepotController@shippe')->name('order-depot-shippe');
    Route::post('/orders/finish/{id?}', 'Admin\OrderDepotController@finish')->name('show-order-depot-finish');
    Route::post('/order/cancel/{id?}', 'Admin\OrderDepotController@cancel')->name("order-depot-cancel");

    Route::get('/orders/finish/{id?}', 'Admin\OrderDepotController@finish')->name('order-depot-finish');

    //Vendor Review
    Route::get('/review', 'Admin\ReviewVendorController@review')->name('review');
    Route::post('/review/approve/{id?}', 'Admin\ReviewVendorController@reviewApprove')->name('review-approve');
    Route::post('/review/disapprove/{id?}', 'Admin\ReviewVendorController@reviewDisapprove')->name('review-disapprove');

    //Product Review
    Route::get('/product/review', 'Admin\ReviewProductController@review')->name('product-review');
    Route::post('/product/review/approve/{id?}', 'Admin\ReviewProductController@reviewApprove')->name('product-review-approve');
    Route::post('/product/review/disapprove/{id?}', 'Admin\ReviewProductController@reviewDisapprove')->name('product-review-disapprove');
    Route::get('/product/review/show/{id?}', 'Admin\ReviewProductController@reviewShow')->name('product-review-show');

    //Firewall
    Route::get('/firewall/blacklist','Admin\FireWallController1@blacklist')->name('blacklist-list');
    Route::get('/firewall/blacklist/add', 'Admin\FireWallController1@showAdddToBlacklist')->name('blacklist-show-add');
    Route::post('/firewall/blacklist/add', 'Admin\FireWallController1@addToBlacklist')->name('blacklist-add');
    Route::get('/firewall/blacklist/remove/{ip?}', 'Admin\FireWallController1@removeFromBlacklist')->name('blacklist-remove');

    Route::get('/firewall/whitelist', 'Admin\FireWallController1@whitelist')->name('whitelist-list');
    Route::get('/firewall/whitelist/add', 'Admin\FireWallController1@showAdddToWhitelist')->name('whitelist-show-add');
    Route::post('/firewall/whitelist/add', 'Admin\FireWallController1@addToWhitelist')->name('whitelist-add');
    Route::get('/firewall/whitelist/remove/{ip?}', 'Admin\FireWallController1@removeFromWhitelist')->name('whitelist-remove');

    //Muhasebe cpc
    Route::get('/muhasebe/cpc', 'Admin\CpcController@cpc')->name('cpc-list');
    Route::get('/muhasebe/cpc/add', 'Admin\CpcController@showAddCpc')->name('cpc-show-add');
    // Route::post('/muhasebe/cpc/add', 'Admin\CpcController@addCpc')->name('cpc-add');
    Route::get('/muhasebe/cpc/show/{id?}', 'Admin\CpcController@showUpdateCpc')->name('cpc-show');
    Route::post('/muhasebe/cpc/update/{id?}', 'Admin\CpcController@updateCpc')->name('cpc-update');

    //bilan passif
    Route::get('/muhasebe/bilan-passif', 'Admin\BilanPassifController@bilanPassif')->name('bilan-passif');
    Route::get('/muhasebe/bilan-passif/add', 'Admin\BilanPassifController@showAddCpc')->name('bilan-passif-add');
    // Route::post('/muhasebe/bilan-passif/add', 'Admin\BilanPassifController@addCpc')->name('bilan-passif-add');
    Route::get('/muhasebe/bilan-passif/show/{id?}', 'Admin\BilanPassifController@showUpdateBilanPassif')->name('bilan-passif-show');
    Route::post('/muhasebe/bilan-passif/update/{id?}', 'Admin\BilanPassifController@updateBilanPassif')->name('bilan-passif-update');

    //bilan actif
    Route::get('/muhasebe/bilan-actif', 'Admin\BilanActifController@bilanActif')->name('bilan-actif');
    Route::get('/muhasebe/bilan-actif/add', 'Admin\BilanActifController@showAddCpc')->name('bilan-actif-add');
    // Route::post('/muhasebe/bilan-actif/add', 'Admin\BilanActifController@addCpc')->name('bilan-actif-add');
    Route::get('/muhasebe/bilan-actif/show/{id?}', 'Admin\BilanActifController@showUpdateBilanActif')->name('bilan-actif-show');
    Route::post('/muhasebe/bilan-actif/update/{id?}', 'Admin\BilanActifController@updateBilanActif')->name('bilan-actif-update');

});

Route::group(['middleware' => ['fw-block-blacklisted'] ], function () {

    //Authentication
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('show-login');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/', '\App\Http\Controllers\Auth\LoginController@goToLogin');
    Route::get('/admin', '\App\Http\Controllers\Auth\LoginController@goToLogin');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post(' /password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    // Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    // Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    // Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

});


