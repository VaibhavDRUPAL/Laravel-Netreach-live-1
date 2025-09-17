<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Chatbot_Controller\ChatbotController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCategoriesController;
use App\Http\Controllers\Language_Controller\LanguageController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\Self_Controlller\RiskAssessmentController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


/*Route::get('/', function () {

	$token = "page_second";
	$keys = Crypt::encryptString($token);
	return view('home.home',["keys"=>$keys]);
	//return redirect()->route('home');
});*/
Route::get('/testscript',function(){
	return view('testscript');
});
Route::post('/translator', 'SurveyController@translator')->name("translator");

// ----------------default routes -------------------
Route::get('/', function () {
	return redirect('/' . app()->getLocale());
});
Route::get('/about-us', function () {
	return redirect('/en/about-us'); // Redirect to default locale
})->name('about-us');
Route::get('/faqs', function () {
	return redirect('/en/faqs');
})->name('faqs');
Route::get('/contact-us', function () {
	return redirect('/en/contact-us');
})->name('contact-us');
Route::get('/our-team', function () {
	return redirect('/en/our-team');
})->name('our-team');
Route::get('/self-risk-assessment/{name?}', function () {
	return redirect('/en/self-risk-assessment');
})->name('letsgo');
Route::get('/questionnaire', function () {
	return redirect('/en/questionnaire');
})->name('survey.questionnaire');
Route::get('/book-appoinment', function () {
	return redirect('/en/book-appoinment');
})->name('survey.book-appoinment');
Route::post('/verifyMobileOTP', function () {
	return redirect('/en/verifyMobileOTP');
})->name("verifyMobileOTP");
Route::get('/survey-appointment', function () {
	return redirect('/en/survey-appointment');
})->name('survey.appointment');
Route::post('/bookAppointment', function () {
	return redirect('/en/bookAppointment');
})->name("bookAppointment");
Route::get('/privacy-policy', function () {
	return redirect('/en/privacy-policy');
})->name('privacy-policy');
Route::get('/prep-consultation/book-appoinment', function () {
	return redirect('/en/prep-consultation/book-appoinment');
})->name('survey.prep-book-appoinment');
Route::get('/blog', function () {
	return redirect('/en/blog');
})->name('blog');
Route::get('/blog-details/{id}/{title}', function ($id, $title) {
	return redirect("/en/blog-details/$id/$title");
})->name('blog-details');

Route::get('/sra', function () {
	return redirect('/en/sra');
})->name('sra');
Route::get('/sra/{key}', function ($key) {
	return redirect("/en/sra/$key");
})->name('self.sra');
// -----------------------------------




// ----------------language routes -------------------
Route::prefix('{locale}')
	->where(['locale' => 'en|hi|te|ta|mr'])
	->middleware('setlocale')
	->group(function () {
		Route::get('/', 'SurveyController@home')->name('home');
		Route::get('/about-us', 'SurveyController@about_us')->name('about-us');
		Route::get('/faqs', 'SurveyController@faq_us')->name('faqs');
		Route::get('/contact-us', 'SurveyController@contact_us')->name('contact-us');
		Route::get('/our-team', 'SurveyController@our_team')->name('our-team');
		Route::get('/self-risk-assessment/{name?}', 'SurveyController@index')->name('letsgo');
		Route::get('/questionnaire', 'SurveyController@getQuestionnaire')->name('survey.questionnaire');
		Route::post('/survey-appointment', 'SurveyController@addSurvey')->name('survey.appointment');
		Route::get('/book-appoinment', 'SurveyController@bookAppoinment')->name('survey.book-appoinment');
		Route::post('/verifyMobileOTP', 'SurveyController@verify_mobile_otp')->name("verifyMobileOTP");
		Route::controller(RiskAssessmentController::class)->group(function () {
			Route::get('sra', 'sra')->name('sra');
			Route::post('bookAppointment', 'bookAppointment')->name("bookAppointment");
			Route::get('sra/{key}', 'setVnForSRA')->name('self.sra');
		});
		Route::get('/privacy-policy', 'SurveyController@disclaimer')->name('privacy-policy');
		Route::get('/prep-consultation/book-appoinment', 'SurveyController@bookAppoinment')->name('survey.prep-book-appoinment');
		Route::get('/blog', 'SurveyController@blog')->name('blog');
		Route::get('/blog-details/{id}/{title}', 'SurveyController@blog_details')->name('blog_details');
	});


