<?php

Route::get('/', 'PagesController@index');

Route::post('contact', 'PagesController@contact');

Route::get('terms-and-conditions', 'PagesController@termsAndConditions');

Route::any('/tickets-payment/confirmpayment', 'TicketsPaymentController@getConfirmpayment');

Route::any('/tickets-payment/cancelpayment', 'TicketsPaymentController@getCancelpayment');

Route::resource('tickets-payment', 'TicketsPaymentController');

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
    Route::resource('ticket', 'TicketsController');
    Route::resource('content', 'ContentsController');
    Route::get('pdf-download', 'AdminController@pdfDownload');
    Route::get('excel-download', 'AdminController@excelDownload');
});

