<?php
use Illuminate\Support\Facades\DB;
Route::get('trial',function (){
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;


Route::get('/','RouteController@Dashboard');
Route::get('/login',array('as' => 'login' ,'uses' => 'RouteController@login'));
Route::get('/announcement/{id}/{title}','AdvertisementsController@Profile');

Route::get('home','RouteController@index');
Route::get('/password/email','Auth\PasswordController@getEmail');
Route::post('/password/email','Auth\PasswordController@postEmail');
Route::get('/password/reset/{token}','Auth\PasswordController@getReset');
Route::post('/password/reset','Auth\PasswordController@getReset');


Route::post('/user/login','HomeController@PostLogin');
Route::post('/contact','HomeController@Contact');


Route::group(['middleware' => 'auth'],function (){
    Route::get('/logout',array('as' => 'logout' ,'uses' => 'HomeController@LogOut'));
    Route::get('/dashboard',array('as' => 'dashboard' , 'uses' => 'RouteController@Dashboard') );

    Route::get('/overview',array('as' => 'overview' , 'uses' => 'PanelController@overview' ))->middleware(['RoleChecker:overview']);
    Route::get('/PartnerPanel',array('as' => 'PartnerPanel' , 'uses' => 'PanelController@PartnerPanel' ))->middleware(['RoleChecker:PartnerPanel']);
    Route::get('/admins',array('as' => 'admins' , 'uses' => 'PanelController@admins' ))->middleware(['RoleChecker:admins']);
    Route::get('/clients', array('as' => 'clients', 'uses' => 'PanelController@Clients'))->middleware(['RoleChecker:clients']);
    Route::get('/employees', array('as' => 'employees', 'uses' => 'PanelController@employees'))->middleware(['RoleChecker:employees']);
    Route::get('/partners', array('as' => 'partners', 'uses' => 'PanelController@partners'))->middleware(['RoleChecker:partners']);
    Route::get('/carss', array('as' => 'cars', 'uses' => 'PanelController@cars'))->middleware(['RoleChecker:cars']);
    Route::get('/reservations', array('as' => 'reservations', 'uses' => 'PanelController@reservations'))->middleware(['RoleChecker:reservations']);
    Route::get('/waiting', array('as' => 'waiting', 'uses' => 'PanelController@waiting'))->middleware(['RoleChecker:waiting']);
    Route::get('/recive', array('as' => 'recive', 'uses' => 'PanelController@recive'))->middleware(['RoleChecker:recive']);
    Route::get('/expenses',array('as' => 'expenses' , 'uses' => 'PanelController@expenses' ))->middleware(['RoleChecker:expenses']);
    Route::get('/advertisements',array('as' => 'advertisements' , 'uses' => 'PanelController@advertisements' ))->middleware(['RoleChecker:advertisements']);
    Route::get('/reports', array('as' => 'reports', 'uses' => 'PanelController@reports'))->middleware(['RoleChecker:reports']);
    Route::get('/settings', array('as' => 'settings', 'uses' => 'PanelController@settings'))->middleware(['RoleChecker:settings']);
    Route::get('/quickaccess', array('as' => 'quickaccess', 'uses' => 'PanelController@quick_access'))->middleware(['RoleChecker:quickaccess']);
    Route::get('/checkout',array('as'=>'checkout','uses'=>'ReservationController@ReservationCheckOut'));
    Route::post('/register/car',array('as' => 'register.car', 'uses' => 'CarsController@RegisterCar'))->middleware(['RoleChecker:cars']);
    Route::post('/client/add','ClientsController@add');
    Route::post('/client/update','ClientsController@update');
    Route::post('/client/delete','ClientsController@delete');
    Route::post('/partner/delete','PartnersController@DeletePartner');
    Route::post('/rent/car',array('as' => 'rent.car','uses' => 'ReservationController@CreateReservation'));
    Route::post('/rent/car/renew',array('as' => 'rent.car','uses' => 'ReservationController@RenewReservation'));
    Route::post('/calculate/reservation',array('as' => 'calculate.car.rent','uses' => 'ReservationController@CalculateReservation'));
    Route::post('/calculate/reservation/renew',array('as' => 'calculate.car.rent','uses' => 'ReservationController@CalculateRenewReservation'));
    Route::post('/update/calculate/reservation',array('as' => 'calculate.car.rent','uses' => 'ReservationController@CalculateReservation'));
    Route::post('/calculate/waiting',array('as' => 'calculate.car.rent','uses' => 'WaitingsController@CalculateWaiting'));
    Route::post('/update/calculate/waiting',array('as' => 'calculate.car.rent','uses' => 'WaitingsController@CalculateWaiting'));
    Route::post('/Reserve',array('as'=> '','uses' => 'ReservationController@FinalReservationStep'));
    Route::post('/reservation/delete',array('as'=> '','uses' => 'ReservationController@Delete'));
    Route::post('/reservation/update',array('as'=> '','uses' => 'ReservationController@Update'));
    Route::post('/renting/recive','ReservationController@Recive');

    Route::post('/renting/recive/penalty','ReservationController@PenaltyCheck');

    Route::post('/waiting/add',array('uses' => 'WaitingsController@Add'));
    Route::post('/waiting/update',array('as'=> '','uses' => 'WaitingsController@Update'));
    Route::post('/waiting/delete',array('as'=> '','uses' => 'WaitingsController@Delete'));
    Route::post('/waiting/car/date',array('as'=> '','uses' => 'WaitingsController@GetCarDate'));


    Route::post('/admin/add','AdminsController@add');
    Route::post('/admin/update','AdminsController@update');
    Route::post('/admin/delete','AdminsController@delete');

    Route::post('/employee/add','EmployeeController@add');
    Route::post('/employee/update','EmployeeController@update');
    Route::post('/employee/delete','EmployeeController@delete');
    Route::post('/employee/penalty/add','EmployeeController@AddPenalty');

    Route::post('/partner/add','PartnersController@add');
    Route::post('/partner/update','PartnersController@update');
    Route::post('/partner/delete','PartnersController@delete');

    Route::post('/partner/GetCars','PartnersController@GetCars');
    Route::post('/partner/GetMonths','PartnersController@GetMonths');
    Route::post('/partner/GetYears','PartnersController@GetYears');
    Route::post('/partner/FinalPartner','PartnersController@FinalPartner');

    Route::get('client/{username}','ClientsController@Profile');
    Route::get('partner/{username}','PartnersController@Profile');
    Route::get('employee/{username}','EmployeeController@Profile');
    Route::get('car/{carname}','CarsController@Profile');

    Route::post('/user/update','HomeController@UpdateUser');
    Route::post('/client/dept/pay','ClientsController@PayDept');
    Route::post('/client/penalty/pay','ReservationController@PenaltyPay');

    Route::post('/expenses/general/add','ExpensesController@AddGeneral');
    Route::post('/expenses/car/add','ExpensesController@AddCar');
    Route::post('/expenses/delete','ExpensesController@Delete');
    Route::post('/expenses/update','ExpensesController@Update');

    Route::post('/announcement/add','AdvertisementsController@add');
    Route::post('/announcement/update','AdvertisementsController@Update');
    Route::post('/announcement/picture/update','AdvertisementsController@UpdatePicture');
    Route::post('/announcement/attachments/update','AdvertisementsController@UpdateAttachments');
    Route::post('/announcement/delete','AdvertisementsController@Delete');

    Route::post('/car/delete','CarsController@Delete');
    Route::post('/car/update','CarsController@Update');
    Route::post('/car/availability','CarsController@CheckAvailability');
    Route::post('/car/attachment','AttachmentsController@Car');
    Route::post('/car/attachment/delete','AttachmentsController@Delete');
    Route::post('/client/attachment','AttachmentsController@Client');



    Route::post('/report/GetMonths','ReportsController@GetMonths');
    Route::post('/report/GetYears','ReportsController@GetYears');
    Route::post('/report/FinalReport','ReportsController@FinalReport');


    Route::get('/notifications/read','NotificationsController@Read');
    Route::get('/notifications/delete','NotificationsController@Delete');



});
