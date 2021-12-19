<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/login', 'Admin\AuthController@ShowLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\AuthController@LoginCheck')->name('admin.login.check');
Route::group(['as'=>'admin.','prefix' =>'admin','namespace'=>'Admin', 'middleware' => ['auth', 'admin']], function(){
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    Route::resource('roles','RoleController');
    Route::post('/roles/permission','RoleController@create_permission');
    Route::resource('staffs','StaffController');
    Route::resource('brands','BrandController');
    Route::resource('vendors','VendorController');
    Route::resource('drivers','DriverController');
    Route::resource('customers','CustomerController');
    Route::resource('vehicles','VehicleController');
    Route::resource('vehicle-driver-assigns','VehicleDriverAssignController');
    Route::resource('categories','CategoryController');
    Route::resource('overall-cost-categories','OverallCostCategoryController');
    Route::resource('overall-cost','OverallCostController');
    Route::resource('access-logs','AccessLogController');

    // vehicle rent from vendor
    Route::get('vehicle/vendor/rent/due','OrderController@vehicle_vendor_rent_due')->name('vehicle-vendor-rent-due');
    Route::get('vehicle/vendor/rent/list','OrderController@vehicle_vendor_rent_list')->name('vehicle-vendor-rent-list');
    Route::get('vehicle/vendor/rent/create','OrderController@vehicle_vendor_rent_create')->name('vehicle-vendor-rent-create');
    Route::post('vehicle/vendor/rent/store','OrderController@vehicle_vendor_rent_store')->name('vehicle-vendor-rent-store');
    Route::get('vehicle/vendor/rent/show/{id}','OrderController@vehicle_vendor_rent_show')->name('vehicle-vendor-rent-show');
    Route::get('vehicle/vendor/rent/edit/{id}','OrderController@vehicle_vendor_rent_edit')->name('vehicle-vendor-rent-edit');
    Route::put('vehicle/vendor/rent/update/{id}','OrderController@vehicle_vendor_rent_update')->name('vehicle-vendor-rent-update');
    Route::get('order/vendor/print/{id}','OrderController@order_vendor_print')->name('order-vendor-print');

    // vehicle rent to customer
    Route::get('vehicle/customer/rent/due','OrderController@vehicle_customer_rent_due')->name('vehicle-customer-rent-due');
    Route::get('vehicle/customer/rent/list','OrderController@vehicle_customer_rent_list')->name('vehicle-customer-rent-list');
    Route::get('vehicle/customer/rent/create','OrderController@vehicle_customer_rent_create')->name('vehicle-customer-rent-create');
    Route::post('vehicle/customer/rent/store','OrderController@vehicle_customer_rent_store')->name('vehicle-customer-rent-store');
    Route::get('vehicle/customer/rent/show/{id}','OrderController@vehicle_customer_rent_show')->name('vehicle-customer-rent-show');
    Route::get('vehicle/customer/rent/edit/{id}','OrderController@vehicle_customer_rent_edit')->name('vehicle-customer-rent-edit');
    Route::put('vehicle/customer/rent/update/{id}','OrderController@vehicle_customer_rent_update')->name('vehicle-customer-rent-update');
    Route::get('order/customer/print/{id}','OrderController@order_customer_print')->name('order-customer-print');

    Route::get('check/already/vehicle/assigned/or/free/{id}','VehicleController@check_already_vehicle_assigned_or_free');
    Route::get('check/already/driver/assigned/or/free/{id}','DriverController@check_already_driver_assigned_or_free');
    Route::post('check/already/vehicle/assigned/or/free/edit','VehicleController@check_already_vehicle_assigned_or_free_edit');
    Route::post('check/already/driver/assigned/or/free/edit','DriverController@check_already_driver_assigned_or_free_edit');
    Route::post('get/vehicle/price','VehicleController@get_vehicle_price');
    //Route::get('check/already/vehicle/rent/or/not/{id}','VehicleController@check_already_vehicle_rent_or_not');
    Route::post('check/already/vehicle/rent/or/not/this/date','VehicleController@check_already_vehicle_rent_or_not_this_date');
    Route::post('get/vehicle/assigned/driver','VehicleDriverAssignController@get_vehicle_assigned_driver');
    Route::post('pay-due','OrderController@payDue')->name('pay.due');

    // driver salary
    Route::get('driver/salary/list','DriverSalaryController@driver_salary_list')->name('driver-salary-list');
    Route::get('driver/salary/create','DriverSalaryController@driver_salary_create')->name('driver-salary-create');
    Route::post('driver/salary/store','DriverSalaryController@driver_salary_store')->name('driver-salary-store');
    Route::get('driver/salary/show/{id}','DriverSalaryController@vehicle_customer_rent_show')->name('driver-salary-show');
    Route::get('driver/salary/edit/{id}','DriverSalaryController@vehicle_customer_rent_edit')->name('driver-salary-edit');

    // report
    Route::get('report/payments','ReportController@reportPayment')->name('report-payment');






    Route::post('categories/is_home', 'CategoryController@updateIsHome')->name('categories.is_home');

    // Admin User Management
    Route::resource('customers','CustomerController');
    Route::get('customers/show/profile/{id}','CustomerController@profileShow')->name('customers.profile.show');
    Route::put('customers/update/profile/{id}','CustomerController@updateProfile')->name('customer.profile.update');
    Route::put('customers/password/update/{id}','CustomerController@updatePassword')->name('customer.password.update');
    Route::get('customers/ban/{id}','CustomerController@banCustomer')->name('customers.ban');

    Route::resource('profile','ProfileController');
    Route::put('password/update/{id}','ProfileController@updatePassword')->name('password.update');

    //performance
    Route::get('/config-cache', 'SystemOptimize@ConfigCache')->name('config.cache');
    Route::get('/clear-cache', 'SystemOptimize@CacheClear')->name('cache.clear');
    Route::get('/view-cache', 'SystemOptimize@ViewCache')->name('view.cache');
    Route::get('/view-clear', 'SystemOptimize@ViewClear')->name('view.clear');
    Route::get('/route-cache', 'SystemOptimize@RouteCache')->name('route.cache');
    Route::get('/route-clear', 'SystemOptimize@RouteClear')->name('route.clear');
    Route::get('/site-optimize', 'SystemOptimize@Settings')->name('site.optimize');

});
