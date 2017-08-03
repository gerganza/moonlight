<?php
use App\Profile;

Route::get('/', function () {
   return view('auth/login');
});

Auth::routes();

/*
 * Dashboard
 */
Route::prefix('home')->group(function () {
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::get('dashboard', 'HomeController@viewDashboard');
    Route::post('clientlist/update', 'HomeController@updateClientList');
    Route::post('report/generate', 'HomeController@generateReport');
});


/*
 * User
 */
Route::prefix('user')->group(function () {
    Route::get('profile', 'HomeController@viewProfile')->name('profile');
    Route::post('profile/update', 'HomeController@updateProfile');
});

/*
 * AIR
 */
Route::prefix('air')->group(function () {
    Route::get('/', 'HomeController@viewAir')->name('air');
});


/*
 * HOTEL
 */
Route::prefix('hotel')->group(function () {
    Route::get('/', 'HomeController@viewHotel')->name('hotel');
});

/*
 * RAIL
 */
Route::prefix('rail')->group(function () {
    Route::get('/', 'HomeController@viewRail')->name('rail');
});

/*
 * CAR
 */
Route::prefix('car')->group(function () {
    Route::get('/', 'HomeController@viewCar')->name('car');
});

/*
 * VISA
 */
Route::prefix('visa')->group(function () {
    Route::get('/', 'HomeController@viewVisa')->name('visa');
});

/*
 * FEES
 */
Route::prefix('fees')->group(function() {
    Route::get('/', 'HomeController@viewFees')->name('fees');
});

/*
 * ADMIN
 */
Route::prefix('admin')->group(function () {
    Route::get('/', 'HomeController@viewAdmin')->name('admin');
    //User
    Route::get('user/create', 'HomeController@createUser')->name('createuser');
    Route::post('user/store', 'HomeController@storeUser');
    Route::post('user/destroy', 'HomeController@destroyUser');

    //Group
    Route::get('group/create', 'HomeController@createGroup')->name('creategroup');
    Route::post('group/store', 'HomeController@storeGroup');
    Route::post('group/destroy', 'HomeController@destroyGroup');

    //User Group
    Route::get('usergroup/create', 'HomeController@createUserGroup')->name('createusergroup');
    Route::post('usergroup/store', 'HomeController@storeUserGroup');
});




Route::get('/exportpage', 'HomeController@exportpage')->name('exportpage');

Route::get('/export', function() {
   $data = array(
       array('data1', 'data2'),
       array('data3', 'data4')
   );

   Excel::create('Testing', function($excel) use($data) {



      $excel->sheet('Sheet1', function($sheet) use($data) {

         $sheet->fromArray($data);

         $sheet->cell('A1:A5', function($cell) {

            // manipulate the range of cells
            $cell->setValue('Gerard');

         });

      });



   })->export('xls');
});
