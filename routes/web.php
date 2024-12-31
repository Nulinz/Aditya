<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::view('/', 'login')->name('login');


Route::group(['namespace' => 'App\Http\Controllers'], function () {

    // Route::post('register', 'AuthenticationController@register')->name('register.submit');
    Route::post('login', 'AuthenticationController@login')->name('login.submit');
    Route::get('logout', 'AuthenticationController@logout')->name('logout');


    Route::middleware(['auth'])->group(function () {

        //Change Password

        Route::get('settings','ChangePasswordController@index')->name('change_password.index');
        Route::post('settings-update','ChangePasswordController@update')->name('change_password.update');

        //Dashboard

        Route::get('dashboard', 'DashBoardController@index')->name('dashboard');
        Route::get('dashboard-2', 'DashBoardController@index2')->name('dashboard2.index');
        Route::get('dashboard-3', 'DashBoardController@index3')->name('dashboard3.index');
        Route::get('dashboard-4', 'DashBoardController@index4')->name('dashboard4.index');

        //Projects

        Route::get('projects', 'ProjectController@index')->name('projects.index');
        Route::get('projects-new','ProjectController@create')->name('projects.new');
        Route::post('projects-store', 'ProjectController@store')->name('projects.save');
        Route::get('/project/profile/{project_id}','ProjectController@showProfile')->name('project.profile');
        Route::post('/load-tab','ProjectController@loadTabContent')->name('load.tab');
        Route::post('/overview/update','ProjectController@updateAssetValue')->name('overview.updateAssetValue');
        Route::get('/project/edit/{id}','ProjectController@edit')->name('project.edit');
        Route::post('projects-update/{id}','ProjectController@update')->name('projects.update');

        Route::post('projects-store-boq', 'ProjectController@boq_store')->name('projects_boq.sa');
        Route::get('boq/edit/{id}', 'ProjectController@boqedit')->name('boq.edit');
        Route::post('boq/update/{id}', 'ProjectController@boqupdate')->name('boq.update');
        Route::get('boq-delete/{id}','ProjectController@boqdelete')->name('boq.destroy');

        Route::post('projects-store-sales', 'ProjectController@process_sales_store')->name('projects_sales.sa');
        Route::get('sales/edit/{id}', 'ProjectController@process_sales_store_edit')->name('sales.edit');
        Route::post('sales/update/{id}', 'ProjectController@process_sales_store_update')->name('sales.update');
        Route::get('sales-delete/{id}','ProjectController@process_sales_store_delete')->name('sales.destroy');


        Route::post('projects-store-hire', 'ProjectController@hire_store')->name('projects_hire.sa');
        Route::get('hire/edit/{id}', 'ProjectController@hire_edit')->name('hire.edit');
        Route::post('hire/update/{id}', 'ProjectController@hire_update')->name('hire.update');
        Route::get('hire-delete/{id}','ProjectController@hire_delete')->name('hire.destroy');

        Route::post('projects-store-petty', 'ProjectController@prettystore')->name('projects_petty.sa');
        Route::get('petty/edit/{id}', 'ProjectController@prettyedit')->name('petty.edit');
        Route::post('petty/update/{id}', 'ProjectController@prettyupdate')->name('petty.update');
        Route::get('petty-delete/{id}','ProjectController@prettydestroy')->name('petty.destroy');


        Route::post('projects-store-pettycash', 'ProjectController@addprettycashstore')->name('projects_pettycash.sa');
        Route::get('pettycash/edit/{id}', 'ProjectController@petty_edit')->name('pettycash.edit');
        Route::post('pettycash/update/{id}', 'ProjectController@petty_update')->name('pettycash.update');
        Route::get('pettycash-delete/{id}','ProjectController@petty_delete')->name('pettycash.destroy');


        Route::post('projects-store-boq-purchase', 'ProjectController@boq_purchase')->name('projects_boq_purchase.sa');
        Route::get('boq-purchase/edit/{id}', 'ProjectController@boq_pur_edit')->name('boq_purchase.edit');
        Route::post('boq-purchase/update/{id}', 'ProjectController@boq_pur_update')->name('boq_purchase.update');
        Route::get('boq-purchase-delete/{id}','ProjectController@boq_pur_delete')->name('boq_purchase.destroy');

        Route::post('projects-store-boq-labour', 'ProjectController@boq_labour')->name('projects_boq_labour.sa');
        Route::get('boq-labour/edit/{id}', 'ProjectController@boq_lab_edit')->name('boq_labour.edit');
        Route::post('boq-labour/update/{id}', 'ProjectController@boq_lab_update')->name('boq_labour.update');
        Route::get('boq-labour-delete/{id}','ProjectController@boq_lab_delete')->name('boq_labour.destroy');


        Route::post('projects-store-expense', 'ProjectController@head_expense')->name('projects_head_expenses.sa');
        Route::get('head-expenses/edit/{id}', 'ProjectController@head_expense_edit')->name('head_expenses.edit');
        Route::post('head-expenses/update/{id}', 'ProjectController@head_expense_update')->name('head_expenses.update');
        Route::get('head-expenses-delete/{id}','ProjectController@head_expense_delete')->name('head_expenses.destroy');


        Route::post('projects-store-assgin-team', 'ProjectController@assgin_team')->name('projects_assgin_team.sa');
        Route::get('assgin-team/edit/{id}', 'ProjectController@assgin_team_edit')->name('assgin_team.edit');
        Route::post('assgin-team/update/{id}', 'ProjectController@assgin_team_update')->name('assgin_team.update');
        Route::get('assgin-team-delete/{id}','ProjectController@assgin_team_delete')->name('assgin_team.destroy');


        Route::post('projects-store-sc_bill', 'ProjectController@sc_bill')->name('projects_sc_bill.sa');
        Route::get('sc_bill/edit/{id}', 'ProjectController@sc_bill_edit')->name('sc_bill.edit');
        Route::post('sc_bill/update/{id}', 'ProjectController@sc_bill_update')->name('sc_bill.update');
        Route::get('sc_bill-delete/{id}','ProjectController@sc_bill_delete')->name('sc_bill.destroy');
        Route::get('/get-boq-details','ProjectController@getBoqDetails')->name('get_boq_details');


        Route::post('projects-store-rate-approval', 'ProjectController@rate_approval_store')->name('projects_rate_approval.sa');
        Route::get('rate-approval/edit/{id}', 'ProjectController@rate_approval_edit')->name('rate_approval.edit');
        Route::post('rate-approval/update/{id}', 'ProjectController@rate_approval_update')->name('rate_approval.update');
        Route::get('rate-approval-delete/{id}','ProjectController@rate_approval_delete')->name('rate_approval.destroy');


        Route::post('boq/import','ProjectController@boqimport')->name('boq.import');
        Route::get('boq/export/{projectId}','ProjectController@export')->name('boq.export');

        Route::post('process/import','ProjectController@processimport')->name('process.import');
        Route::get('process/export/{projectId}','ProjectController@processexport')->name('process.export');

        Route::post('hire/import','ProjectController@hireimport')->name('hire.import');
        Route::get('hire/export/{projectId}','ProjectController@hireexport')->name('hire.export');



        //Employee

        Route::get('employee', 'EmpolyeeController@index')->name('employee.index');
        Route::get('employee-new','EmpolyeeController@create')->name('employee.new');
        Route::post('employee-store', 'EmpolyeeController@store')->name('employee.save');
        Route::get('employee/edit/{id}', 'EmpolyeeController@edit')->name('employee.edit');
        Route::post('/employee/update/{id}','EmpolyeeController@update')->name('employee.update');
        Route::get('employee-delete/{id}','EmpolyeeController@destroy')->name('employee.destroy');


        //Degination

        Route::get('desgination', 'DestinationController@index')->name('desgination.index');
        Route::post('desgination-store', 'DestinationController@store')->name('desgination.save');
        Route::post('/desgination/update/{id}','DestinationController@update')->name('desgination.update');
        Route::get('desgination-delete/{id}','DestinationController@destroy')->name('desgination.destroy');

        //Vendors

        Route::get('vendors', 'VendorController@index')->name('vendors.index');
        Route::post('vendors-store', 'VendorController@store')->name('vendors.save');
        Route::get('vendors/edit/{id}', 'VendorController@edit')->name('vendors.edit');
        Route::post('/vendors/update/{id}','VendorController@update')->name('vendors.update');
        Route::get('vendors-delete/{id}','VendorController@destroy')->name('vendors.destroy');
        Route::post('vendor/import','VendorController@vendorimport')->name('vendor.import');
        Route::get('vendor/export','VendorController@vendorexport')->name('vendor.export');

        //Materials

        Route::get('material', 'MaterialMasterController@index')->name('material.index');
        Route::post('material-store', 'MaterialMasterController@store')->name('material.save');
        Route::get('material/edit/{id}', 'MaterialMasterController@edit')->name('material.edit');
        Route::post('/material/update/{id}','MaterialMasterController@update')->name('material.update');
        Route::get('material-delete/{id}','MaterialMasterController@destroy')->name('material.destroy');
        Route::get('/export-material','MaterialMasterController@export')->name('material.export');
        Route::post('/import-material','MaterialMasterController@import')->name('material.import');

        //Overhead

        Route::get('overhead', 'OverHeadMasterController@index')->name('overhead.index');
        Route::post('overhead-store', 'OverHeadMasterController@store')->name('overhead.save');
        Route::get('overhead/edit/{id}', 'OverHeadMasterController@edit')->name('overhead.edit');
        Route::post('/overhead/update/{id}','OverHeadMasterController@update')->name('overhead.update');
        Route::get('overhead-delete/{id}','OverHeadMasterController@destroy')->name('overhead.destroy');
        Route::get('/export-overhead','OverHeadMasterController@export')->name('overhead.export');
        Route::post('/import-overhead','OverHeadMasterController@import')->name('overhead.import');

        //Asset Code

        Route::get('asset-code', 'AssetCodeController@index')->name('asset_code.index');
        Route::post('asset-code-store', 'AssetCodeController@store')->name('asset_code.save');
        Route::get('asset-code/edit/{id}', 'AssetCodeController@edit')->name('asset_code.edit');
        Route::post('/asset-code/update/{id}','AssetCodeController@update')->name('asset_code.update');
        Route::get('asset-code-delete/{id}','AssetCodeController@destroy')->name('asset_code.destroy');
        Route::get('/export-asset','AssetCodeController@export')->name('asset.export');
        Route::post('/import-asset','AssetCodeController@import')->name('asset.import');


        //Sub-Division

        Route::get('division', 'SubDivisionController@index')->name('division.index');
        Route::post('division-store', 'SubDivisionController@store')->name('division.save');
        Route::get('division/edit/{id}', 'SubDivisionController@edit')->name('division.edit');
        Route::post('/division/update/{id}','SubDivisionController@update')->name('division.update');
        Route::get('division-delete/{id}','SubDivisionController@destroy')->name('division.destroy');
        Route::get('/export-division','SubDivisionController@export')->name('division.export');


        //Unit

        Route::get('unit', 'UnitController@index')->name('unit.index');
        Route::post('units-store', 'UnitController@store')->name('unit.save');
        Route::post('/units/update/{id}','UnitController@update')->name('units.update');
        Route::get('units-delete/{id}','UnitController@destroy')->name('unit.destroy');


    });

});


