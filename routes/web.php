<?php


Route::group(['prefix' => 'api', 'middleware' => 'cors'], function () {


    Route::post("create_user", "API\APIController@create_user");
    Route::post("do_login_user", "API\APIController@do_login_user");
    Route::post("recover_password", "API\APIController@recover_password");
    Route::post("crear_employer", "API\APIController@crear_employer");
    Route::post("create_user_with_facebook", "API\APIController@create_user_with_facebook");


    Route::post("get_states", "API\APIController@get_states");
    Route::post("get_municipaly_by_state", "API\APIController@get_municipaly_by_state");
    Route::post("get_colony_by_municipaly", "API\APIController@get_colony_by_municipaly");
    Route::post("get_profile_information", "API\APIController@get_profile_information");
    Route::post("save_profile", "API\APIController@save_profile");
    Route::post("update_photo", "API\APIController@update_photo");
    Route::post("save_job_experience", "API\APIController@save_job_experience");
    Route::post("get_job_experiences", "API\APIController@get_job_experiences");
    Route::post("delete_job_experience", "API\APIController@delete_job_experience");

    Route::post("save_study_experience", "API\APIController@save_study_experience");
    Route::post("get_study_experiences", "API\APIController@get_study_experiences");
    Route::post("delete_study_experience", "API\APIController@delete_study_experience");

    Route::post("new_search_jobs", "API\APIController@new_search_jobs");
    Route::post("search_jobs", "API\APIController@search_jobs");
    Route::post("get_job", "API\APIController@get_job");
    Route::post("user_apply_job", "API\APIController@user_apply_job");
    Route::post("user_cancel_job", "API\APIController@user_cancel_job");

    Route::post("search_jobs_by_business_id", "API\APIController@search_jobs_by_business_id");
    Route::post("get_notification_by_user", "API\APIController@get_notification_by_user");
    Route::post("get_jobs_postulated_by_user", "API\APIController@get_jobs_postulated_by_user");
    Route::post("save_push_notification", "API\APIController@save_push_notification");
    Route::post("remove_push_notification", "API\APIController@remove_push_notification");
    Route::post("get_message_to_user", "API\APIController@get_message_to_user");

    Route::post("get_business_information", "API\APIController@get_business_information");
    Route::post("do_login_employer", "API\APIController@do_login_employer");
    Route::post("save_profile_business", "API\APIController@save_profile_business");
    Route::post("get_job_plans", "API\APIController@get_job_plans");
    Route::post("get_job_plan", "API\APIController@get_job_plan");

    Route::post("make_payment", "API\APIController@make_payment");
    Route::post("get_last_card_payment", "API\APIController@get_last_card_payment");
    Route::post("get_packaged_buyed", "API\APIController@get_packaged_buyed");
    Route::post("get_job_by_employer", "API\APIController@get_job_by_employer");
    Route::post("get_job_information", "API\APIController@get_job_information");
    Route::post("get_job_categories", "API\APIController@get_job_categories");
    Route::post("get_parent_job_categories", "API\APIController@get_parent_job_categories");
    Route::post("save_job", "API\APIController@save_job");    
    Route::post("get_school_categories", "API\APIController@get_school_categories");
    Route::post("get_data_new_job", "API\APIController@get_data_new_job");
    Route::post("save_job_to_post", "API\APIController@save_job_to_post");
    Route::post("get_packaged_buyed_available", "API\APIController@get_packaged_buyed_available");
    Route::post("post_job", "API\APIController@post_job");
    Route::post("delete_job", "API\APIController@delete_job");
    Route::post("save_job_to_post_new_object", "API\APIController@save_job_to_post_new_object");
    Route::post("validate_fields_of_job", "API\APIController@validate_fields_of_job");
    Route::post("get_new_jobs_paginated", "API\APIController@get_new_jobs_paginated");
    Route::post("get_jobs_paginated", "API\APIController@get_jobs_paginated");
    Route::post("get_candidates_by_busines_app_user", "API\APIController@get_candidates_by_busines_app_user");
    Route::post("get_profile_information_with_details", "API\APIController@get_profile_information_with_details");
    Route::post("buy_view_profile", "API\APIController@buy_view_profile");
    Route::post("search_candidates", "API\APIController@search_candidates");
    Route::post("send_message_to_user", "API\APIController@send_message_to_user");
    Route::post("make_payment_oxxo", "API\APIController@make_payment_oxxo");
    Route::post("get_message_list_by_bussines_and_app_user", "API\APIController@get_message_list_by_bussines_and_app_user");
    Route::post("make_payment_spei", "API\APIController@make_payment_spei");
    Route::post("get_invoice_information", "API\APIController@get_invoice_information");
    Route::post("save_invoice_information", "API\APIController@save_invoice_information");
    Route::post("check_invoice_information", "API\APIController@check_invoice_information");
    Route::post("save_job_as_eraser_obligated_fields", "API\APIController@save_job_as_eraser_obligated_fields");
    Route::post("check_if_job_process_with_plan", "API\APIController@check_if_job_process_with_plan");
 
    Route::post("get_job_title_to_search", "API\APIController@get_job_title_to_search");
    Route::post("get_job_business_to_search", "API\APIController@get_job_business_to_search");
    Route::post("get_job_location_to_search", "API\APIController@get_job_location_to_search");


});


Route::get('testqr', 'API\APIController@testqr');
Route::post('confirm_payment', 'API\APIController@confirm_payment');


