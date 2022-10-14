<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/subtype', 'App\Http\Controllers\NearMissAccidentReporting@findSub')->name('subtype');
Route::post('/tertype', 'App\Http\Controllers\NearMissAccidentReporting@findTer')->name('tertype');

// fetching Near miss data into data table
Route::post('/getneardata', 'App\Http\Controllers\NearMissAccidentReporting@getnearmiss')->name('getnearmissdata');
// fetching incident report data into data table
Route::post('/getincident', 'App\Http\Controllers\IncidentReportingController@getincidents')->name('getincident');
// fetching inspect audit data into data table
Route::post('/getinspect','App\Http\Controllers\AuditController@getaudit')->name('getaudit');
// fetching moc data into data table
Route::post('/getMocData','App\Http\Controllers\ManagementofchangeController@getmoc')->name('getmoc');

// auto save api for inspect audit
Route::post('/auto-save-audit','App\Http\Controllers\AuditController@AutoSaveAPI')->name('store-audit');


Route::post('/deleteFormData','App\Http\Controllers\AuditController@deleteFormData')->name('store-audit');
Route::post('/GetFormDataByID','App\Http\Controllers\AuditController@GetFormDataByID')->name('GetFormDataByID');
Route::post('/ChangeStatus','App\Http\Controllers\AuditController@ChangeStatus')->name('cs');

Route::post('/prefill-audit','App\Http\Controllers\AuditController@Prefill')->name('Prefill');
Route::post('/prefill-audit-edit','App\Http\Controllers\AuditController@EditPrefill')->name('Prefill-edit');

Route::post('/fetch-root_causes','App\Http\Controllers\AuditController@sendRootCauses')->name('fetch_root_causes');
Route::post('/fetch-preventive_actions','App\Http\Controllers\AuditController@sendpreventiveaction')->name('fetch_root_causes');
Route::post('/fetch-corrective_actions','App\Http\Controllers\AuditController@sendcorrectiveaction')->name('fetch_root_causes');
Route::post('/fetch-preventive_actions_evidence','App\Http\Controllers\AuditController@sendpreventiveactionFiles')->name('fetch_root_causes');
Route::post('/fetch-corrective_actions_evidence','App\Http\Controllers\AuditController@sendcorrectiveactionFiles')->name('fetch_root_causes');
Route::post('/fetch-send_evidence_psc','App\Http\Controllers\AuditController@sendEvidencePSC')->name('send_evidence');

// RiskAssesment search
Route::post('/riskAssesmentSearch','App\Http\Controllers\RiskAssesmentController@test');

// incident modal data update
Route::post('/updateModalData','App\Http\Controllers\IncidentReportingController@modalData');
// nearMissAutoSave
Route::post('/nearMissAutoSave','App\Http\Controllers\NearMissAccidentReporting@autosave');
// incidentAutoSave
Route::post('/incidentAutoSave','App\Http\Controllers\IncidentReportingController@autosave');

//type of audit onchange Delete

Route::post('/typeChangeDelete','App\Http\Controllers\AuditController@typeChangeDelete');


// 🔴 Api : to Delete inspection-and-audit sub-forms on onchange of 'Type of Audit'
Route::post('/delete-sub-forms-on-input-change','App\Http\Controllers\AuditController@delete_sub_forms_on_input_change');