// Route::prefix('nulinz')->group(function () {

// Route::middleware(['checkDeveloper'])->group(function () {

//    Route::view('developer_login', 'developer_login')->name('developer_login');

//     Route::group(['namespace' => 'App\Http\Controllers'], function () {

//         Route::post('developer-login', 'DeveloperAuthController@developer_login')->name('developer_login.submit');

//             //Dashboard

//             Route::get('dashboard-developer', 'DeveloperDashboardController@index')->name('dashboard');
//             Route::get('dashboard-developer-2', 'DeveloperDashboardController@index2')->name('dashboard2.index');
//             Route::get('dashboard-developer-3', 'DeveloperDashboardController@index3')->name('dashboard3.index');
//             Route::get('dashboard-developer-4', 'DeveloperDashboardController@index4')->name('dashboard4.index');

//             // //Projects

//             // Route::get('projects', 'ProjectController@index')->name('projects.index');
//             // Route::get('projects-new','ProjectController@create')->name('projects.new');
//             // Route::post('projects-store', 'ProjectController@store')->name('projects.save');
//             // Route::get('/project/profile/{project_id}','ProjectController@showProfile')->name('project.profile');
//             // Route::post('/load-tab','ProjectController@loadTabContent')->name('load.tab');
//             // Route::post('/overview/update','ProjectController@updateAssetValue')->name('overview.updateAssetValue');
//             // Route::get('/project/edit/{id}','ProjectController@edit')->name('project.edit');
//             // Route::post('projects-update/{id}','ProjectController@update')->name('projects.update');

