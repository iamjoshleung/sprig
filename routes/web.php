<?php

use App\Mail\FeedbackSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReceiveFeedback;

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

// Route::get('/styles', function () {
//     return view('styles');
// })->name('styles');

Route::get('/', 'PageController@index')->name('index');

// Pages
Route::get('/feedback', 'PageController@getFeedback')->name('feedback');
Route::post('/feedback', 'PageController@postFeedback');
Route::get('/about', 'PageController@about')->name('about');
Route::get('/service-policy', 'PageController@servicePolicy')->name('service-policy');
Route::get('/terms-of-service', 'PageController@termsOfService')->name('terms-of-service');
Route::get('/copyright', 'PageController@copyright')->name('copyright');

// Files
Route::post('files', 'FileController@store');
Route::get('files/{file}', 'FileController@show')->name('files.show');
Route::get('files/{file}/token', 'FileController@generateToken')->name('files.token');
Route::get('files/{file}/download/{downloadToken}', 'FileController@download')->name('files.download');
Route::delete('files/{file}/{token}', 'FileController@destroy')->name('files.destroy');
Route::post('/verify-recaptcha', 'RecaptchaController@verify');

// Photosets
Route::get('/photosets', 'PhotosetController@index')->name('photosets.index');
Route::delete('/photosets/{photoset}', 'PhotosetController@destroy')->name('photosets.destroy')->middleware('auth.admin');

// Videos
Route::get('/videos', 'VideoController@index')->name('videos.index');

Route::prefix('cm')->group(function () {
    Route::get('/', 'AdminController@index')->name('cm.index');


    Route::namespace('Admin')->group(function () {
        Route::get('/files', 'FileController@index')->name('cm.files.index');
        Route::delete('/files/{file}', 'FileController@destroy')->name('cm.files.destroy');

        Route::get('/sites', 'TumblrSiteController@index')->name('cm.sites.index');

        Route::post('/sites', 'TumblrSiteController@store')->name('cm.sites.store');
        Route::delete('/sites/{tumblr_site}', 'TumblrSiteController@destroy')->name('cm.sites.destroy');
    });

    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('cm.login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('cm.logout');
    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
});