// -----------------------------------


// Route::get('/', 'SurveyController@home')->name('home');
Route::get('/cron', 'CronJobController@cronJob')->name('cron-job');

if (!App::isProduction())
	Route::get('test', [TestController::class, 'test']);

/*
Route::group(['middleware' => ['web']], function () {
	die("");
});*/

Route::get('chatbot-layout', function () {
	return view('chatbot');
})->name('chatbot-layout');


Route::group(['prefix' => 'chatbot', 'controller' => ChatbotController::class], function () {
	Route::controller(ChatbotController::class)->group(function () {
		Route::get('greetings', 'getGreetings');
		Route::get('answer', 'getAnswer');
		Route::get('showMore', 'showMore');
		Route::get('thankYou', 'thankYou');
		Route::post('userDetails', 'userDetails');
		Route::get('reset-confirm', 'resetConfirm');
		Route::post('reset', 'resetChatbot');
	});
});

// Route::get('/letsgo/{page_name}', 'SurveyController@index')->name('letsgo');
// Route::get('/self-risk-assessment/{page_name}/{name?}', 'SurveyController@index')->name('letsgo');
// Route::get('/letsgo/{page_name}/{name?}', 'SurveyController@index')->name('letsgo');

// Route::get('/self-risk-assessment/{name?}', 'SurveyController@index')->name('letsgo');
Route::post('/letsgo_second', 'SurveyController@letsgo_sumit')->name('letsgo_second');
Route::post('/letsgo_third', 'SurveyController@letsgo_third')->name('letsgo_third');
Route::post('/letsgo_five', 'SurveyController@letsgo_five')->name('letsgo_five');
Route::post('/letsgo_six', 'SurveyController@letsgo_six')->name('letsgo_five');
Route::get('/client-information', 'SurveyController@register_client')->name('register_client');
Route::get('/center_register', 'SurveyController@center_register')->name('center_register');
Route::post('/center_register_store', 'SurveyController@center_register_store')->name('center_register_store');

Route::post('/sendMobileOTP', 'SurveyController@send_mobile_otp')->name('sendMobileOTP');

Route::post('/verifyMobileOTP', 'SurveyController@verify_mobile_otp');
Route::get('/add-answer', 'SurveyController@addAnswer');
Route::post('/appointment-booked', 'SurveyController@appointmentBooked')->name('survey.booked');

Route::get('/questionpart', 'SurveyController@question_part')->name('questionpart');

Route::post('/lets_go_disclaimer', 'SurveyController@lets_go_disclaimer')->name('lets_go_disclaimer');
Route::post('/user-register', 'SurveyController@user_register')->name('user_register');
Route::post('/pincode', 'SurveyController@pin_code')->name('pincode');
// Route::get('/blog', 'SurveyController@blog')->name('blog');

// Route::get('/blog-details/{id}/{title}', 'SurveyController@blog_details')->name('blog_details');
Route::get('/index', 'SurveyController@home_custom')->name('index');
Route::post('/varify-otp', 'SurveyController@varify_otp')->name('varify-otp');
Route::post('/resend-otp', 'SurveyController@resend_otp')->name('resend-otp');

Route::get('/services-required', 'SurveyController@services_required')->name('services-required');
Route::post('/services_required_submit', 'SurveyController@services_required_submit')->name('services_required_submit');
Route::post('/district', 'SurveyController@get_district_list')->name('district');
Route::post('/serch_by_district_centre', 'SurveyController@serch_by_district_centre')->name('serch_by_district_centre');
Route::post('/book_appoinment_submit', 'SurveyController@book_appoinment_submit')->name('book_appoinment_submit');
Route::get('/appointment-confirmed/{pdf_id}', 'SurveyController@appointment_confirmed')->name('appointment-confirmed');
Route::get('/genrated-pdf', 'SurveyController@generate_pdf')->name('genrated-pdf');