//             // Route::post('projects-store-boq', 'ProjectController@boq_store')->name('projects_boq.sa');
//             // Route::get('boq/edit/{id}', 'ProjectController@boqedit')->name('boq.edit');
//             // Route::post('boq/update/{id}', 'ProjectController@boqupdate')->name('boq.update');
//             // Route::get('boq-delete/{id}','ProjectController@boqdelete')->name('boq.destroy');

//             // Route::post('projects-store-sales', 'ProjectController@process_sales_store')->name('projects_sales.sa');
//             // Route::get('sales/edit/{id}', 'ProjectController@process_sales_store_edit')->name('sales.edit');
//             // Route::post('sales/update/{id}', 'ProjectController@process_sales_store_update')->name('sales.update');
//             // Route::get('sales-delete/{id}','ProjectController@process_sales_store_delete')->name('sales.destroy');


//             // Route::post('projects-store-hire', 'ProjectController@hire_store')->name('projects_hire.sa');
//             // Route::get('hire/edit/{id}', 'ProjectController@hire_edit')->name('hire.edit');
//             // Route::post('hire/update/{id}', 'ProjectController@hire_update')->name('hire.update');
//             // Route::get('hire-delete/{id}','ProjectController@hire_delete')->name('hire.destroy');

//             // Route::post('projects-store-petty', 'ProjectController@prettystore')->name('projects_petty.sa');
//             // Route::get('petty/edit/{id}', 'ProjectController@prettyedit')->name('petty.edit');
//             // Route::post('petty/update/{id}', 'ProjectController@prettyupdate')->name('petty.update');
//             // Route::get('petty-delete/{id}','ProjectController@prettydestroy')->name('petty.destroy');


