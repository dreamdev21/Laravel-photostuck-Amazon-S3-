<?php

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

/*Route::get('/', function () {
    return view('home');
});*/
Route::get('/', 'HomeController@index');


Auth::routes();
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/accounts/activate/{email}/{activationCode}', 'Auth\RegisterController@activate');

Route::get('/home', 'HomeController@index');
Route::get('/search', 'SearchController@index');
//Route::get('/artworks/show/{artwork_id}', 'ArtworkController@view');
Route::get('/artworks/{slug}', 'ArtworkController@view');
Route::get('/contributors/{contributor_id}', 'ContributorController@show');

Route::get('/customers/subscribe/{option}', 'CustomersController@subscribe');
Route::post('/customers/subscribe/', 'CustomersController@postSubscribe');
Route::get('/customers/checkout/{package}', 'CustomersController@checkout');
Route::post('/customers/checkout/', 'CustomersController@postCheckout');

Route::group(['middleware' => 'authenticated'], function(){
  // basic resources routes
  Route::get('/contributors', 'ArtworkController@index');
  Route::get('/contribute', 'ContributorController@create');
  Route::post('/contributors/store', 'ContributorController@store');
  Route::get('/contributors/edit/{artwork_id}', 'ContributorController@edit');
  Route::post('/contributors/update', 'ContributorController@update');
  Route::get('/contributors/delete/{artwork_id}', 'ContributorController@destroy');
  Route::get('/ok', 'ContributorController@ok');

  // artworks routes
  Route::get('/artworks', 'ArtworkController@index');
  Route::get('/artworks/create', 'ArtworkController@create');
  Route::post('/artworks/store', 'ArtworkController@store');
  Route::get('/artworks/edit/{artwork_id}', 'ArtworkController@edit');
  Route::post('/artworks/update', 'ArtworkController@update');
  Route::get('/artworks/delete/{artwork_id}', 'ArtworkController@destroy');
  Route::get('/artworks/approve/{artwork_id}', 'ArtworkController@approve');
  Route::get('/artworks/reject/{artwork_id}', 'ArtworkController@reject');
  Route::get('/artworks/hold/{artwork_id}', 'ArtworkController@hold');

  Route::resource('categories', 'CategoryController');
  Route::resource('packages', 'PackageController');
  Route::resource('subscriptions', 'SubscriptionController');
  Route::resource('customers', 'CustomersController');

  Route::resource('users', 'UsersController');
  Route::get('users/delete/{user_id}', 'UsersController@delete');
  Route::post('users/update', 'UsersController@update');
  Route::get('change-password', 'UsersController@changePassword');
  Route::post('change-password', 'UsersController@postChangePassword');

  // additional resources routes
  Route::get('/contributors/documents/{contributor_id}', 'ContributorController@downloadDocument');
  Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
  Route::get('/upload-artwork', 'ArtworkController@create');
  Route::post('/upload-artwork', 'ArtworkController@store');
  Route::post('/try-upload', 'ArtworkController@tryUpload');
  Route::post('/artworks/update-batch', 'ArtworkController@updateBatch');
  Route::get('/artworks/download/{artwork_id}', 'ArtworkController@download');
  Route::get('/artworks/add-to-mydownloads/{artwork_id}', 'ArtworkController@addToMyDownloads');

});

Route::group(['middleware' => 'admin'], function(){
  Route::get('/contributors', 'ContributorController@index');
  Route::get('/contributors/reject/{contributor_id}', 'ContributorController@reject');
  Route::get('/contributors/approve/{contributor_id}', 'ContributorController@approve');
  Route::get('/contributors/pending/{contributor_id}', 'ContributorController@switchToPending');

  Route::get('/subscriptions/cancel/{subscription_id}', 'SubscriptionController@cancel');
  Route::get('/subscriptions/mark-as-paid/{subscription_id}', 'SubscriptionController@markAsPaid');

});
