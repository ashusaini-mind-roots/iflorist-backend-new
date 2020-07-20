<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/test', function () {
    try {
        DB::connection()->getPdo();
        if (DB::connection()->getDatabaseName()) {
            echo "Yes! Successfully connected to the DB: " . DB::connection()->getDatabaseName();
        } else {
            die("Could not find the database. Please check your configuration.");
        }
    } catch (\Exception $e) {
        die("Could not open connection to database server.  Please check your configuration.");
    }
});

Route::prefix('auth')->group(function () {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('loginApp', 'AuthController@loginApp');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('logout', 'AuthController@logout');
    Route::post('exis_user', 'AuthController@exis_user');

    Route::get('users', 'AuthController@users');
    Route::delete('delete/{id}', 'AuthController@delete');
    Route::get('getById/{id}', 'AuthController@getById');
    Route::put('update/{id}', 'AuthController@update');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('me', 'AuthController@me');
        Route::post('user_rol', 'AuthController@user_rol');
    });
});

Route::prefix('role')->group(function () {
    Route::get('all', 'RolesController@index');
    Route::post('create', 'RolesController@create');
    Route::get('getById/{id}', 'RolesController@getById');
    Route::delete('delete/{id}', 'RolesController@delete');
    Route::put('update/{id}', 'RolesController@update');
});

Route::prefix('daily_revenue')->group(function () {
    Route::get('seven_days_week/{store_id}/{week_id}', 'DailyRevenuesController@sevenDaysWeek');
    Route::put('update_all_amt', 'DailyRevenuesController@updateAllAmt');
    Route::get('sales/{store_id}/{year}/{quarter}', 'DailyRevenuesController@getSales');
    Route::put('update/{id}', 'DailyRevenuesController@update');
});

Route::prefix('invoice')->group(function () {
    Route::get('all/{cost_of}/{store_id}/{week_id}', 'InvoicesController@all');
    Route::post('create', 'InvoicesController@create');
    Route::delete('delete/{id}', 'InvoicesController@delete');
});

Route::prefix('note')->group(function () {
    Route::get('all/{store_id}/{week_id}/{year}', 'NotesController@all');
    Route::put('update/{store_id}/{week_id}', 'NotesController@update');
    Route::delete('delete/{note_id}', 'NotesController@delete');
    Route::post('create', 'NotesController@create');
});

Route::prefix('diff_projection_percent')->group(function () {
    Route::get('{store_id}/{week_id}/{year}', 'DiffProjectionsPercentController@diffProjectionPercent');
    Route::post('create', 'InvoicesController@create');
});

Route::prefix('weekly_projection_percent_costs')->group(function () {
    Route::get('target/{cost_of}/{store_id}', 'WeeklyProjectionPercentCostsController@target');
    Route::put('update_target_cog/{store_id}/{week_id}', 'WeeklyProjectionPercentCostsController@updateTargetCog');
});

Route::prefix('weekly_projection_percent_revenue')->group(function () {
    Route::get('proj_weekly_revenue/{store_id}/{week_id}', 'WeeklyProjectionPercentCostsRevenuesController@projWeeklyRevenue');
    Route::get('proj_weekly_revenue_quarter/{store_id}/{year}/{quarter}', 'WeeklyProjectionPercentCostsRevenuesController@projWeeklyRevenueByQuarter');
    Route::put('update_proj_weekly_revenue/{store_id}/{week_id}', 'WeeklyProjectionPercentCostsRevenuesController@updateWeeklyProjectionPercentValue');
    Route::get('projections/{store_id}/{year}', 'WeeklyProjectionPercentCostsRevenuesController@projections');
    Route::put('projections/update/{proyection_id}', 'WeeklyProjectionPercentCostsRevenuesController@update');
});

Route::prefix('master_overview_weekly')->group(function () {
    Route::get('master_overview_weekly_of/{cost_of}/{store_id}/{year}/{quarter}', 'MasterOverviewWeeklyController@MasterOverviewWeeklyOf');
    Route::get('weekly_projections/{store_id}/{year}', 'MasterOverviewWeeklyController@WeeklyProjections');
    Route::get('projection_col/{store_id}/{year}', 'MasterOverviewWeeklyController@ProjectionCol');
    Route::get('get_weekly_revenue/{store_id}/{week_nbr}/{year_reference_selected}', 'MasterOverviewWeeklyController@getDataStoreWeekYear');
    Route::get('scheduled_payroll_col/{store_id}/{week_id}', 'MasterOverviewWeeklyController@get_scheduled_payroll_col');
    Route::get('scheduled_payroll_by_quarter/{year}/{store_id}/{week_id}', 'MasterOverviewWeeklyController@get_scheduleds_payroll_by_quarter');
});

Route::prefix('category')->group(function () {
    Route::get('all', 'CategoriesController@index');
});

Route::prefix('statu')->group(function () {
    Route::get('all', 'StatusController@index');
});

