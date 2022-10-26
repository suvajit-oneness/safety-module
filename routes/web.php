<?php

use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::group(['middleware' => ['web', 'checkblocked']], function () {
    Route::get('/', 'App\Http\Controllers\WelcomeController@welcome')->name('welcome');
    Route::get('/terms', 'App\Http\Controllers\TermsController@terms')->name('terms');
});

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => ['web', 'activity', 'checkblocked']], function () {

    Route::redirect('/incident-reporting', 'http://127.0.0.1:8000/login');


    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'App\Http\Controllers\Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'App\Http\Controllers\Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'App\Http\Controllers\Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'App\Http\Controllers\Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'App\Http\Controllers\Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'App\Http\Controllers\Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'App\Http\Controllers\RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'checkblocked']], function () {


    Route::get('/test', 'App\Http\Controllers\GenericController@getCreatorId');

    // myTemplate
    Route::get('/adminTemplateCreate', 'App\Http\Controllers\TemplateController@create')->middleware('permission:create.template');;
    Route::post('/adminTemplateCreate', 'App\Http\Controllers\TemplateController@store');
    
    Route::get('/template', 'App\Http\Controllers\TemplateController@index')->middleware('permission:view.template');
    
    Route::get('/adminEditTemplate/{id}', 'App\Http\Controllers\TemplateController@edit')->middleware('permission:edit.template');
    Route::post('/adminEditTemplate/{id}', 'App\Http\Controllers\TemplateController@update');
    Route::get('/adminDeleteTemplate/{id}', 'App\Http\Controllers\TemplateController@destroy')->middleware('permission:delete.template');
    // template duplication
    Route::get('/templateDuplicate/{id}', 'App\Http\Controllers\TemplateController@getDuplicate')->middleware('permission:create.template');
    Route::post('/templateDuplicate/{id}', 'App\Http\Controllers\TemplateController@putDuplicate');
    // myRiskAssesment
    Route::get('/userRiskAssesment', 'App\Http\Controllers\RiskAssesmentController@index')->middleware('permission:view.riskassessment');
    Route::get('/useMyRiskAssesment/{id}', 'App\Http\Controllers\RiskAssesmentController@create')->middleware('permission:create.riskassessment');
    Route::post('/useMyRiskAssesment/{id}', 'App\Http\Controllers\RiskAssesmentController@store');
    
    Route::get('/riskAssesmentView', 'App\Http\Controllers\RiskAssesmentController@show')->middleware('permission:view.riskassessment');
    
    Route::get('/riskAssesmentEdit/{id}', 'App\Http\Controllers\RiskAssesmentController@edit')->middleware('permission:edit.riskassessment');
    Route::post('/riskAssesmentEdit/{id}', 'App\Http\Controllers\RiskAssesmentController@update');
    
    Route::get('/riskAssesmentDelete/{id}', 'App\Http\Controllers\RiskAssesmentController@destroy')->middleware('permission:delete.riskassessment');
    // Risk Assesment pdf
    Route::get('/riskAssesmentPdf/{id}','App\Http\Controllers\RiskAssesmentController@riskAssesmenrPdf');
    //
    Route::get('/all', function () {
        return redirect('/riskAssesmentView');
    });

    // -------------------------- Incident Reporting ------------------------
    Route::get('/incident-reporting', 'App\Http\Controllers\IncidentReportingController@index')->name('incident_reporting')->middleware('permission:view.incident');
    Route::post('/getFilterData', 'App\Http\Controllers\IncidentReportingController@getfilterdata');
    // Route::get('/incident-reporting-filter','App\Http\Controllers\IncidentReportingController@index')->name('incident_reporting');
    Route::get('/incident-reporting/create', 'App\Http\Controllers\IncidentReportingController@create')->name('incident_create')->middleware('permission:create.incident');
    Route::post('/incident-reporting/store', 'App\Http\Controllers\IncidentReportingController@store');
    
    Route::get('/incident-reporting/edit/{id}', 'App\Http\Controllers\IncidentReportingController@edit')->middleware('permission:edit.incident');
    Route::post('/incident-reporting/update/{id}', 'App\Http\Controllers\IncidentReportingController@update');
    Route::get('/incident-reporting/delete/{id}', 'App\Http\Controllers\IncidentReportingController@destroy')->middleware('permission:delete.incident');
    // PDF print
    Route::get('/incident-pdf/{id}', 'App\Http\Controllers\IncidentReportingController@printPDF_incident')->name('pdf-report_incident');
    Route::get('/incident-pdf-immediate-incident-notification-and-interim-update/{id}', 'App\Http\Controllers\IncidentReportingController@immediate_incident_notification_and_interim_update')->name('immediate_incident_notification_and_interim_update');
    Route::get('/incident-pdf-all/{id}', 'App\Http\Controllers\IncidentReportingController@printPDFAll_incident')->name('pdf-report-all_incident');
    Route::get('/myPdf/{id}','App\Http\Controllers\IncidentReportingController@myPdf');
    Route::get('/myPdfFrom/{id}','App\Http\Controllers\IncidentReportingController@formPdf');

    // -------------------------- Incident Reporting End ------------------------


    // -------------------------------------- Near Miss Accident Reporting which only admin can access ------------------------------------

    // Read
    Route::get('/Near_Miss', 'App\Http\Controllers\NearMissAccidentReporting@index')->name('Near_Miss')->middleware('permission:view.nearmiss');

    // Create
    Route::get('/Near_Miss_create', 'App\Http\Controllers\NearMissAccidentReporting@create')->name('Near_Miss_create')->middleware('permission:create.nearmiss');
    Route::post('/Near_Miss_store', 'App\Http\Controllers\NearMissAccidentReporting@store')->name('Near_Miss_store');

    // edit
    Route::get('/Near_Miss_edit/{id}', 'App\Http\Controllers\NearMissAccidentReporting@edit')->name('Near_Miss_edit')->middleware('permission:edit.nearmiss');
    Route::put('/Near_Miss_edit/{id}', 'App\Http\Controllers\NearMissAccidentReporting@update')->name('Near_Miss_update');


    // delete
    Route::get('/Near_Miss_delete/{id}', 'App\Http\Controllers\NearMissAccidentReporting@destroy')->name('Near_Miss_delete')->middleware('permission:delete.nearmiss');

    // PDF print
    Route::get('/near-pdf/{id}', 'App\Http\Controllers\NearMissAccidentReporting@printPDF_Nearmiss')->name('pdf-report');
    Route::get('/near-pdf-all/{id}', 'App\Http\Controllers\NearMissAccidentReporting@printPDFAll_Nearmiss')->name('pdf-report-all');

    // -------------------------------------- Near Miss Accident Reporting which only admin can access End ------------------------------------


    // Activation Routes
    Route::get('/activation-required', ['uses' => 'App\Http\Controllers\Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'App\Http\Controllers\Auth\LoginController@logout'])->name('logout');

    //Route::get('/risk_assessment','App\Http\Controllers\RiskAssessmentVesselInfoController@show');
    // Route::get('/risk_assessment_delete/{id}', 'App\Http\Controllers\RiskAssessmentVesselInfoController@destroy');
    // Route::get('/risk_assessment_create', 'App\Http\Controllers\RiskAssessmentVesselInfoController@create');
    // Route::post('/risk_assessment_submit', 'App\Http\Controllers\RiskAssessmentVesselInfoController@store');
    // Route::get('/fetchdata', 'App\Http\Controllers\RiskAssessmentVesselInfoController@fetchdata');
    // Route::get('/fetchvesselref', 'App\Http\Controllers\RiskAssessmentVesselInfoController@fetchvesselref');
    // Route::get('/risk_assessment_edit/{id}', 'App\Http\Controllers\RiskAssessmentVesselInfoController@edit');
    // Route::get('/getSignatureImage/{formId}/{signature}', 'App\Http\Controllers\RiskAssessmentVesselInfoController@getSignatureImage');
    
    // -------------------Uncommented by Onenesstechs------------------------
    Route::get('/fetchHazardDataForSection2', 'App\Http\Controllers\RiskAssessmentVesselInfoController@fetchHazardDataForSection2');
    
    // ----------------------Uncommented by Onenesstechs---------------------
    Route::get('/fetchAllDataForSection2', 'App\Http\Controllers\RiskAssessmentVesselInfoController@fetchAllDataForSection2');
    
    // Route::post('/risk_assessment_update/{id}', 'App\Http\Controllers\RiskAssessmentVesselInfoController@update');
    // Route::get('template-use/{id}', 'App\Http\Controllers\RiskAssessmentVesselInfoController@templateUse');

    Route::get('hazard-master', 'App\Http\Controllers\HazardMasterListController@index');
    Route::get('excel', function () {
        return view('hazardMaster.excel');
    });
    Route::post('excel', 'App\Http\Controllers\HazardMasterListController@importExcel');




    // -------------------------- Inspection & Audits ------------------------
    Route::get('/inspection-audit', 'App\Http\Controllers\AuditController@index')->name('inspection_audit')->middleware('permission:view.audit');
    
    Route::get('/inspection-audit/create', 'App\Http\Controllers\AuditController@create')->name('inspection_audit_create')->middleware('permission:create.audit');
    Route::post('/inspection-audit/store', 'App\Http\Controllers\AuditController@store')->name('inspection_audit_store');
    
    Route::get('/inspection-audit/edit/{id}', 'App\Http\Controllers\AuditController@edit')->name('inspection_audit_edit')->middleware('permission:edit.audit');
    Route::get('/inspection-audit/edit', 'App\Http\Controllers\AuditController@edit')->name('inspection_audit_edit')->middleware('permission:edit.audit');
    Route::get('/inspection-audit/delete/{id}', 'App\Http\Controllers\AuditController@destroy')->name('inspection_audit_delete')->middleware('permission:delete.audit');
    Route::get('/inspection-audit/Draft', 'App\Http\Controllers\AuditController@NewDraft')->name('create-draft')->middleware('permission:create.audit');
    // -------------------------- Inspection & Audits End------------------------

});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep', 'checkblocked']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'App\Http\Controllers\UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@show',
    ]);
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep', 'checkblocked']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        \App\Http\Controllers\ProfilesController::class,
        [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'App\Http\Controllers\ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'App\Http\Controllers\ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'App\Http\Controllers\ProfilesController@upload']);
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated','role:admin', 'activity', 'twostep', 'checkblocked']], function () {
    
    Route::resource('/users/deleted', \App\Http\Controllers\SoftDeletesController::class, [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', \App\Http\Controllers\UsersManagementController::class, [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'App\Http\Controllers\UsersManagementController@search')->name('search-users');

    Route::resource('themes', \App\Http\Controllers\ThemesManagementController::class, [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'App\Http\Controllers\AdminDetailsController@listRoutes');
    Route::get('active-users', 'App\Http\Controllers\AdminDetailsController@activeUsers');

    // hazard master routes which only admin can access

    Route::get('hazard-master-create', 'App\Http\Controllers\HazardMasterListController@create');
    Route::post('hazard-master-submit', 'App\Http\Controllers\HazardMasterListController@store');
    Route::get('hazard-master-edit/{id}', 'App\Http\Controllers\HazardMasterListController@edit');
    Route::post('hazard-master-update/{id}', 'App\Http\Controllers\HazardMasterListController@update');
    Route::get('hazard-master-delete/{id}', 'App\Http\Controllers\HazardMasterListController@destroy');
    Route::get('fetchRafData', 'App\Http\Controllers\HazardMasterListController@fetchdata');

    Route::get('template-edit/{id}', 'App\Http\Controllers\RiskAssessmentVesselInfoController@templateEdit');
    Route::get('template-delete/{id}', 'App\Http\Controllers\RiskAssessmentVesselInfoController@templateDelete');

    Route::get('/getNewFormId', 'App\Http\Controllers\RiskAssessmentVesselInfoController@getNewFormId');


    // --------------------------- vessele Details -------------------------------
    Route::get('/vessel_details/destroy/{id}', 'App\Http\Controllers\Vessel_detailsController@destroy');
    Route::get('/vessel_details/edit/{id}', 'App\Http\Controllers\Vessel_detailsController@edit');
    Route::post('/vessel_details/update/{id}', 'App\Http\Controllers\Vessel_detailsController@update');
    // --------------------------- vessele Details end -------------------------------

    // ----------------------------- Crew List -----------------------
    Route::get('/crew_list', 'App\Http\Controllers\Crew_listController@index');
    Route::get('/crew_list/create', 'App\Http\Controllers\Crew_listController@create');
    Route::get('/crew_list/store', 'App\Http\Controllers\Crew_listController@store');
    Route::get('/crew_list/edit/{id}', 'App\Http\Controllers\Crew_listController@edit');
    Route::get('/crew_list/update/{id}', 'App\Http\Controllers\Crew_listController@update');
    Route::get('/crew_list/delete/{id}', 'App\Http\Controllers\Crew_listController@destroy');
    // ----------------------------- Crew List end -----------------------
    // Saving data part by part through ajax call
    //saveStep1:- save Investigation Matrix
    Route::post('/saveInvestigationMatrix', 'App\Http\Controllers\IncidentReportingController@saveInvestigationMatrix')->name('saveInvestigationMatrix');
    Route::post('/saveIncidentHeader', 'App\Http\Controllers\IncidentReportingController@saveIncidentHeader')->name('saveIncidentHeader');
    Route::post('/saveIncidentReportDetails', 'App\Http\Controllers\IncidentReportingController@saveIncidentReportDetails')->name('saveIncidentReportDetails');
    Route::post('/saveIncidentCrewInjury', 'App\Http\Controllers\IncidentReportingController@saveIncidentCrewInjury')->name('saveIncidentCrewInjury');
    Route::post('/saveIncidentBrief', 'App\Http\Controllers\IncidentReportingController@saveIncidentBrief')->name('saveIncidentBrief');
    Route::post('/saveEventInformation', 'App\Http\Controllers\IncidentReportingController@saveEventInformation')->name('saveEventInformation');
    Route::post('/saveEventLog', 'App\Http\Controllers\IncidentReportingController@saveEventLog')->name('saveEventLog');
    Route::post('/saveRootCauseFindings', 'App\Http\Controllers\IncidentReportingController@saveRootCauseFindings')->name('saveRootCauseFindings');








    // ---------------------- Crew Ranks ---------------------
    Route::get('/crew_ranks', 'App\Http\Controllers\Crew_RanksController@index');
    Route::get('/crew_ranks/add', 'App\Http\Controllers\Crew_RanksController@create');
    Route::post('/crew_ranks/store', 'App\Http\Controllers\Crew_RanksController@store');
    // ---------------------- Crew Ranks End ---------------------

    Route::resources([
        'location'          => App\Http\Controllers\LocationController::class,
        'department'        => App\Http\Controllers\DepartmentController::class,
        //'rank'              => App\Http\Controllers\RankController::class,
        'vessel_details'    => App\Http\Controllers\Vessel_detailsController::class,
    ]);
    Route::get('importUser', function () {
        return view('Excel.import');
    });
    Route::post('importUser', 'App\Http\Controllers\UsersManagementController@uploadExcel');
});


// MANAGEMENT_OF_CHANGE

Route::get('/moc', 'App\Http\Controllers\ManagementofchangeController@index')->middleware('permission:view.moc');
Route::get('/moc/create', 'App\Http\Controllers\ManagementofchangeController@create')->middleware('permission:create.moc');
Route::post('/moc/store', 'App\Http\Controllers\ManagementofchangeController@store');

Route::get('/moc/delete/{id}', 'App\Http\Controllers\ManagementofchangeController@destroy')->middleware('permission:delete.moc');

Route::get('/moc/edit/{id}', 'App\Http\Controllers\ManagementofchangeController@edit')->middleware('permission:edit.moc');
Route::post('/moc/edit/{id}', 'App\Http\Controllers\ManagementofchangeController@update');
//    Route::post('/incident-reporting/store','App\Http\Controllers\IncidentReportingController@store');

// COMPANY
Route::get('/company', 'App\Http\Controllers\CompanyController@index');
Route::get('/company/create', 'App\Http\Controllers\CompanyController@create');
Route::post('/company/store', 'App\Http\Controllers\CompanyController@store');
Route::get('/company/delete/{id}', 'App\Http\Controllers\CompanyController@destroy');
Route::get('/company/edit/{id}', 'App\Http\Controllers\CompanyController@edit');
Route::post('/company/update/{id}', 'App\Http\Controllers\CompanyController@update');





Route::redirect('/php', '/phpinfo', 301);
//under construction
Route::view('/constuct', 'Construct');
Route::get('/render/{id}', [UserController::class, 'type']);

// AUTO-SAVE
// step1
Route::get('/auto-save-auditt1', 'App\Http\Controllers\AuditController@saveStapOne');
// step2
Route::post('/auto-save-auditt2', 'App\Http\Controllers\AuditController@saveStapTwo');

// route that download RA_pdf om moc_edit
Route::get('/downloadRaPdf/{id}','App\Http\Controllers\ManagementofchangeController@downloadFile');

Route::get('/downloadRaPdfQstring', 'App\Http\Controllers\FileController@downloadFileByQstring');

Route::get('/getFile','App\Http\Controllers\FileController@getFile'); // Rohan
// Route::get('/getFile/{path}','App\Http\Controllers\FileController@getFile'); // Sougata

Route::get('/getImageBase64/{path}','App\Http\Controllers\FileController@getImageBase64');

//Route::get( '/downloadRaPdf/{path}', 'App\Http\Controllers\FileController@downloadFile');
// Route::get('/downloadRaPdf/{path}','App\Http\Controllers\FileController@downloadFile');
// auto save
Route::get("/queary",function() {
    return View('NearMissAccident.quearyView');
});
Route::get("/generateNewDraft",'App\Http\Controllers\NearMissAccidentReporting@createDraft');
Route::get("/continueWithPreviousDraft",'App\Http\Controllers\NearMissAccidentReporting@collectDraft');

// Incident Reporting
Route::get('/incidentQueary',function(){
    return view('incident_reporting.quearyView');
});
Route::get('/incidentNewDraft','App\Http\Controllers\IncidentReportingController@createNewDraft');
Route::get('/incidentContinueWithPreviousDraft','App\Http\Controllers\IncidentReportingController@collectDraft');
Route::get('/downloadRaPdfIncident/{id}','App\Http\Controllers\IncidentReportingController@downloadFile');