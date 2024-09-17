<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->group(function () {

        Route::name('admin.')
            ->group(function () {
                Route::name('auth.')
                    ->namespace('Auth')
                    ->group(function () {
                        Route::post('login', 'LoginController@login')->name('login');
                        Route::post('forgot/password', 'ForgotPasswordController@sendResetLinkEmail')->name('forgot.password');
                        Route::post('password/change', 'ResetPasswordController@reset')->name('password.reset');
                    });
                Route::name('jwtauthentificated.')
                    ->middleware(['jwt.auth'])
                    ->group(function () {
                        Route::post('account', 'AdminController@account')->name('user');


                        // Patients
                        Route::name('patients.')
                            ->prefix('patients')
                            ->group(function () {
                                Route::get('/misc', 'PatientsController@misc')->name('misc');
                                Route::post('/', 'PatientsController@index')->name('list');
                                Route::post('/get', 'PatientsController@get')->name('get');
                                Route::post('/add', 'PatientsController@add')->name('add');
                                Route::post('/update', 'PatientsController@update')->name('update');
                                Route::post('/updatepin', 'PatientsController@updatePin')->name('updatePin');
                                Route::post('/status', 'PatientsController@status')->name('status');
                                Route::post('/delete', 'PatientsController@delete')->name('delete');

                                // Patient
                                Route::name('patient.')
                                    ->group(function () {
                                        // Dasboard
                                        Route::name('data.')
                                            ->group(function () {
                                                Route::post('/download', 'PatientsController@getPatientHistory')->name('history');
                                            });

                                        // Bp
                                        // Weight
                                        Route::name('weight.')
                                            ->prefix('weight')
                                            ->group(function () {
                                                Route::post('/history', 'PatientsController@getPatientWeightHistory')->name('history');
                                                Route::post('/chart', 'PatientsController@getPatientWeightChart')->name('chart');
                                                Route::post('/delete', 'PatientsController@deletePatientWeight')->name('delete');
                                            });

                                        // Bp
                                        Route::name('bp.')
                                            ->prefix('bp')
                                            ->group(function () {
                                                Route::post('/history', 'PatientsController@getPatientBpHistory')->name('history');
                                                Route::post('/chart', 'PatientsController@getPatientBpChart')->name('chart');
                                                Route::post('/delete', 'PatientsController@deletePatientBp')->name('delete');
                                            });
                                        // Oxygen
                                        Route::name('oxygen.')
                                            ->prefix('oxygen')
                                            ->group(function () {
                                                Route::post('/history', 'PatientsController@getPatientOxygenHistory')->name('history');
                                                Route::post('/chart', 'PatientsController@getPatientOxygenChart')->name('chart');
                                                Route::post('/delete', 'PatientsController@deletePatientOxygen')->name('delete');
                                            });

                                        // Glucose
                                        Route::name('glucose.')
                                            ->prefix('glucose')
                                            ->group(function () {
                                                Route::post('/history', 'PatientsController@getPatientGlucoseHistory')->name('history');
                                                Route::post('/chart', 'PatientsController@getPatientGlucoseChart')->name('chart');
                                                Route::post('/delete', 'PatientsController@deletePatientGlucose')->name('delete');
                                            });
                                    });
                            });




                    });
            });
    });

