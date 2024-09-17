<?php

use Illuminate\Support\Facades\Route;

Route::name('front.')
    ->group(function () {
        Route::name('auth.')
            ->namespace('Auth')
            ->group(function () {
                Route::post('login', 'LoginController@login')->name('login');
                Route::post('forgot/password', 'ForgotPasswordController@sendResetLinkEmail')->name('forgot.password');
                Route::post('password/change', 'ResetPasswordController@reset')->name('password.change');
            });

        Route::name('helpers.')
            ->group(function () {
                Route::name('device.')
                    ->prefix('device')
                    ->group(function () {
                        Route::post('data', 'DeviceDataController@add')->name('data');
                    });
            });

        Route::name('jwtauthentificated.')
            ->middleware(['jwt.auth'])
            ->name('patient.')
            ->group(function () {
                Route::post('account', 'FrontController@account')->name('user');

                // Weight
                Route::name('weight.')
                    ->prefix('weight')
                    ->group(function () {
                        Route::post('/', 'PatientWeightController@index')->name('list');
                        Route::post('/paginated', 'PatientWeightController@getPaginated')->name('listonpages');
                        Route::post('/add', 'PatientWeightController@add')->name('add');
                    });

                // BP
                Route::name('blood_pressure.')
                    ->prefix('blood_pressure')
                    ->group(function () {
                        Route::post('/', 'PatientBloodPressureController@index')->name('list');
                        Route::post('/paginated', 'PatientBloodPressureController@getPaginated')->name('listonpages');
                        Route::post('/add', 'PatientBloodPressureController@add')->name('add');
                    });
                // oxygen
                Route::name('blood_oxygen.')
                    ->prefix('blood_oxygen')
                    ->group(function () {
                        Route::post('/', 'PatientBloodOxygenController@index')->name('list');
                        Route::post('/paginated', 'PatientBloodOxygenController@getPaginated')->name('listonpages');
                        Route::post('/add', 'PatientBloodOxygenController@add')->name('add');
                    });
                // glucose
                Route::name('blood_glucose.')
                    ->prefix('blood_glucose')
                    ->group(function () {
                        Route::post('/', 'PatientBloodGlucoseController@index')->name('list');
                        Route::post('/paginated', 'PatientBloodGlucoseController@getPaginated')->name('listonpages');
                        Route::post('/add', 'PatientBloodGlucoseController@add')->name('add');
                    });
            });




    });
