<?php

namespace App\Http\Controllers;

use App\models\Partner;
use App\models\Roles;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;


class PanelController extends Controller
{

    public $user;
    public $role;
    public $employees;
    public $clients;
    public $admins;
    public $partners;
    public $cars;
    public $rentings;
    public $waitings;
    public $expenses;
    public $advertisements;
    public $reports;
    public $notifications;
    public $settings;
    public function __construct()
    {

        $this->user = Auth::user();
        $this->role = Roles::class;
        $this->employees = new EmployeeController();
        $this->clients = new ClientsController();
        $this->admins = new AdminsController();
        $this->partners = new PartnersController();
        $this->cars = new CarsController();
        $this->rentings = new ReservationController();
        $this->waitings = new WaitingsController();
        $this->expenses = new ExpensesController();
        $this->advertisements = new AdvertisementsController();
        $this->reports = new ReportsController();
        $this->notifications = new NotificationsController();
        $this->settings = new SettingsController();
    }

    public function overview()
    {

        return view('pages.overview',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'clients' => $this->clients->GetClients(),
                'employees' => $this->employees->GetEmployees(),
                'partners' => $this->partners->GetPartners(),
                'rentings' => $this->rentings->GetRentings(),
                'waitings' => $this->waitings->GetWaitings(),
                'cars_avalible' => $this->rentings->GetCars(),
                'cars' => $this->cars->GetCars(),
                'page' => 'overview',
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()
            ]);
    }

    public function Clients()
    {

        return view('pages.clients',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'clients' => $this->clients->GetClients(),
                'clients_fields' => $this->clients->GetClientsFields(),
                'clients_counter' => 1,
                'page' => 'client',
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()
            ]);
    }
    public function Admins()
    {

        return view('pages.admins',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'admins' => $this->admins->GetAdmins(),
                'admins_fields' => $this->admins->GetAdminsFields(),
                'page' => 'admins',
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()
            ]);
    }
    public function PartnerPanel()
    {

        $partner = Partner::where('user_id',Auth::user()->id)->first();
        if ($partner) {
            return view('pages.PartnerPanel',
                [
                    'partner' => $partner,
                ]);
        } else
            return view('errors.404');


    }

    public function employees()
    {
        return view('pages.employees',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'employees' => $this->employees->GetEmployees(),
                'employee_fields' =>  $this->employees->GetEmployeeFields(),
                'page' => 'employee',
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()
            ]);
    }

    public function partners()
    {
      return view('pages.partners',
          [
              'user' => $this->user,
              'role' => $this->role ,
              'partners' => $this->partners->GetPartners(),
              'partners_fields' => $this->partners->GetPartnersFields(),
              'page' => 'partner',
              'count'=>$this->notifications->Count(),
              'notifications'=>$this->notifications->GetNotifications()
          ]);
    }

    public function cars()
    {
        return view('pages.cars',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'page' => 'cars',
                'cars_fields' => $this->cars->cars_fields,
                'cars_register_fields' => $this->cars->cars_register_fields,
                'cars' => $this->cars->GetCars(),
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()
            ]);
    }

    public function reservations()
    {
        return view('pages.rentings',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'page' => 'reservations',
                'users' => $this->rentings->GetCustomers(),
                'cars' => $this->rentings->GetCars(),
                'rentings_fields' => $this->rentings->GetRentingsFields(),
                'rentings' => $this->rentings->GetRentings(),
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()

            ]);
    }
    public function waiting()
    {
        return view('pages.waiting',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'page' => 'waitings',
                'users' => $this->waitings->GetCustomers(),
                'cars' => $this->waitings->GetCars(),
                'waitings_fields' => $this->waitings->GetWaitingsFields(),
                'waitings' => $this->waitings->GetWaitings(),
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()

            ]);
    }
    public function recive()
    {
        return view('pages.recive',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'page' => 'recive',
                'users' => $this->rentings->GetCustomers(),
                'cars' => $this->rentings->GetCars(),
                'rentings' => $this->rentings->GetRentings(),
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()
            ]);
    }

    public function reports()
    {
        return view('pages.reports',[
            'user' => $this->user,
            'role' => $this->role ,
            'page' => 'reports',
            'count'=>$this->notifications->Count(),
            'notifications'=>$this->notifications->GetNotifications()
        ]);
    }

    public function settings()
    {
        return view('pages.settings',[
            'user' => $this->user,
            'role' => $this->role ,
            'page' => 'settings',
            'about_sub_title' => $this->settings->GetSetting("about_sub_title")->value,
            'about_text' => $this->settings->GetSetting("about_text")->value,
            'services_' => $this->settings->GetSetting("about_text")->value,
            'count'=>$this->notifications->Count(),
            'notifications'=>$this->notifications->GetNotifications()
        ]);
    }
    public function advertisements()
    {
        return view('pages.advertisements',[
            'user' => $this->user,
            'role' => $this->role ,
            'page' => 'advertisements',
            'advertisements'=>$this->advertisements->GetAdvertisements(),
            'count'=>$this->notifications->Count(),
            'notifications'=>$this->notifications->GetNotifications()
        ]);
    }
       public function expenses()
    {
        return view('pages.expenses',
            [
                'user' => $this->user,
                'role' => $this->role ,
                'expenses_fields' => $this->expenses->GetExpensesFields(),
                'general_expenses' => $this->expenses->GetGeneralExpenses(),
                'page' => 'expenses',
                'count'=>$this->notifications->Count(),
                'notifications'=>$this->notifications->GetNotifications()
            ]);
    }

    public function quick_access()
    {

        return view('pages.quickaccess',['user' => $this->user,
            'users' => $this->rentings->GetCustomers(),
            'cars' => $this->rentings->GetCars(),
            'count'=>$this->notifications->Count(),
            'notifications'=>$this->notifications->GetNotifications(),
            'role' => $this->role ,'page' => 'quickaccess']);
    }

}