//             // Route::post('projects-store-pettycash', 'ProjectController@addprettycashstore')->name('projects_pettycash.sa');
//             // Route::get('pettycash/edit/{id}', 'ProjectController@petty_edit')->name('pettycash.edit');
//             // Route::post('pettycash/update/{id}', 'ProjectController@petty_update')->name('pettycash.update');
//             // Route::get('pettycash-delete/{id}','ProjectController@petty_delete')->name('pettycash.destroy');


//             // Route::post('projects-store-boq-purchase', 'ProjectController@boq_purchase')->name('projects_boq_purchase.sa');
//             // Route::get('boq-purchase/edit/{id}', 'ProjectController@boq_pur_edit')->name('boq_purchase.edit');
//             // Route::post('boq-purchase/update/{id}', 'ProjectController@boq_pur_update')->name('boq_purchase.update');
//             // Route::get('boq-purchase-delete/{id}','ProjectController@boq_pur_delete')->name('boq_purchase.destroy');

//             // Route::post('projects-store-boq-labour', 'ProjectController@boq_labour')->name('projects_boq_labour.sa');
//             // Route::get('boq-labour/edit/{id}', 'ProjectController@boq_lab_edit')->name('boq_labour.edit');
//             // Route::post('boq-labour/update/{id}', 'ProjectController@boq_lab_update')->name('boq_labour.update');
//             // Route::get('boq-labour-delete/{id}','ProjectController@boq_lab_delete')->name('boq_labour.destroy');


//             // Route::post('projects-store-expense', 'ProjectController@head_expense')->name('projects_head_expenses.sa');
//             // Route::get('head-expenses/edit/{id}', 'ProjectController@head_expense_edit')->name('head_expenses.edit');
//             // Route::post('head-expenses/update/{id}', 'ProjectController@head_expense_update')->name('head_expenses.update');
//             // Route::get('head-expenses-delete/{id}','ProjectController@head_expense_delete')->name('head_expenses.destroy');


//             // Route::post('projects-store-assgin-team', 'ProjectController@assgin_team')->name('projects_assgin_team.sa');
//             // Route::get('assgin-team/edit/{id}', 'ProjectController@assgin_team_edit')->name('assgin_team.edit');
//             // Route::post('assgin-team/update/{id}', 'ProjectController@assgin_team_update')->name('assgin_team.update');
//             // Route::get('assgin-team-delete/{id}','ProjectController@assgin_team_delete')->name('assgin_team.destroy');


//             // Route::post('projects-store-sc_bill', 'ProjectController@sc_bill')->name('projects_sc_bill.sa');
//             // Route::get('sc_bill/edit/{id}', 'ProjectController@sc_bill_edit')->name('sc_bill.edit');
//             // Route::post('sc_bill/update/{id}', 'ProjectController@sc_bill_update')->name('sc_bill.update');
//             // Route::get('sc_bill-delete/{id}','ProjectController@sc_bill_delete')->name('sc_bill.destroy');
//             // Route::get('/get-boq-details','ProjectController@getBoqDetails')->name('get_boq_details');


