<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Login routes
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/', function () {
	return redirect()->route('login');
});

Route::get('api', function () {
	return view('api');
});

// Auth required routes
Route::group(['middleware' => ['auth']], function () {
	Route::get('init', 'HomeController@init');
	Route::post('init', 'HomeController@initsave');

	Route::group(['middleware' => ['init']], function () {
		Route::get('home', 'HomeController@index');
		Route::get('systemstatus', 'HomeController@systemstatus')->middleware('can:view_systeminfo');

		Route::group(['prefix' => 'register'], function () {
			Route::get('partner', 'RegisterController@partner')->middleware('can:create_partner_account');
			Route::post('partner', 'RegisterController@registerpartner')->middleware('can:create_partner_account');
			Route::get('admin', 'RegisterController@admin')->middleware('can:create_admin_account');
			Route::post('admin', 'RegisterController@registeradmin')->middleware('can:create_admin_account');
		});

		Route::group(['prefix' => 'system'], function () {
			Route::post('addsector', 'SystemController@addsector')->middleware('can:add_sector');
			Route::post('addtype', 'SystemController@addtype')->middleware('can:add_type');
			Route::post('addlocation', 'SystemController@addlocation')->middleware('can:add_location');

			Route::get('group', 'SystemController@group')->middleware('can:add_group');
			Route::post('addgroup', 'SystemController@addgroup')->middleware('can:add_group');
			Route::get('grouppct', 'SystemController@grouppct')->middleware('can:add_group');
			Route::post('addgrouppct', 'SystemController@addgrouppct')->middleware('can:add_group');
			
			Route::post('overduedates', 'SystemController@updateoverduedates')->middleware('can:modify_overdue');
		});

		Route::group(['prefix' => 'messages'], function () {
			Route::post('add', 'MessageController@add')->middleware('can:new_message');
			Route::get('delete/{id}', 'MessageController@delete');
		});

		Route::group(['prefix' => 'fileentry'], function () {
			Route::get('get/{id}', ['as' => 'getentry', 'uses' => 'FileEntryController@get']);
			Route::post('add', ['as' => 'addentry', 'uses' => 'FileEntryController@add'])->middleware('can:new_file');
			Route::get('delete/{id}', 'FileEntryController@delete');
		});

		Route::group(['prefix' => 'list'], function () {
			Route::get('sector', 'ListController@listsector')->middleware('can:view_list_sector_type_location');
			Route::get('type', 'ListController@listtype')->middleware('can:view_list_sector_type_location');
			Route::get('location', 'ListController@listlocation')->middleware('can:view_list_sector_type_location');
			Route::get('group', 'ListController@listgroup')->middleware('can:view_list_group');
			Route::get('admin', 'ListController@listadmin')->middleware('can:view_list_admin');
			Route::get('partner', 'ListController@listpartner')->middleware('can:view_list_partner');
			Route::get('bills', 'ListController@listbill')->middleware('can:view_list_bill');
			Route::get('payments/{location_id}', 'PaymentController@list')->middleware('can:view_list_billdetail_payment');
			Route::get('messages', 'ListController@listmessage');
			Route::get('files', 'ListController@listfile');
		});

		Route::group(['prefix' => 'bill', 'middleware' => ['can:add_bill']], function () {
			Route::get('create', 'BillController@create');
			Route::post('create', 'BillController@createbill');
			Route::get('create/{assign}', 'BillController@createassign');
			Route::post('create/{assign}', 'BillController@createall');
		});

		Route::group(['prefix' => 'update'], function () {
			Route::get('profile', 'UpdateController@profile');
			Route::post('profile', 'UpdateController@saveprofile');

			Route::group(['prefix' => 'admin'], function () {
				Route::get('password/{id}', 'UpdateController@newadminpassword')->middleware('can:restore_password_admin_account');
				Route::get('data/{id}', 'UpdateController@admindata')->middleware('can:modify_admin_account');
				Route::post('data/{id}', 'UpdateController@saveadmindata')->middleware('can:modify_admin_account');
			});

			Route::group(['prefix' => 'partner'], function () {
				Route::get('password/{id}', 'UpdateController@newpartnerpassword')->middleware('can:restore_password_partner_account');
				Route::get('data/{id}', 'UpdateController@partnerdata')->middleware('can:modify_partner_account');
				Route::post('data/{id}', 'UpdateController@savepartnerdata')->middleware('can:modify_partner_account');
			});
		});

		Route::group(['prefix' => 'payment'], function () {
			Route::get('new/{id}', 'PaymentController@new')->middleware('can:add_payment');
			Route::post('new', 'PaymentController@newpost')->middleware('can:add_payment');
			Route::get('modify/{id}', 'PaymentController@modify')->middleware('can:modify_payment');
			Route::post('modify', 'PaymentController@modifypost')->middleware('can:modify_payment');
			Route::get('view/{id}', 'PaymentController@view')->middleware('can:view_list_billdetail_payment');
			Route::get('deletedetail/{id}', 'PaymentController@deletedetail')->middleware('can:delete_billdetail');
			Route::get('deletepayment/{id}', 'PaymentController@deletepayment')->middleware('can:delete_payment');
		});

		Route::group(['prefix' => 'report'], function () {
			Route::get('accounting', 'ReportController@accounting')->middleware('can:view_report_external_accounting');
			Route::post('accounting', 'ReportController@getaccounting')->middleware('can:view_report_external_accounting');
			Route::get('log', 'ReportController@log')->middleware('can:view_log');
			Route::post('log', 'ReportController@getlog')->middleware('can:view_log');
			Route::get('overdue', 'ReportController@overdue')->middleware('can:view_report_overdue');
			Route::post('overdue', 'ReportController@getoverdue')->middleware('can:view_report_overdue');
		});
	});
});

