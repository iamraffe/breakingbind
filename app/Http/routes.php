<?php

Route::get('/', 'PagesController@index');

Route::post('register', 'PagesController@register');

Route::post('contact', 'PagesController@contact');

Route::get('terms-and-conditions', 'PagesController@termsAndConditions');

Route::any('/registration-payment/confirmpayment', 'RegistrationPaymentController@getConfirmpayment');

Route::any('/registration-payment/cancelpayment', 'RegistrationPaymentController@getCancelpayment');

Route::resource('registration-payment', 'RegistrationPaymentController');

Route::any('/raffle-payment/confirmpayment', 'RafflePaymentController@getConfirmpayment');

Route::any('/raffle-payment/cancelpayment', 'RafflePaymentController@getCancelpayment');

Route::resource('raffle-payment', 'RafflePaymentController');

/**
 * Auth handling
 */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/**
 * Admin area - Backend routes.
 */
Route::get('admin', ['middleware' => 'auth', 'uses' => 'AdminController@index']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function()
{
    //Route::resource('users', 'UsersController');
    Route::resource('registrations', 'RegistrationsController');
    Route::resource('raffle', 'RaffleController');
    Route::get('pdf-download', 'AdminController@pdfDownload');
    Route::get('excel-download', 'AdminController@excelDownload');
});