//             // Route::post('projects-store-rate-approval', 'ProjectController@rate_approval_store')->name('projects_rate_approval.sa');
//             // Route::get('rate-approval/edit/{id}', 'ProjectController@rate_approval_edit')->name('rate_approval.edit');
//             // Route::post('rate-approval/update/{id}', 'ProjectController@rate_approval_update')->name('rate_approval.update');
//             // Route::get('rate-approval-delete/{id}','ProjectController@rate_approval_delete')->name('rate_approval.destroy');



//             // //Employee

//             // Route::get('employee', 'EmpolyeeController@index')->name('employee.index');
//             // Route::get('employee-new','EmpolyeeController@create')->name('employee.new');
//             // Route::post('employee-store', 'EmpolyeeController@store')->name('employee.save');
//             // Route::get('employee/edit/{id}', 'EmpolyeeController@edit')->name('employee.edit');
//             // Route::post('/employee/update/{id}','EmpolyeeController@update')->name('employee.update');
//             // Route::get('employee-delete/{id}','EmpolyeeController@destroy')->name('employee.destroy');


//             // //Degination

//             // Route::get('desgination', 'DestinationController@index')->name('desgination.index');
//             // Route::post('desgination-store', 'DestinationController@store')->name('desgination.save');
//             // Route::post('/desgination/update/{id}','DestinationController@update')->name('desgination.update');
//             // Route::get('desgination-delete/{id}','DestinationController@destroy')->name('desgination.destroy');

//             // //Vendors

//             // Route::get('vendors', 'VendorController@index')->name('vendors.index');
//             // Route::post('vendors-store', 'VendorController@store')->name('vendors.save');
//             // Route::get('vendors/edit/{id}', 'VendorController@edit')->name('vendors.edit');
//             // Route::post('/vendors/update/{id}','VendorController@update')->name('vendors.update');
//             // Route::get('vendors-delete/{id}','VendorController@destroy')->name('vendors.destroy');

//             // //Materials

//             // Route::get('material', 'MaterialMasterController@index')->name('material.index');
//             // Route::post('material-store', 'MaterialMasterController@store')->name('material.save');
//             // Route::get('material/edit/{id}', 'MaterialMasterController@edit')->name('material.edit');
//             // Route::post('/material/update/{id}','MaterialMasterController@update')->name('material.update');
//             // Route::get('material-delete/{id}','MaterialMasterController@destroy')->name('material.destroy');
//             // Route::get('/export-material','MaterialMasterController@export')->name('material.export');
//             // Route::post('/import-material','MaterialMasterController@import')->name('material.import');

//             // //Overhead

//             // Route::get('overhead', 'OverHeadMasterController@index')->name('overhead.index');
//             // Route::post('overhead-store', 'OverHeadMasterController@store')->name('overhead.save');
//             // Route::get('overhead/edit/{id}', 'OverHeadMasterController@edit')->name('overhead.edit');
//             // Route::post('/overhead/update/{id}','OverHeadMasterController@update')->name('overhead.update');
//             // Route::get('overhead-delete/{id}','OverHeadMasterController@destroy')->name('overhead.destroy');

//             // //Asset Code

//             // Route::get('asset-code', 'AssetCodeController@index')->name('asset_code.index');
//             // Route::post('asset-code-store', 'AssetCodeController@store')->name('asset_code.save');
//             // Route::get('asset-code/edit/{id}', 'AssetCodeController@edit')->name('asset_code.edit');
//             // Route::post('/asset-code/update/{id}','AssetCodeController@update')->name('asset_code.update');
//             // Route::get('asset-code-delete/{id}','AssetCodeController@destroy')->name('asset_code.destroy');


//             // //Sub-Division

//             // Route::get('division', 'SubDivisionController@index')->name('division.index');
//             // Route::post('division-store', 'SubDivisionController@store')->name('division.save');
//             // Route::get('division/edit/{id}', 'SubDivisionController@edit')->name('division.edit');
//             // Route::post('/division/update/{id}','SubDivisionController@update')->name('division.update');
//             // Route::get('division-delete/{id}','SubDivisionController@destroy')->name('division.destroy');

//             // //Unit

//             // Route::get('unit', 'UnitController@index')->name('unit.index');
//             // Route::post('units-store', 'UnitController@store')->name('unit.save');
//             // Route::post('/units/update/{id}','UnitController@update')->name('units.update');
//             // Route::get('units-delete/{id}','UnitController@destroy')->name('unit.destroy');

//     });
// });