Route::get('refresh_captcha', 'HomeController@refreshCaptcha')->name('refresh_captcha');
Auth::routes(['verify' => true]);

Route::post('/get-user-exist', 'HomeController@get_user_exist_or_not')->name('usr.exist');

Route::controller(RiskAssessmentController::class)->group(function () {
	// Route::get('sra', function () {
	// 	return view('self.index');
	// })->name('sra');
	// Route::get('sra/{key}', 'setVnForSRA')->name('self.sra');
	Route::get('self-risk-assessment/form-submitted', 'selfSuccess')->name('self.form-submitted');
	Route::get('self-risk-assessment/{mobile?}', 'index')->name('self.index');
	Route::post('self-risk-assessment', 'storeRiskAssessment');
	Route::post('verifyOTP', 'verifyOTP');
	Route::get('getDistricts', 'getDistricts');
	Route::get('getDistricts2', 'getDistricts2');
	Route::get('getTestingCenters', 'getTestingCenters');
	Route::get('addCounter', 'addCounter');
	Route::get('updateNotificationStage', 'updateNotificationStage');
});

Route::get('district/getAll', 'DistrictController@getDistricts');
Route::get('get-centres', 'DistrictController@getAllTestCentres');

/**
 * OTP
 */
Route::post('sendOTP', [OTPController::class, 'sendOTP']);

Route::get('loginVerify', [LoginController::class, 'loginVerify']);

