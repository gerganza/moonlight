<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Forms
use Validator;
use DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
//Models
use App\User;
use App\Group;
use App\UserGroup;
use App\Profile;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();

        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1')) {
            
            $charts = [

                'chart' => ['type' => 'pie'],
                'title' => '',
                'xAxis' => [
                    'categories' => ['']
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Fees',
                        'data' => [],
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('dashboard', array(
                'id' => $id,
                'charts' => $charts,
            ));
            
            exit;
        }

        return view('dashboard', array(
            'id' => $id,
        ));
    }

    /*
     * Dashboard
     */
    public function viewDashboard()
    {
        $id = Auth::id();
        
        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1')) {

            $charts = [

                'chart' => [
                        'type' => 'pie',
                        'plotShadow' => false,
                        'dataLabels' => [
                            'enabled' => false,
                        ],
                        'showInLagend' => true,
                    ],
                'title' => '',
                'xAxis' => [
                    'categories' => ['']
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                     [
                        'name' => '',
                        'data' => [],
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('dashboard', array(
                'id' => $id,
                'year' => Cache::tags($id)->get('_year'),
                'client1' => Cache::tags($id)->get('_client1'),
                'client2' => Cache::tags($id)->get('_client2'),
                'total_air' => Cache::tags($id)->get('_total_air'),
                'total_dom' => Cache::tags($id)->get('_total_dom'),
                'total_intl' => Cache::tags($id)->get('_total_intl'),
                'total_hotel' =>Cache::tags($id)->get('_total_hotel'),
                'total_rail' => Cache::tags($id)->get('_total_rail'),
                'total_car' => Cache::tags($id)->get('_total_car'),
                'total_visa' => Cache::tags($id)->get('_total_visa'),
                'total_sales' => Cache::tags($id)->get('_total_sales'),
                'charts' => $charts,
            ));
        }

        $error = 'Please select filter parameters first.';
        return view('dashboard', array(
            'id' => $id,
            'error' => $error,
        ));
    }

    public function updateClientList(Request $request)
    {
        $id = Auth::id();

        set_time_limit(-1);
        $db = DB::connection();
        $params = $request->get('profiletype');
        $data = $db->select("SELECT * FROM [dbo].[fnClientListDisplay] ($params)");

        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1')) {

            $charts = [

                'chart' => [
                    'type' => 'pie',
                    'plotShadow' => false,
                    'dataLabels' => [
                        'enabled' => false,
                    ],
                    'showInLagend' => true,
                ],
                'title' => '',
                'xAxis' => [
                    'categories' => ['']
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                    [
                        'name' => '',
                        'data' => [],
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('dashboard', array(
                'id' => $id,
                'clientlist' => $data,
                'charts' => $charts,
            ));
        }

        return view('dashboard', array(
            'id' => $id,
            'clientlist' => $data,
        ));
    }

    /*
     * Dashboard form submit
     */
    public function generateReport(Request $request)
    {
        $id = Auth::id();

        //clear cach
        Cache::tags($id)->flush();

        $error = "";
        if (count($request->client) > 2) {
            $error = 'You can only select 2 clients.';

            return view('dashboard', array(
                'id' => $id,
                'error' => $error,
            ));
            exit;
        }

        set_time_limit(-1);
        ini_set('memory_limit', '-1');
        $db = DB::connection();

        $year = (int)$request->get('year');
        $client = $request->get('client');
        $client1 = (int)$client[0];
        if(isset($client[1])) {
            $client2 = (int)$client[1];
            $clientname = Profile::getName($client1).'('.$client1.') & '.Profile::getName($client2).'('.$client2.')';
        } else {
            $client2 = 0;
            $clientname = Profile::getName($client1).'('.$client1.')';
        }
        
        //DB queries
        //get total summaries
        $data_air = $db->select("SELECT * FROM [dbo].[fnSum_AIR_Sales] ($year, $client1, $client2)");
        $data_intl = $db->select("SELECT * FROM [dbo].[fnSum_Air_Intl_SALES] ($year, $client1, $client2)");
        $data_dom = $db->select("SELECT * FROM [dbo].[fnSum_Air_Dom_SALES] ($year, $client1, $client2)");
        $data_hotel = $db->select("SELECT * FROM [dbo].[fnSum_Hotel_SALES] ($year, $client1, $client2)");
        $data_rail = $db->select("SELECT * FROM [dbo].[fnSum_Rail_SALES] ($year, $client1, $client2)");
        $data_car = $db->select("SELECT * FROM [dbo].[fnSum_Car_SALES] ($year, $client1, $client2)");
        $data_visa = $db->select("SELECT * FROM [dbo].[fnSum_VisaPass_SALES] ($year, $client1, $client2)");
        $data_fees = $db->select("SELECT * FROM [dbo].[fnSum_Fees_SALES] ($year, $client1, $client2)");
        $data_sales = $db->select("SELECT * FROM [dbo].[fnSum_Total_SALES] ($year, $client1, $client2)");
        
        //get TM data
        $data_AIR_tm = $db->select("SELECT * FROM [dbo].[fnGenerate_AIR_TM_Data] ($year, $client1, $client2)");
        $data_HOTEL_tm = $db->select("SELECT * FROM [dbo].[fnGenerate_HOTEL_TM_Data] ($year, $client1, $client2)");
        $data_RAIL_tm = $db->select("SELECT * FROM [dbo].[fnGenerate_RAIL_TM_Data] ($year, $client1, $client2)");
        $data_CAR_tm = $db->select("SELECT * FROM [dbo].[fnGenerate_CAR_TM_Data] ($year, $client1, $client2)");
        $data_VISA_tm = $db->select("SELECT * FROM [dbo].[fnGenerate_VISAPASS_TM_Data] ($year, $client1, $client2)");
        $data_FEES_tm = $db->select("SELECT * FROM [dbo].[fnGenerate_FEES_TM_Data] ($year, $client1, $client2)");

        //Five-year Data
        $data_HOTEL_fiveyear = $db->select("SELECT * FROM [dbo].[fnGenerate_HOTEL_FiveYR_Data] ($year, $client1, $client2)");
        $data_AIR_fiveyear = $db->select("SELECT * FROM [dbo].[fnGenerate_AIR_FiveYR_Data] ($year, $client1, $client2)");
        $data_RAIL_fiveyear = $db->select("SELECT * FROM [dbo].[fnGenerate_RAIL_FiveYR_Data] ($year, $client1, $client2)");
        $data_CAR_fiveyear = $db->select("SELECT * FROM [dbo].[fnGenerate_CAR_FiveYR_Data] ($year, $client1, $client2)");
        $data_VISA_fiveyear = $db->select("SELECT * FROM [dbo].[fnGenerate_VISAPASS_FiveYR_Data] ($year, $client1, $client2)");
        $data_FEES_fiveyear = $db->select("SELECT * FROM [dbo].[fnGenerate_FEES_FiveYR_Data] ($year, $client1, $client2)");

        //format total into 2 decimal places
        foreach($data_dom as $total) {
            $total_dom = number_format($total->Value_Data, 2);
        }
        foreach($data_intl as $total) {
            $total_intl = number_format($total->Value_Data, 2);
        }
        foreach($data_air as $total) {
            $total_air = number_format($total->Value_Data, 2);
        }
        foreach($data_hotel as $total) {
            $total_hotel = number_format($total->Value_Data, 2);
        }
        foreach($data_rail as $total) {
            $total_rail = number_format($total->Value_Data, 2);
        }
        foreach($data_car as $total) {
            $total_car = number_format($total->Value_Data, 2);
        }
        foreach($data_visa as $total) {
            $total_visa= number_format($total->Value_Data, 2);
        }
        foreach($data_fees as $total) {
            $total_fees= number_format($total->Value_Data, 2);
        }
        foreach($data_sales as $total) {
            $total_sales = number_format($total->Value_Data, 2);
        }

        //set cache values
        $minutes = 720;
        //cache total summaries
        Cache::tags($id)->put('_year', $year, $minutes);
        Cache::tags($id)->put('_client1', $client1, $minutes);
        Cache::tags($id)->put('_client2', $client2, $minutes);
        Cache::tags($id)->put('_clientname', $clientname, $minutes);
        Cache::tags($id)->put('_total_air', $total_air, $minutes);
        Cache::tags($id)->put('_total_dom', $total_dom, $minutes);
        Cache::tags($id)->put('_total_intl', $total_intl, $minutes);
        Cache::tags($id)->put('_total_hotel', $total_hotel, $minutes);
        Cache::tags($id)->put('_total_rail', $total_rail, $minutes);
        Cache::tags($id)->put('_total_car', $total_car, $minutes);
        Cache::tags($id)->put('_total_visa', $total_visa, $minutes);
        Cache::tags($id)->put('_total_fees', $total_fees, $minutes);
        Cache::tags($id)->put('_total_sales', $total_sales, $minutes);
        
        //cache AIR data
        foreach($data_AIR_tm as $key => $tmdata) {
            Cache::tags($id)->put('_AIR_item_'.$key, $tmdata->ITEM_NO, $minutes);
            Cache::tags($id)->put('_AIR_category_'.$key, $tmdata->Category, $minutes);
            Cache::tags($id)->put('_AIR_JanData_'.$key, $tmdata->Jan_Data, $minutes);
            Cache::tags($id)->put('_AIR_FebData_'.$key, $tmdata->Feb_Data, $minutes);
            Cache::tags($id)->put('_AIR_MarData_'.$key, $tmdata->Mar_Data, $minutes);
            Cache::tags($id)->put('_AIR_AprData_'.$key, $tmdata->Apr_Data, $minutes);
            Cache::tags($id)->put('_AIR_MayData_'.$key, $tmdata->May_Data, $minutes);
            Cache::tags($id)->put('_AIR_JunData_'.$key, $tmdata->Jun_Data, $minutes);
            Cache::tags($id)->put('_AIR_JulData_'.$key, $tmdata->Jul_Data, $minutes);
            Cache::tags($id)->put('_AIR_AugData_'.$key, $tmdata->Aug_Data, $minutes);
            Cache::tags($id)->put('_AIR_SepData_'.$key, $tmdata->Sep_Data, $minutes);
            Cache::tags($id)->put('_AIR_OctData_'.$key, $tmdata->Oct_Data, $minutes);
            Cache::tags($id)->put('_AIR_NovData_'.$key, $tmdata->Nov_Data, $minutes);
            Cache::tags($id)->put('_AIR_DecData_'.$key, $tmdata->Dec_Data, $minutes);
        }

        //cache HOTEL data
        foreach($data_HOTEL_tm as $key => $tmdata) {
            Cache::tags($id)->put('_HOTEL_item_'.$key, $tmdata->ITEM_NO, $minutes);
            Cache::tags($id)->put('_HOTEL_category_'.$key, $tmdata->Category, $minutes);
            Cache::tags($id)->put('_HOTEL_JanData_'.$key, $tmdata->Jan_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_FebData_'.$key, $tmdata->Feb_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_MarData_'.$key, $tmdata->Mar_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_AprData_'.$key, $tmdata->Apr_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_MayData_'.$key, $tmdata->May_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_JunData_'.$key, $tmdata->Jun_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_JulData_'.$key, $tmdata->Jul_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_AugData_'.$key, $tmdata->Aug_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_SepData_'.$key, $tmdata->Sep_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_OctData_'.$key, $tmdata->Oct_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_NovData_'.$key, $tmdata->Nov_Data, $minutes);
            Cache::tags($id)->put('_HOTEL_DecData_'.$key, $tmdata->Dec_Data, $minutes);
        }

        //cache RAIL data
        foreach($data_RAIL_tm as $key => $tmdata) {
            Cache::tags($id)->put('_RAIL_item_'.$key, $tmdata->ITEM_NO, $minutes);
            Cache::tags($id)->put('_RAIL_category_'.$key, $tmdata->Category, $minutes);
            Cache::tags($id)->put('_RAIL_JanData_'.$key, $tmdata->Jan_Data, $minutes);
            Cache::tags($id)->put('_RAIL_FebData_'.$key, $tmdata->Feb_Data, $minutes);
            Cache::tags($id)->put('_RAIL_MarData_'.$key, $tmdata->Mar_Data, $minutes);
            Cache::tags($id)->put('_RAIL_AprData_'.$key, $tmdata->Apr_Data, $minutes);
            Cache::tags($id)->put('_RAIL_MayData_'.$key, $tmdata->May_Data, $minutes);
            Cache::tags($id)->put('_RAIL_JunData_'.$key, $tmdata->Jun_Data, $minutes);
            Cache::tags($id)->put('_RAIL_JulData_'.$key, $tmdata->Jul_Data, $minutes);
            Cache::tags($id)->put('_RAIL_AugData_'.$key, $tmdata->Aug_Data, $minutes);
            Cache::tags($id)->put('_RAIL_SepData_'.$key, $tmdata->Sep_Data, $minutes);
            Cache::tags($id)->put('_RAIL_OctData_'.$key, $tmdata->Oct_Data, $minutes);
            Cache::tags($id)->put('_RAIL_NovData_'.$key, $tmdata->Nov_Data, $minutes);
            Cache::tags($id)->put('_RAIL_DecData_'.$key, $tmdata->Dec_Data, $minutes);
        }

        //cache CAR data
        foreach($data_CAR_tm as $key => $tmdata) {
            Cache::tags($id)->put('_CAR_item_'.$key, $tmdata->ITEM_NO, $minutes);
            Cache::tags($id)->put('_CAR_category_'.$key, $tmdata->Category, $minutes);
            Cache::tags($id)->put('_CAR_JanData_'.$key, $tmdata->Jan_Data, $minutes);
            Cache::tags($id)->put('_CAR_FebData_'.$key, $tmdata->Feb_Data, $minutes);
            Cache::tags($id)->put('_CAR_MarData_'.$key, $tmdata->Mar_Data, $minutes);
            Cache::tags($id)->put('_CAR_AprData_'.$key, $tmdata->Apr_Data, $minutes);
            Cache::tags($id)->put('_CAR_MayData_'.$key, $tmdata->May_Data, $minutes);
            Cache::tags($id)->put('_CAR_JunData_'.$key, $tmdata->Jun_Data, $minutes);
            Cache::tags($id)->put('_CAR_JulData_'.$key, $tmdata->Jul_Data, $minutes);
            Cache::tags($id)->put('_CAR_AugData_'.$key, $tmdata->Aug_Data, $minutes);
            Cache::tags($id)->put('_CAR_SepData_'.$key, $tmdata->Sep_Data, $minutes);
            Cache::tags($id)->put('_CAR_OctData_'.$key, $tmdata->Oct_Data, $minutes);
            Cache::tags($id)->put('_CAR_NovData_'.$key, $tmdata->Nov_Data, $minutes);
            Cache::tags($id)->put('_CAR_DecData_'.$key, $tmdata->Dec_Data, $minutes);
        }

        //cache VISA/PASSPORT data
        foreach($data_VISA_tm as $key => $tmdata) {
            Cache::tags($id)->put('_VISA_item_'.$key, $tmdata->ITEM_NO, $minutes);
            Cache::tags($id)->put('_VISA_category_'.$key, $tmdata->Category, $minutes);
            Cache::tags($id)->put('_VISA_JanData_'.$key, $tmdata->Jan_Data, $minutes);
            Cache::tags($id)->put('_VISA_FebData_'.$key, $tmdata->Feb_Data, $minutes);
            Cache::tags($id)->put('_VISA_MarData_'.$key, $tmdata->Mar_Data, $minutes);
            Cache::tags($id)->put('_VISA_AprData_'.$key, $tmdata->Apr_Data, $minutes);
            Cache::tags($id)->put('_VISA_MayData_'.$key, $tmdata->May_Data, $minutes);
            Cache::tags($id)->put('_VISA_JunData_'.$key, $tmdata->Jun_Data, $minutes);
            Cache::tags($id)->put('_VISA_JulData_'.$key, $tmdata->Jul_Data, $minutes);
            Cache::tags($id)->put('_VISA_AugData_'.$key, $tmdata->Aug_Data, $minutes);
            Cache::tags($id)->put('_VISA_SepData_'.$key, $tmdata->Sep_Data, $minutes);
            Cache::tags($id)->put('_VISA_OctData_'.$key, $tmdata->Oct_Data, $minutes);
            Cache::tags($id)->put('_VISA_NovData_'.$key, $tmdata->Nov_Data, $minutes);
            Cache::tags($id)->put('_VISA_DecData_'.$key, $tmdata->Dec_Data, $minutes);
        }

        //cache FEES data
        foreach($data_FEES_tm as $key => $tmdata) {
            Cache::tags($id)->put('_FEES_item_'.$key, $tmdata->ITEM_NO, $minutes);
            Cache::tags($id)->put('_FEES_category_'.$key, $tmdata->Category, $minutes);
            Cache::tags($id)->put('_FEES_JanData_'.$key, $tmdata->Jan_Data, $minutes);
            Cache::tags($id)->put('_FEES_FebData_'.$key, $tmdata->Feb_Data, $minutes);
            Cache::tags($id)->put('_FEES_MarData_'.$key, $tmdata->Mar_Data, $minutes);
            Cache::tags($id)->put('_FEES_AprData_'.$key, $tmdata->Apr_Data, $minutes);
            Cache::tags($id)->put('_FEES_MayData_'.$key, $tmdata->May_Data, $minutes);
            Cache::tags($id)->put('_FEES_JunData_'.$key, $tmdata->Jun_Data, $minutes);
            Cache::tags($id)->put('_FEES_JulData_'.$key, $tmdata->Jul_Data, $minutes);
            Cache::tags($id)->put('_FEES_AugData_'.$key, $tmdata->Aug_Data, $minutes);
            Cache::tags($id)->put('_FEES_SepData_'.$key, $tmdata->Sep_Data, $minutes);
            Cache::tags($id)->put('_FEES_OctData_'.$key, $tmdata->Oct_Data, $minutes);
            Cache::tags($id)->put('_FEES_NovData_'.$key, $tmdata->Nov_Data, $minutes);
            Cache::tags($id)->put('_FEES_DecData_'.$key, $tmdata->Dec_Data, $minutes);
        }
        
        //cache total data rows
        Cache::tags($id)->put('_AIR_total_rows', max(array_keys($data_AIR_tm)), $minutes);
        Cache::tags($id)->put('_HOTEL_total_rows', max(array_keys($data_HOTEL_tm)), $minutes);
        Cache::tags($id)->put('_RAIL_total_rows', max(array_keys($data_RAIL_tm)), $minutes);
        Cache::tags($id)->put('_CAR_total_rows', max(array_keys($data_CAR_tm)), $minutes);
        Cache::tags($id)->put('_VISA_total_rows', max(array_keys($data_VISA_tm)), $minutes);
        Cache::tags($id)->put('_FEES_total_rows', max(array_keys($data_FEES_tm)), $minutes);

        //cache HOTEL five-year data
        Cache::tags($id)->put('_HOTEL_fiveyear_total_rows', max(array_keys($data_HOTEL_fiveyear)), $minutes);
        foreach($data_HOTEL_fiveyear as $key => $fiveyear) {
            Cache::tags($id)->put('_HOTEL_fiveyear_itemno_'.$key, $fiveyear->ITEM_NO, $minutes);
            Cache::tags($id)->put('_HOTEL_fiveyear_category_'.$key, $fiveyear->Category, $minutes);
            Cache::tags($id)->put('_HOTEL_fiveyear_yeardate_'.$key, $fiveyear->Year_Date, $minutes);
            Cache::tags($id)->put('_HOTEL_fiveyear_yeardata_'.$key, $fiveyear->Year_DATA, $minutes);
        }

        //cache AIR five-year data
        Cache::tags($id)->put('_AIR_fiveyear_total_rows', max(array_keys($data_AIR_fiveyear)), $minutes);
        foreach($data_AIR_fiveyear as $key => $fiveyear) {
            Cache::tags($id)->put('_AIR_fiveyear._itemno_'.$key, $fiveyear->ITEM_NO, $minutes);
            Cache::tags($id)->put('_AIR_fiveyear_category_'.$key, $fiveyear->Category, $minutes);
            Cache::tags($id)->put('_AIR_fiveyear_yeardate_'.$key, $fiveyear->Year_Date, $minutes);
            Cache::tags($id)->put('_AIR_fiveyear_yeardata_'.$key, $fiveyear->Year_DATA, $minutes);
        }

        //cache RAIL five-year data
        Cache::tags($id)->put('_RAIL_fiveyear_total_rows', max(array_keys($data_RAIL_fiveyear)), $minutes);
        foreach($data_RAIL_fiveyear as $key => $fiveyear) {
            Cache::tags($id)->put('_RAIL_fiveyear._itemno_'.$key, $fiveyear->ITEM_NO, $minutes);
            Cache::tags($id)->put('_RAIL_fiveyear_category_'.$key, $fiveyear->Category, $minutes);
            Cache::tags($id)->put('_RAIL_fiveyear_yeardate_'.$key, $fiveyear->Year_Date, $minutes);
            Cache::tags($id)->put('_RAIL_fiveyear_yeardata_'.$key, $fiveyear->Year_DATA, $minutes);
        }

        //cache CAR five-year data
        Cache::tags($id)->put('_CAR_fiveyear_total_rows', max(array_keys($data_CAR_fiveyear)), $minutes);
        foreach($data_CAR_fiveyear as $key => $fiveyear) {
            Cache::tags($id)->put('_CAR_fiveyear._itemno_'.$key, $fiveyear->ITEM_NO, $minutes);
            Cache::tags($id)->put('_CAR_fiveyear_category_'.$key, $fiveyear->Category, $minutes);
            Cache::tags($id)->put('_CAR_fiveyear_yeardate_'.$key, $fiveyear->Year_Date, $minutes);
            Cache::tags($id)->put('_CAR_fiveyear_yeardata_'.$key, $fiveyear->Year_DATA, $minutes);
        }

        //cache VISA five-year data
        Cache::tags($id)->put('_VISA_fiveyear_total_rows', max(array_keys($data_VISA_fiveyear)), $minutes);
        foreach($data_VISA_fiveyear as $key => $fiveyear) {
            Cache::tags($id)->put('_VISA_fiveyear._itemno_'.$key, $fiveyear->ITEM_NO, $minutes);
            Cache::tags($id)->put('_VISA_fiveyear_category_'.$key, $fiveyear->Category, $minutes);
            Cache::tags($id)->put('_VISA_fiveyear_yeardate_'.$key, $fiveyear->Year_Date, $minutes);
            Cache::tags($id)->put('_VISA_fiveyear_yeardata_'.$key, $fiveyear->Year_DATA, $minutes);
        }

        //cache FEES five-year data
        Cache::tags($id)->put('_FEES_fiveyear_total_rows', max(array_keys($data_FEES_fiveyear)), $minutes);
        foreach($data_FEES_fiveyear as $key => $fiveyear) {
            Cache::tags($id)->put('_FEES_fiveyear._itemno_'.$key, $fiveyear->ITEM_NO, $minutes);
            Cache::tags($id)->put('_FEES_fiveyear_category_'.$key, $fiveyear->Category, $minutes);
            Cache::tags($id)->put('_FEES_fiveyear_yeardate_'.$key, $fiveyear->Year_Date, $minutes);
            Cache::tags($id)->put('_FEES_fiveyear_yeardata_'.$key, $fiveyear->Year_DATA, $minutes);
        }

        //Overall Chart
        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1')) {

            $charts = [

                'chart' => ['type' => 'pie'],
                'title' => '',
                'xAxis' => [
                    'categories' => ['']
                ],
                'yAxis' => [
                    'title' => [
                        'text' => ''
                    ]
                ],
                'series' => [
                    [
                        'name' => '',
                        'data' => [],
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];
        }

        return view('dashboard', array(
            'id' => $id,
            'charts' => $charts,
        ));
    }

    /*
     * User Profile
     */
    public function viewProfile()
    {
        $userid = Auth::id();
        $logged_user = Auth::user();

        return view('profile', array(
                'logged_user' => $logged_user,
                'userid' => $userid
            ));
    }

    public function updateProfile()
    {
        $userid = Auth::id();

        $messages = [
            'firstname.max' => 'Your first name may not be greater than 50 characters.',
            'lastname.max' => 'Your last name may not be greater than 50 characters.',
            'password.same' => 'Password did not match',
            'password2.same' => 'Password did not match',
        ];

        $validator = Validator::make(Input::all(), [
            'firstname' => 'max:50',
            'lastname' => 'max:50',
            'password' => 'same:password2',
            'password2' => 'same:password',
        ], $messages);

        if ($validator->fails()) {
            return redirect('user/profile')
                ->withErrors($validator)
                ->withInput();
        }

        if(Input::get('password') != '')
        {
            DB::table('users')
                ->where('id', $userid)
                ->update([
                    'firstname' => Input::get('firstname'),
                    'lastname' => Input::get('lastname'),
                    'name' => Input::get('firstname').' '.Input::get('lastname'),
                    'password' => bcrypt(Input::get('password')),
                ]);
        } else {
            DB::table('users')
                ->where('id', $userid)
                ->update([
                    'firstname' => Input::get('firstname'),
                    'lastname' => Input::get('lastname'),
                    'name' => Input::get('firstname').' '.Input::get('lastname'),
                ]);
        }
        
        return redirect('user/profile');
    }

    public function viewAir()
    {
        $id = Auth::id();

        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1') && Cache::tags($id)->has('_client2')) {

            $title = ' ';

            //Get ytd per category
            $minutes = 180;
            for($i=0; $i>=Cache::tags($id)->get('_AIR_total_rows'); $i++) {
                $total[$i] = array_sum([
                    Cache::tags($id)->get('_AIR_JanData_'.$i),
                    Cache::tags($id)->get('_AIR_FebData_'.$i),
                    Cache::tags($id)->get('_AIR_MarData_'.$i),
                    Cache::tags($id)->get('_AIR_AprData_'.$i),
                    Cache::tags($id)->get('_AIR_MayData_'.$i),
                    Cache::tags($id)->get('_AIR_JunData_'.$i),
                    Cache::tags($id)->get('_AIR_JulData_'.$i),
                    Cache::tags($id)->get('_AIR_AugData_'.$i),
                    Cache::tags($id)->get('_AIR_SepData_'.$i),
                    Cache::tags($id)->get('_AIR_OctData_'.$i),
                    Cache::tags($id)->get('_AIR_NovData_'.$i),
                    Cache::tags($id)->get('_AIR_DecData_'.$i),
                ]);
                Cache::tags($id)->put('_AIR_ytd_'.$i, $total[$i], $minutes);
            }

            $charts = [

                'chart' => ['type' => 'bar'],
                    'title' => '',
                'xAxis' => [
                    'categories' => [Cache::tags($id)->get('_year')]
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Domestic',
                        'data' => [0,floatval(str_replace(',','', Cache::tags($id)->get('_total_dom')))],
                        'color' => '#2d5554',
                    ],
                    [
                        'name' => 'International',
                        'data' => [0,floatval(str_replace(',','', Cache::tags($id)->get('_total_intl')))],
                        'color' => '#807f4d',
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('air', array(
                'id' => $id,
                'charts' => $charts,
                'title' => $title,
            ));
        }

        $error = 'Please select filter parameters first.';
        return view('dashboard', array(
            'id' => $id,
            'error' => $error,
        ));
    }

    public function viewHotel()
    {
        $id = Auth::id();

        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1') && Cache::tags($id)->has('_client2')) {

            $title = 'HOTEL Sales '. Cache::tags($id)->get('_year');

            $charts = [

                'chart' => ['type' => 'bar'],
                'title' => [
                    'text' => '',
                ],
                'xAxis' => [
                    'categories' => [
                        Cache::tags($id)->get('_year'),
                    ]
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                    [
                        'name' => Cache::tags($id)->get('_clientname'),
                        'data' => [floatval(str_replace(',','', Cache::tags($id)->get('_total_hotel')))],
                        'color' => '#2d5554',
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('hotel', array(
                'id' => $id,
                'charts' => $charts,
                'title' => $title,
            ));

            exit;
        }

        $error = 'Please select filter parameters first.';
        return view('dashboard', array(
            'id' => $id,
            'error' => $error,
        ));
    }

    public function viewRail()
    {
        $id = Auth::id();

        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1') && Cache::tags($id)->has('_client2')) {

            $title = '';

            $charts = [

                'chart' => ['type' => 'bar'],
                'title' => '',
                'xAxis' => [
                    'categories' => ['RAIL']
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Rail',
                        'data' => [floatval(str_replace(',','', Cache::tags($id)->get('_total_rail')))],
                        'color' => '#2d5554',
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('rail', array(
                'id' => $id,
                'charts' => $charts,
                'title' => $title,
            ));

            exit;
        }

        $error = 'Please select filter parameters first.';
        return view('dashboard', array(
            'id' => $id,
            'error' => $error,
        ));
    }

    public function viewCar()
    {
        $id = Auth::id();

        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1') && Cache::tags($id)->has('_client2')) {

            $title = 'CAR Sales '. Cache::tags($id)->get('_year');

            $charts = [

                'chart' => ['type' => 'bar'],
                'title' => '',
                'xAxis' => [
                    'categories' => ['CAR']
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'CAR',
                        'data' => [floatval(str_replace(',','', Cache::tags($id)->get('_total_car')))],
                        'color' => '#2d5554',
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('car', array(
                'id' => $id,
                'charts' => $charts,
                'title' => $title,
            ));

            exit;
        }

        $error = 'Please select filter parameters first.';
        return view('dashboard', array(
            'id' => $id,
            'error' => $error,
        ));
    }

    public function viewVisa()
    {
        $id = Auth::id();

        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1') && Cache::tags($id)->has('_client2')) {

            $title = 'VISA Sales '. Cache::tags($id)->get('_year');

            $charts = [

                'chart' => ['type' => 'column'],
                'title' => '',
                'xAxis' => [
                    'categories' => ['VISA']
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Visa',
                        'data' => [floatval(str_replace(',','', Cache::tags($id)->get('_total_visa')))],
                        'color' => '#2d5554',
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('visa', array(
                'id' => $id,
                'charts' => $charts,
                'title' => $title,
            ));

            exit;
        }

        $error = 'Please select filter parameters first.';
        return view('dashboard', array(
            'id' => $id,
            'error' => $error,
        ));
    }

    public function viewFees()
    {
        $id = Auth::id();

        if (Cache::tags($id)->has('_year') && Cache::tags($id)->has('_client1') && Cache::tags($id)->has('_client2')) {

            $title = 'TRANSACTION FEES Sales '. Cache::tags($id)->get('_year');

            $charts = [

                'chart' => ['type' => 'bar'],
                'title' => '',
                'xAxis' => [
                    'categories' => ['FEES']
                ],
                'yAxis' => [
                    'title' => [
                        'text' => 'Sales ($)'
                    ]
                ],
                'series' => [
                    [
                        'name' => 'Fees',
                        'data' => [floatval(str_replace(',','', Cache::tags($id)->get('_total_fees')))],
                        'color' => '#2d5554',
                    ],
                ],
                'credits' => [
                    'enabled' => false,
                ],
            ];

            return view('fees', array(
                'id' => $id,
                'charts' => $charts,
                'title' => $title,
            ));

            exit;
        }

        $error = 'Please select filter parameters first.';
        return view('dashboard', array(
            'id' => $id,
            'error' => $error,
        ));
    }

    public function viewAdmin()
    {
        $id = Auth::id();
        return view('admin', array(
            'id' => $id,
        ));
    }

    /*
     * Admin section - Create User
     */
    public function createUser() 
    {
        $userid = Auth::id();
        $users = User::where('id', '!=', $userid)->get();

        return view('add_user', array(
            'users' => $users,
        ));
    }

    public function storeUser()
    {
        $messages = [
            'firstname.max' => 'Your first name may not be greater than 50 characters.',
            'firstname.required' => 'First Name is a required field.',
            'lastname.max' => 'Your last name may not be greater than 50 characters.',
            'lastname.required' => 'Last Name is a required field.',
            'email.required' => 'Email is a required field.',
            'password.same' => 'Password did not match',
            'password.required' => 'Password is required.',
            'password2.same' => 'Password did not match',
            'password2.required' => 'Password confirmation is required.',
        ];

        $validator = Validator::make(Input::all(), [
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|min:6|same:password2',
            'password2' => 'required|same:password',
        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/user/create')
                ->withErrors($validator)
                ->withInput();
        }

        //Create new user
        $user = new User;
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->email = Input::get('email');
        $user->name = Input::get('firstname').' '.Input::get('lastname');
        $user->password = bcrypt(Input::get('password'));
        $user->isActive = 1;
        $user->save();

        //Add to default group USER
        $usergroup = new UserGroup;
        $usergroup->UserID = $user->id;
        $usergroup->GroupCode = 'USER';
        $usergroup->save();

        return redirect('admin/user/create');
    }

    public function destroyUser(Request $request)
    {
        $id = $request->get('id');

        if($request->get('status') == '1') {
            User::where('id', $id)
                ->update(['isActive' => 0]);
        } else {
            User::where('id', $id)
                ->update(['isActive' => 1]);
        }

        return redirect('admin/user/create');
    }

    /*
     * Admin section - Create Group
     */
    public function createGroup() 
    {
        $groups = Group::all();

        return view('add_group', array(
            'groups' => $groups
        ));
    }
    
    public function storeGroup(Request $request) 
    {
        $messages = [
            'groupname.max' => 'Group Name may not be greater than 50 characters.',
            'groupname.required' => 'Group Name is a required field.',
            'groupcode.max' => 'Group Code may not be greater than 8 characters.',
            'groupcode.required' => 'Group Code is a required field.',
        ];

        $validator = Validator::make($request->all(), [
            'groupname' => 'required|max:50',
            'groupcode' => 'required|max:8',
        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/group/create')
                ->withErrors($validator)
                ->withInput();
        }

        $group = new Group;
        $group->GroupName = $request->get('groupname');
        $group->GroupCode = $request->get('groupcode');
        $group->description = $request->get('description');
        $group->save();

        return redirect('admin/group/create');
    }

    public function destroyGroup(Request $request)
    {
        $id = $request->get('id');

        if($request->get('status') == '1') {
            Group::where('id', $id)
                ->update(['isActive' => 0]);
        } else {
            Group::where('id', $id)
                ->update(['isActive' => 1]);
        }

        return redirect('admin/group/create');
    }

    public function createUserGroup()
    {
        $usergroups = UserGroup::all();
        $users = User::where('isActive', 1)->get();
        $groups = Group::all();

        return view('add_usergroup', array(
            'usergroup' => new UserGroup,
            'users' => $users,
            'groups' => $groups,
        ));
    }

    public function storeUserGroup(Request $request)
    {
        $userid = $request->get('userid');
        if (UserGroup::where('UserID', $userid)->exists()) {
            UserGroup::where('UserID', $userid)
                ->update(['GroupCode' => $request->get('groupcode')]);
        } else {
            $usergroup = new UserGroup;
            $usergroup->UserID = $userid;
            $usergroup->GroupCode = $request->get('groupcode');
            $usergroup->save();
        }

        return redirect('admin/usergroup/create');
    }

    public function exportpage()
    {
        return view('export');
    }
}