Route::get('/', function () {
    return redirect('cms');
});


Route::get('export_jobs', 'ExportExcelJobsController@export_jobs');


Route::group(['prefix' => 'cms'], function () {

    Route::get('/', 'Back\AccountController@getHome')->name('login');

    Route::group(['prefix' => 'account'], function () {

        Route::get('logout', 'Back\AccountController@getLogout')->name('admin_logout');
        Route::post('login', 'Back\AccountController@postLogin')->name('admin_login');
        Route::post('password/reset', 'Back\AccountController@postReset')->name('password.reset');
    });

    Route::group(['middleware' => ['auth']], function () {

        Route::group(['prefix' => 'dashboard'], function () {

            Route::get('/', 'Back\Dashboard\DashboardController@index');

            Route::group(['prefix' => 'system'], function () {


                Route::group(['prefix' => 'user'], function () {
                    Route::get('/', 'Back\Dashboard\System\UserController@index')->name('user_index');
                    Route::get('create', 'Back\Dashboard\System\UserController@create')->name('user_create_get');
                    Route::post('store', 'Back\Dashboard\System\UserController@store')->name('user_create');
                    Route::get('edit/{id}', 'Back\Dashboard\System\UserController@edit')->name('user_edit');
                    Route::post('update/{id}', 'Back\Dashboard\System\UserController@update')->name('user_update');
                    Route::get('delete/{id}', 'Back\Dashboard\System\UserController@destroy')->name('user_delete');

                    Route::get('edit_unique/{id}', 'Back\Dashboard\System\UserController@edit_unique')->name('user_unique_edit');
                    Route::post('update_unique/{id}', 'Back\Dashboard\System\UserController@update_unique')->name('user_unique_update');

                });


                Route::group(['prefix' => 'profile'], function () {
                    Route::get('/', 'Back\Dashboard\System\ProfileController@index')->name('profile_index');
                    Route::get('create', 'Back\Dashboard\System\ProfileController@create')->name('profile_create');
                    Route::post('store', 'Back\Dashboard\System\ProfileController@store')->name('profile.store');
                    Route::get('edit/{id}', 'Back\Dashboard\System\ProfileController@edit')->name('profile.edit');
                    Route::post('update', 'Back\Dashboard\System\ProfileController@update')->name('profile.update');
                    Route::get('getData', 'Back\Dashboard\System\ProfileController@getData')->name('profile.data');
                    Route::get('view/{id}', 'Back\Dashboard\System\ProfileController@show')->name('profile.view');
                    Route::get('delete/{id}', 'Back\Dashboard\System\ProfileController@destroy')->name('profile.delete');
                });
            });

            Route::group(['prefix' => 'paquetes'], function () {
                Route::get('/', 'Back\Package\PackageSellController@index')->name("paquetes.index");
                Route::get('create', 'Back\Package\PackageSellController@create')->name("paquetes.create");
                Route::post('store', 'Back\Package\PackageSellController@store')->name("paquetes.store");
                Route::get('edit/{id}', 'Back\Package\PackageSellController@edit')->name("paquetes.edit");
                Route::post('update/{id}', 'Back\Package\PackageSellController@update')->name("paquetes.update");
                Route::get('delete/{id}', 'Back\Package\PackageSellController@destroy')->name("paquetes.destroy");
            });


            Route::group(['prefix' => 'resports'], function () {

                Route::group(['prefix' => 'purchase'], function () {
                    Route::get('/', 'Back\Reports\PurchasesController@index')->name("purchasesreport.index");
                    Route::get('view/{packaged_buyed_by_user_id}', 'Back\Reports\PurchasesController@view_invoices')->name("purchasesreport.view");
                    Route::get('download_pdf/{invoice_id}', 'Back\Reports\PurchasesController@download_pdf')->name("purchasesreport.download_pdf");
                    Route::get('download_xml/{invoice_id}', 'Back\Reports\PurchasesController@download_xml')->name("purchasesreport.download_xml");
                    Route::get('download_wrong_xml/{invoice_id}', 'Back\Reports\PurchasesController@download_wrong_xml')->name("purchasesreport.download_wrong_xml");
                    Route::get('generate_invoice/{invoice_id}', 'Back\Reports\PurchasesController@generate_invoice')->name("purchasesreport.generate_invoice");
                });

                Route::group(['prefix' => 'jobs'], function () {
                    Route::get('/', 'Back\Reports\JobsController@index')->name("jobsreport.index");
                    Route::get('view/{job_id}', 'Back\Reports\JobsController@view')->name("jobsreport.view");
                    Route::get('publish_job/{job_id}', 'Back\Reports\JobsController@publish_job')->name("jobsreport.publish_job");
                    Route::get('unpublish_job/{job_id}', 'Back\Reports\JobsController@unpublish_job')->name("jobsreport.unpublish_job");
                });

            });


        });


    });

});

//Test
Route::get('testfirebase', 'TestController@test');


//Banners
Route::get('/ad/1', function () {
    return redirect('http://www.esem.edu.mx/');
});
Route::get('/ad/2', function () {
    return redirect('https://web.facebook.com/segurosernestovillarreal');
});
Route::get('/ad/3', function () {
    return redirect('https://www.instagram.com/mcseguro/');
});
Route::get('/ad/4', function () {
    return redirect('https://www.facebook.com/AsesoresMonterreySOC/');
});
Route::get('/ad/5', function () {
    return redirect('https://www.facebook.com/MD30AGENCY/');
});