Route::group(['middleware' => ['auth', 'log']], function () {

	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/components', function () {
		return view('components');
	})->name('components');

	Route::get('all-export', 'UserController@export')->name('survey.export');
	Route::resource('users', 'UserController');

	Route::get('/survey/display', 'UserController@display')->name('survey.display');

	Route::get('/survey/displaysecond', 'UserController@displaysecond')->name('survey.displaysecond');

	Route::get('/survey/e-slip', 'UserController@eslip')->name('survey.eslip');
	Route::post('/survey/get-vn-by-region', 'UserController@survey_vn_by_region')->name('survey.vn.by.region');


	Route::post('/survey/filter', 'UserController@survey_filter')->name('survey.filter');

	Route::get('/survey/credit', 'UserController@credit_survey')->name('survey.credit');


	Route::get('/profile/{user}', 'UserController@profile')->name('profile.edit');

	//Route::get('/survey/display', 'UserController@display')->name('survey.display');
	Route::get('/survey/podisplay', 'UserController@podisplay')->name('survey.po.display');

	Route::post('/profile/{user}', 'UserController@profileUpdate')->name('profile.update');

	Route::resource('roles', 'RoleController')->except('show');

	Route::resource('permissions', 'PermissionController')->except(['show', 'destroy', 'update']);

	Route::resource('category', 'CategoryController')->except('show');

	Route::resource('post', 'PostController');

	Route::get('cms-category', 'CategoryController@index')->name('cat.index');
	Route::get('cms', 'CmsController@index')->name('cms.index');

	Route::get('/activity-log', 'SettingController@activity')->name('activity-log.index');

	Route::get('/settings', 'SettingController@index')->name('settings.index');

	Route::resource('platform', 'PlatformController')->except(['show', 'destroy', 'update']);
	Route::resource('genrate', 'GenrateController')->except(['show', 'destroy', 'update']);

	Route::get('/district', 'DistrictController@index')->name('district.index');
	Route::get('/district/list', 'DistrictController@list')->name('district.list');
	Route::get('/state', 'DistrictController@get_state')->name('state.index');
	Route::get('/centre', 'DistrictController@get_centre')->name('centre.index');

	Route::get('sample-template', 'DistrictController@downloadTemplate')->name('centre.sample-template');
	Route::post('/storecentre', 'DistrictController@store_centre')->name('centre.import');
	Route::get('exportCentre', 'DistrictController@export_centre')->name('centre.export');

	Route::get('/all-centre', 'DistrictController@get_centre')->name('all.centre.index');
	Route::get('/create-center', 'DistrictController@create_center')->name('center.create_center');
	Route::get('/admin-notification', 'DistrictController@admin_notification')->name('admin-notification');
	Route::post('/add-center', 'DistrictController@add_center')->name('center.add_center');
	Route::post('get_district_by_state', 'DistrictController@get_district_by_state')->name('district.state');

	Route::post('/settings', 'SettingController@update')->name('settings.update');

	Route::get('/user/vms', 'UserController@display_vms')->name('user.vms');
	Route::get('/user/vms/create', 'UserController@display_vms_create')->name('user.vms.create');
	Route::post('/user/store_vms', 'UserController@store_vms')->name('user.store_vms');

	Route::post('/upload-multiple-image-ajax', 'UserController@vn_upload_by_test')->name('vn.upload');
	Route::post('/po-survey-action', 'UserController@po_survey_action')->name('po.action');
	Route::post('/mul-po-survey-action', 'UserController@mul_po_survey_action')->name('mul.po.action');

	Route::get('/edit/{id}', 'DistrictController@center_edit')->name('center.edit');
	Route::post('get_city_by_state', 'DistrictController@get_city_by_state')->name('city.state');
	Route::post('edit_center_by_id', 'DistrictController@updateCentre')->name('edit.center');

	Route::post('dashboard', 'HomeController@dashboard_report')->name('dashboard.report');
	Route::get('/user/vns/{id}/edit', 'UserController@edit_display_vms_create')->name('vn.edit');
	Route::get('/user/vns/{id}/pass', 'UserController@viwe_display_vms_password')->name('vn.pass');
	Route::post('/user/vns/updpass', 'UserController@viwe_display_vms_password2')->name('vn.updpass');

	Route::post('edit_store_vns', 'UserController@edit_store_vns')->name('edit.store_vns');
	Route::post('/counseling', 'UserController@flag_counseling_update')->name('flag.counseling');
	Route::post('/po-admin-report', 'UserController@po_admin_wise_report')->name('po.report');


	Route::post('/deleteuser/{id}', 'UserController@flag_delete');

	Route::post('/get-district-by-state', 'UserController@district_state')->name('usr.district');

	Route::post('/get-region-by-state', 'UserController@region_by_state')->name('usr.region');

	Route::post('/get-state-by-district', 'UserController@state_by_district')->name('usr.statebydistrict');

	Route::post('/all-survey-report', 'UserController@all_survey_report')->name('all.survey.report');

	Route::post('/all-survey-report-slip', 'UserController@all_survey_report_slip')->name('all.survey.report.slip');

	Route::post('/user-status-update', 'UserController@user_status_update')->name('usr.staus.update');


	Route::post('/get-file-update', 'UserController@get_user_file_uploaded')->name('usr.file.upload');
	Route::post('/get-report-by-pie-chart', 'UserController@get_report_by_pie_chart')->name('dashboard.report.chart');

	Route::get('/reports', 'ReportController@get_me_report_by_pie_chart')->name('dashboard.report.me.chart');
	Route::post('/get-mereport-by-pie-chart', 'ReportController@get_mereport_by_pie_chart')->name('dashboard.mereport.chart');
	Route::post('/get-mereport-by-bar-chart', 'ReportController@get_mereport_by_bar_chart')->name('dashboard.mereport.bar.chart');
	Route::post('/get-mereport-by-service-chart', 'ReportController@get_mereport_by_bar_service')->name('dashboard.mereport.service.chart');
	Route::post('/get-mereport-by-availed-chart', 'ReportController@get_mereport_by_bar_availed')->name('dashboard.mereport.availed.chart');
	Route::post('/get-mereport-by-hivrate-chart', 'ReportController@get_mereport_by_hivrate_chart')->name('dashboard.mereport.hivrate.chart');
	Route::post('/get-mereport-by-hivreferral-chart', 'ReportController@get_mereport_by_referral_chart')->name('dashboard.mereport.referral.chart');
	Route::post('/get-mereport-by-stireferral-chart', 'ReportController@get_mereport_by_sti_chart')->name('dashboard.mereport.sti.chart');


	Route::get('media', function () {
		return view('media.index');
	})->name('media.index');

	Route::name('outreach.')->group(function () {
		Route::get('/outreach/download-sample', 'Outreach\ProfileController@downloadSample')->name('download');
		Route::get('/outreach/profile/search', 'Outreach\ProfileController@search')->name('profile.search');
		Route::resource('/outreach/profile', 'Outreach\ProfileController');
		Route::post('/outreach/profile/list', 'Outreach\ProfileController@list')->name('profile.list');
		Route::post('/ImportProfile', 'Outreach\ProfileController@ImportProfile')->name('Outreach.ImportProfile');

		Route::resource('/outreach/risk-assessment', 'Outreach\RiskAssessmentController');
		Route::post('/outreach/risk-assessment/list', 'Outreach\RiskAssessmentController@list')->name('risk-assessment.list');
		Route::post('/ImportRiskAssesment', 'Outreach\RiskAssessmentController@ImportRiskAssesment')->name('Outreach.ImportRiskAssesment');
		Route::post('outreach/risk-assessment/take-action', 'Outreach\RiskAssessmentController@takeAction');
		Route::post('outreach/risk-assessment/assign', 'Outreach\RiskAssessmentController@assign');

		Route::resource('/outreach/referral-service', 'Outreach\ReferralServiceController');
		Route::post('/outreach/referral-service/list', 'Outreach\ReferralServiceController@list')->name('referral-service.list');
		Route::post('/ImportReferralService', 'Outreach\ReferralServiceController@ImportReferralService')->name('Outreach.ImportReferralService');
		Route::post('outreach/referral-service/take-action', 'Outreach\ReferralServiceController@takeAction');
		Route::post('outreach/referral-service/assign', 'Outreach\ReferralServiceController@assign');

		Route::resource('/outreach/counselling', 'Outreach\CounsellingController');
		Route::post('/outreach/counselling/list', 'Outreach\CounsellingController@list')->name('counselling.list');
		Route::post('/ImportCounselling', 'Outreach\CounsellingController@ImportCounselling')->name('Outreach.ImportCounselling');
		Route::post('outreach/counselling/take-action', 'Outreach\CounsellingController@takeAction');
		Route::post('outreach/counselling/assign', 'Outreach\CounsellingController@assign');
		Route::resource('/outreach/plhiv', 'Outreach\PLHIVController');
		Route::post('/outreach/plhiv/list', 'Outreach\PLHIVController@list')->name('plhiv.list');
		Route::post('/Importplhiv', 'Outreach\PLHIVController@Importplhiv')->name('Outreach.Importplhiv');
		Route::post('outreach/plhiv/take-action', 'Outreach\PLHIVController@takeAction');
		Route::post('outreach/plhiv/assign', 'Outreach\PLHIVController@assign');

		Route::resource('/outreach/sti', 'Outreach\STIController');
		Route::post('/outreach/sti/list', 'Outreach\STIController@list')->name('sti.list');
		Route::post('/outreach/sti/take-action', 'Outreach\STIController@takeAction');

		Route::post('outreach/assign', 'Outreach\ProfileController@assign');
		Route::post('outreach/take-action', 'Outreach\ProfileController@takeAction');
		Route::post('outreach/delete', 'Outreach\ProfileController@deleteProfile');
	});
	Route::name('outreachVn.')->group(function () {
		Route::get('/calllog', 'Outreach\OutreachControllerVn@CallLogList')->name('outreachVn.calllog');
		Route::post('/calllog', 'Outreach\OutreachControllerVn@CallLogSave')->name('outreachVn.calllog.save');
		Route::get('/calllog/{id}', 'Outreach\OutreachControllerVn@getCallLog')->name('outreachVn.calllog.edit');
		Route::post('/calllog', 'Outreach\OutreachControllerVn@VnUpdate')->name('outreachVn.calllog.update');
		Route::post('/calllog', 'Outreach\OutreachControllerVn@outreachVnDelete')->name('outreachVn.calllog.delete');
	});

	Route::get('/center-appointments', 'Outreach\ReferralServiceController@index')->name('center-appointments');
	Route::get('/web-center-appointments', 'WebAppointmentController@index')->name('web-center-appointments');
	Route::post('/web-center-appointments', 'WebAppointmentController@list')->name('web-center-appointments.list');
	Route::put('/web-center-appointments/{appointment}', 'WebAppointmentController@update')->name('web-center-appointments.update');
	Route::get('/web-center-appointments/{appointment}', 'WebAppointmentController@edit')->name('web-center-appointments.edit');

	Route::get('/Netreach-Peer', 'NetreachPeerController@index')->name('Netreach-Peer');
	Route::post('/Netreach-Peer/list', 'NetreachPeerController@list')->name('Netreach-Peer.list');
	Route::get('/Netreach-Peer/create', 'NetreachPeerController@create')->name('Netreach-Peer.create');
	Route::post('/Netreach-Peer/store', 'NetreachPeerController@store')->name('Netreach-Peer.store');
	Route::get('/Netreach-Peer/edit/{netreach_peer}', 'NetreachPeerController@edit')->name('Netreach-Peer.edit');
	Route::PUT('/Netreach-Peer/update/{netreach_peer}', 'NetreachPeerController@update')->name('Netreach-Peer.update');
	Route::get('/Netreach-Peer/delete/{netreach_peer}', 'NetreachPeerController@destroy')->name('Netreach-Peer.destroy');


	Route::get('/calendar', function () {
		return view('calendar');
	})->name('calendar');

	Route::resource('/attendance', 'AttendanceController')->except(['create', 'edit', 'show', 'update']);
	Route::get('/import_excel', 'ManuallyController@import_excel');
	Route::get('/counsellingservices', 'ManuallyController@counsellingservices')->name('outreach.counselling.services');
	Route::post('/all-counsellingservices', 'ManuallyController@all_counsellingservices_report')->name('all.counselling.services');

	Route::get('/manually-dashboard', 'ManuallyController@manuallydashboard')->name('outreach.manually.dashboard');

	Route::get('/data-pie-chart', 'ManuallyController@datapiechart')->name('outreach.manually.datapiechart');
	Route::get('/data-pie-chart-risk', 'ManuallyController@datapiechartrisk')->name('outreach.manually.datapiechartrisk');
	Route::get('/data-pie-chart-referred', 'ManuallyController@datapiechartreferred')->name('outreach.manually.datapiechartreferred');
	Route::get('/data-pie-chart-availed-services', 'ManuallyController@datapiechartavailedservices')->name('outreach.manually.datapiechartavailedservices');
	Route::get('/data-pie-chart-hiv-positivity', 'ManuallyController@hivpositivity')->name('outreach.manually.hivpositivity');
	Route::get('/data-pie-chart-hiv-referralconversion-rate', 'ManuallyController@hiv_referralconversion_rate')->name('outreach.manually.hiv.referralconversion.rate');
	Route::get('/data-pie-chart-sti-positivity', 'ManuallyController@sti_positivity')->name('outreach.manually.hiv.sti.positivity');
	Route::get('/data-pie-chart-art-positivity', 'ManuallyController@art_positivity')->name('outreach.manually.hiv.art.positivity');
	Route::get('/data-pie-chart-art-indicators', 'ManuallyController@getindicators')->name('outreach.manually.hiv.art.indicators');

	Route::get('/data-pie-chart-client-indicators', 'ManuallyController@getClientindicators')->name('outreach.manually.hiv.art.client.indicators');


	Route::group(['prefix' => 'chatbot', 'controller' => ChatbotController::class], function () {
		Route::name('chatbot.')->group(function () {
			Route::prefix('greetings')->name('greetings.')->group(function () {
				Route::post('add-greetings', 'addGreetings')->name('save');
				Route::get('get-all', 'getAllGreetings')->name('all');
				Route::get('delete-greeting', 'deleteGreetings')->name('delete');
			});
			Route::prefix('content')->name('content.')->group(function () {
				Route::post('update', 'updateContent')->name('update');
				Route::get('get-all', 'getAllContent')->name('all');
				Route::get('get-content', 'getContentByID')->name('content');
			});
			Route::prefix('questionnaire')->name('questionnaire.')->group(function () {
				Route::post('add-questionnaire', 'addQuestionnaire')->name('add');
				Route::post('update-questionnaire', 'updateQuestionnaire')->name('update');
				Route::post('update-answers', 'updateAnswerSheet')->name('update-answers');
				Route::post('delete-question', 'deleteQuestion')->name('delete-question');
				Route::post('destroy-question', 'destroyQuestion')->name('destroy-question');
				Route::get('get-all', 'getAllQuestionnaire')->name('all');
				Route::get('add-answer', 'addMoreAnswers')->name('answer');
				Route::get('add-question', 'addMoreQuestions')->name('question');
			});
			Route::prefix('users')->name('users.')->group(function () {
				Route::get('get-all', 'getAllChatbotUsers')->name('all');
			});
			Route::prefix('language')->name('language.')->group(function () {
				Route::get('counter', 'getLanguageCounter')->name('counter');
			});
			Route::prefix('visitor')->name('visitor.')->group(function () {
				Route::get('get-all', 'getAllVisitors')->name('all');
			});
			Route::get('media-type', 'mediaType')->name('answer');
		});
	});

	Route::group(['prefix' => 'language', 'controller' => LanguageController::class], function () {
		Route::name('language.')->group(function () {
			Route::post('addLanguage', 'addLanguage')->name('save');
			Route::post('deleteLanguage', 'deleteLanguage')->name('delete');
			Route::get('get-all', 'getAllLanguages')->name('all');
			Route::get('getByID', 'getLanguageByID')->name('by-id');
		});
	});

	Route::group(['prefix' => 'admin/self-risk-assessment', 'controller' => RiskAssessmentController::class], function () {
		Route::name('admin.self-risk-assessment.')->group(function () {
			Route::match(['get', 'post'], '/', 'getAllSelfRiskAssessments')->name('index');
			Route::match(['get', 'post'], 'master-line-list', 'getAllSelfRiskAssessments')->name('combine');
			Route::post('delete/{id}', 'deleteSelfRiskAssessments')->name('delete');
			Route::get('question-slug', 'getQuestionSlug')->name('question-slug');
			Route::get('questionnaire', 'getAllQuestionnaire')->name('questionnaire');
			Route::match(['get', 'post'], 'get-appointments', 'getAllAppointments')->name('appointment');
			Route::post('get-centres', 'getCentres')->name('centres');
			Route::get('get-appointment/{id}', 'getAppointmentByID')->name('appointment-by-id');
			Route::get('get-appointment-service', 'getAppointmentListByService');
			Route::get('analytics', 'getAnalytics')->name('analytics');
			Route::post('update-appointment', 'updateAppointment')->name('appointment.update');
		});
	});

	Route::get('/add-blog', [BlogController::class, 'create'])->name('blog_create');
	Route::post('/store-blog', [BlogController::class, 'store'])->name('blog_store');
	Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog_edit');
	Route::put('/blog/edit/{id}', [BlogController::class, 'update'])->name('blog_update');
	Route::get('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('blog_destroy');
	Route::get('/all-blogs', [BlogController::class, 'index'])->name('blogs_all');

	Route::get('/add-blog-categories', [BlogCategoriesController::class, 'create'])->name('blog_categories_create');
	Route::post('/store-blog-categories', [BlogCategoriesController::class, 'store'])->name('blog_categories_store');
	Route::get('/blog-categories/edit/{id}', [BlogCategoriesController::class, 'edit'])->name('blog_categories_edit');
	Route::put('/blog-categories/edit/{id}', [BlogCategoriesController::class, 'update'])->name('blog_categories_update');
	Route::get('/blog-categories/delete/{id}', [BlogCategoriesController::class, 'destroy'])->name('blog_categories_destroy');
	Route::get('/all-blog-categories', [BlogCategoriesController::class, 'index'])->name('blog_categories_all');

	Route::post('/abc', 'UserController@abcd');
});

// GOOGLE ANALYTICS
Route::get("/analytics/{total}", [AnalyticsController::class, 'index']);