Route::prefix('work_man_comp')->group(function () {
    Route::get('all', 'WorkMansCompController@index');
});

Route::prefix('target_percentage')->group(function () {
    Route::put('update_target_percentage/{store_id}/{week_id}', 'TargetPercentagesController@update_target_porcentage');
	Route::post('update_create_target_percentage', 'TargetPercentagesController@update_create_target_porcentage');
    Route::get('{store_id}/{week_id}', 'TargetPercentagesController@get_target');
});

Route::prefix('plan')->group(function () {
    Route::get('plans', 'PlansController@plans');
    Route::get('plansbyuser/{week_id}', 'PlansController@plansbyuser');
    Route::get('modulesbyuser/{week_id}', ['middleware' => 'auth.role:ALL_GRANTED', 'uses' => 'PlansController@modulesbyuser']);
});

Route::prefix('company')->group(function () {
    Route::post('create', 'CompanyController@create');
    Route::post('valid_card', 'CompanyController@valid_card');
    Route::post('activate_company', 'CompanyController@activate_user');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('stores_by_company', 'CompanyController@getStoresByCompany');
    });
});

Route::prefix('companyemployee')->group(function () {
    Route::get('all/{company_id}', 'CompanyEmployeeController@getAll');
    Route::post('create', 'CompanyEmployeeController@create');
    Route::get('getById/{id}', 'CompanyEmployeeController@getById');
    Route::get('getImageById/{id}', 'CompanyEmployeeController@getImageById');
    Route::delete('delete/{id}', 'CompanyEmployeeController@delete');
    Route::post('update/{id}', 'CompanyEmployeeController@update');
	Route::get('/show_imagen/companyemployee/{imagen}', 'CompanyEmployeeController@show_imagen');
});

//Routes which are using Role middleware

//Middleware Role
Route::prefix('store')->group(function () {
    Route::get('all', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,EMPLOYEE', 'uses' => 'StoresController@all']);
    Route::get('stores_by_user/{user_id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER', 'uses' => 'StoresController@storesByUser']);
    Route::post('create', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER', 'uses' => 'StoresController@create']);
    Route::get('getById/{id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER', 'uses' => 'StoresController@getById']);
    Route::get('getImageById/{id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER', 'uses' => 'StoresController@getImageById']);
    Route::delete('delete/{id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER', 'uses' => 'StoresController@delete']);
    Route::post('update/{id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER', 'uses' => 'StoresController@update']);
    Route::post('setWeeklyProjectionPercentRevenues', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER', 'uses' => 'StoresController@setWeeklyProjectionPercentRevenues']);
});

//Middleware Role
Route::prefix('week')->group(function () {
    Route::get('week_by_year/{year}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,EMPLOYEE', 'uses' => 'WeeksController@weekByYear']);
    Route::post('create', 'WeeksController@taskWeek');
});

//Middleware Role
Route::prefix('employee')->group(function () {
    Route::get('all/{store_id}', 'EmployeesController@getAll');
    Route::get('allActiveAndInactive/{store_id}', 'EmployeesController@getAllActiveAndInactive');
    Route::post('create', 'EmployeesController@create');
    Route::post('update/{id}', 'EmployeesController@update');
    Route::post('changeAdminStore', ['middleware' => 'auth.role:COMPANYADMIN', 'uses' => 'EmployeesController@changeStoreAdmin']);
    Route::get('getById/{id}', 'EmployeesController@getById');
    Route::get('getImageById/{id}', 'EmployeesController@getImageById');
    Route::get('getEmployeesByStore/{store_id}', 'EmployeesController@getEmployeesByStore');
    Route::delete('delete/{id}', 'EmployeesController@delete');
    Route::get('getImageByUserId/{id}', 'EmployeesController@getImageByUserId');
    Route::get('/show_imagen/employee/{imagen}', 'EmployeesController@show_imagen');
});

//Middleware Role
Route::prefix('schedule')->group(function () {
    Route::post('update_or_add', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,EMPLOYEE', 'uses' => 'ScheduleController@updateoradd']);
    Route::get('all/{store_id}/{week_id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,EMPLOYEE', 'uses' => 'ScheduleController@schedule_week']);
    Route::get('seven_days_number/{week_id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,EMPLOYEE', 'uses' => 'ScheduleController@seven_days_number']);
    Route::get('category_employee/{store_id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,EMPLOYEE', 'uses' => 'ScheduleController@categoryEmployeeList']);

});

//Middleware Role
Route::prefix('app_user')->group(function () {
    Route::get('all/{store_id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,APPUSER', 'uses' => 'AppUserController@all']);
    Route::post('create', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,APPUSER', 'uses' => 'AppUserController@create']);
    Route::post('update/{id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,APPUSER', 'uses' => 'AppUserController@update']);
    Route::get('getAppUser/{id}', ['middleware' => 'auth.role:COMPANYADMIN,STOREMANAGER,APPUSER', 'uses' => 'AppUserController@getById']);
});



