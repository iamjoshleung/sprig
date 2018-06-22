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

Route::get('/styles', function () {
    return view('styles');
})->name('styles');

Route::get('/', function () {
    return view('index');
})->name('index');

// Route::get('/download', function () {
//     return view('download');
// })->name('download.show');

Route::get('/feedback', function () {
    return view('feedback');
})->name('feedback');

Route::post('/feedback', function (ReceiveFeedback $request) {
    Mail::to(env('MAIL_TO', 'contact@example.com'))->send(new FeedbackSent($request->all()));
    return response()->json([], 204);
});

Route::get('/about', function () {
    return view('about');
})->name('about');

// Route::get('/contact', function () {
//     return view('contact');
// })->name('contact');

Route::get('/service-policy', function () {
    return view('service-policy');
})->name('service-policy');

Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');

// Route::get('/privacy-policy', function () {
//     return view('privacy-policy');
// })->name('privacy-policy');

Route::get('/copyright', function () {
    return view('copyright');
})->name('copyright');

// Route::get('/takedown-guidance', function () {
//     return view('takedown-guidance');
// })->name('takedown-guidance');

Route::post('/file-upload', function () {
    return response()->json('Unable to upload this file. Try again later.');
});

Route::post('files', 'FileController@store');
Route::get('files/{file}', 'FileController@show')->name('files.show');
Route::get('files/{file}/token', 'FileController@generateToken')->name('files.token');
Route::get('files/{file}/download/{downloadToken}', 'FileController@download')->name('files.download');
Route::delete('files/{file}/{token}', 'FileController@destroy')->name('files.destroy');
Route::post('/verify-recaptcha', function (Request $request) {
    $client = new \GuzzleHttp\Client();
    $res = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
        'form_params' => [
            'g-recaptcha-response' => $request->input('g-recaptcha-response'),
            'secret' => env('RECAPTCHA_SCRET', 'secret')
        ]
    ]);

    return response([], $res->getStatusCode());
});

Route::prefix('cm')->group(function () {
    Route::get('/', 'AdminController@index')->name('cm.index');

    Route::namespace('Admin')->group(function () {
        Route::get('/files', 'FileController@index')->name('cm.files.index');
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

