<?php

use App\Http\Controllers\AdvertismentController;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ProcedureController;

// use App\Http\Controllers\LoginController;
// use App\Http\Controllers\LogoutController;
// use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\HospitalScheduleController;
use App\Http\Controllers\DiagnosticScheduleController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Return all providers 
Route::get('/all', [ProvidersController::class, 'index']);

// Search Routes

Route::get('/search-by-medication/{name}', [SearchController::class, 'searchByMedication']);
Route::get('/search-by-medications/{name}', [SearchController::class, 'searchByMedications']);
Route::get('/search-by-Pharmacy/{name}', [SearchController::class, 'searchByPharmacy']);
Route::get('/search-by-procedure/{name}', [SearchController::class, 'searchByProcedures']);
Route::get('/search-by-Diagnostics/{name}', [SearchController::class, 'searchByDiagnostics']);
Route::get('/search-by-Diagnostics-tg/{name}', [SearchController::class, 'searchByDiagnosticsTG']);
Route::get('/search-by-Hospital/{name}', [SearchController::class, 'searchByHospital']);
Route::get('/search-by-Doctors/{name}', [SearchController::class, 'searchByDoctor']);

// Advertisment
Route::get('/advertisments', [AdvertismentController::class, 'getAll']);
Route::get('/listing/advertisments', [AdvertismentController::class, 'getAllListings']);
Route::get('/homepage/advertisments', [AdvertismentController::class, 'getAllHomepage']);
Route::post('/advertisment', [AdvertismentController::class, 'save']);
Route::post('/advertisment/{id}', [AdvertismentController::class, 'update']);
Route::get('/advertisment/{id}', [AdvertismentController::class, 'show']);
Route::delete('/advertisment/{id}', [AdvertismentController::class, 'destroy']);


//Diagnostics ROutes

Route::get('/diagnostics', [DiagnosticController::class, 'index']);
Route::get('/Diagnostics/{id}', [DiagnosticController::class, 'show']);
Route::get('Procedure_schedule/{procedure_id}', [DiagnosticScheduleController::class, 'procedure_schedule']);
Route::get('Diagnostic_schedule/{diagnostic_id}', [DiagnosticScheduleController::class, 'index']);
Route::get('User/Diagnostic_schedule/{diagnostic_id}', [DiagnosticScheduleController::class, 'user_schedule']);
Route::get('Procedure_schedule/{diagnostic_id}/{procedure_id}', [DiagnosticScheduleController::class, 'pivot']);


//Hospital Routes

Route::get('/hospitals', [HospitalController::class, 'index']);
Route::get('/Hospitals/{id}/{query}', [HospitalController::class, 'show']);
Route::get('/Hospitals/{id}', [HospitalController::class, 'showHospital']);
Route::get('schedule/{hospital_id}', [HospitalScheduleController::class, 'index']);
Route::get('/user/schedule/{hospital_id}', [HospitalScheduleController::class, 'user_schedule']);
Route::get('scheduleDoctor/{doctor_id}', [HospitalScheduleController::class, 'doctors']);
Route::get('scheduleDoctorAdmin/{doctor_id}', [HospitalScheduleController::class, 'admin_doctors']);
Route::get('HospitalDoctorPivot/{hospital_id}/{doctor_id}', [HospitalController::class, 'pivot']);

// Pharmacy Routes

Route::get('/Pharmacy', [PharmacyController::class, 'index']);
Route::get('/Pharmacy/{id}', [PharmacyController::class, 'show']);


//Doctors Routes

Route::get('/doctors', [DoctorsController::class, 'index']);
Route::get('/Doctors/{id}', [DoctorsController::class, 'show']);
Route::get('/Doctors-name', [DoctorsController::class, 'name']);
Route::get('/Doctors-speciality', [DoctorsController::class, 'speciality']);
Route::get('/Doctors-expertise', [DoctorsController::class, 'expertise']);

//Medication Routes

Route::get('Medications', [MedicationController::class, 'index']);
Route::get('Medications/{id}', [MedicationController::class, 'show']);
Route::get('medAgent', [MedicationController::class, 'medWithAgent']);


//Procedure Routes

Route::get('Procedures', [ProcedureController::class, 'index']);
Route::get('Procedure/{id}', [ProcedureController::class, 'show']);

// User Routes

Route::get('allUsers', [AuthController::class, 'getAllUsers']);
Route::get('showUser/{id}', [AuthController::class, 'showUser']);

// Contact us

Route::post('contactUs', [ContactUsController::class, 'store']);
Route::get('contactUs', [ContactUsController::class, 'index']);

// Counter
Route::get('Count', [CounterController::class, 'index']);
Route::get('CountProviders', [CounterController::class, 'providers']);

// Partners
Route::get('partner', [PartnerController::class, 'index']);
Route::get('partner/{id}', [PartnerController::class, 'show']);

// Testimonials
Route::get('testimonial', [TestimonialController::class, 'index']);
Route::get('testimonial/{id}', [TestimonialController::class, 'show']);

// Route::post('/register',[AuthController::class,'register']);
// Route::post('/login',[AuthController::class,'login']);
// Route::post('/logout',[AuthController::class,'logout']);


Route::middleware(['auth:sanctum'])->group(function () {

    // Agent and admin requests to differentiate which user has previlage to see the provider data
    Route::get('/agent/hospitals/{id}', [HospitalController::class, 'agentHospitals']);
    Route::get('/agent/diagnostics/{id}', [DiagnosticController::class, 'agentDiagnostics']);
    Route::get('/agent/pharmacies/{id}', [PharmacyController::class, 'agentPharmacies']);
    Route::get('/agent/doctors/{id}', [DoctorsController::class, 'agentDoctors']);
    Route::get('/agent/medications/{id}', [MedicationController::class, 'agentMedications']);
    Route::get('/agent/procedures/{id}', [ProcedureController::class, 'agentProcedures']);


    // Diagnostics Routes

    Route::post('/diagnostics', [DiagnosticController::class, 'store']);
    Route::post('/Diagnostics/{id}', [DiagnosticController::class, 'update']);
    Route::delete('/Diagnostics/{id}', [DiagnosticController::class, 'destroy']);
    Route::post('Diagnostic_schedule', [DiagnosticScheduleController::class, 'store']);
    Route::delete('Procedure_schedule/{diagnostic_id}/{procedure_id}', [DiagnosticScheduleController::class, 'destroy']);
    Route::put('Procedure_schedule/{diagnostic_id}', [DiagnosticScheduleController::class, 'update']);

    // Hospital Routes

    Route::post('/hospitals', [HospitalController::class, 'store']);
    Route::delete('/Hospitals/{id}', [HospitalController::class, 'destroy']);
    Route::post('/Hospitals/{id}', [HospitalController::class, 'update']);
    Route::post('Hospital_schedule', [HospitalScheduleController::class, 'store']);
    Route::put('Hospital_schedule/{id}', [HospitalScheduleController::class, 'update']);
    Route::delete('scheduleDoctor/{hospital_id}/{doctor_id}', [HospitalScheduleController::class, 'destroy']);

    // Pharmacy Routes

    Route::post('/Pharmacy', [PharmacyController::class, 'store']);
    Route::post('/Pharmacy/{id}', [PharmacyController::class, 'update']);
    Route::delete('/Pharmacy/{id}', [PharmacyController::class, 'destroy']);

    // Doctors Routes

    Route::delete('/Doctors/{id}', [DoctorsController::class, 'destroy']);
    Route::post('/Doctors/{id}', [DoctorsController::class, 'update']);
    Route::post('Doctor', [DoctorsController::class, 'store']);

    // Medication Routes

    Route::post('Medications', [MedicationController::class, 'store']);
    Route::delete('Medications/{id}', [MedicationController::class, 'destroy']);
    Route::put('Medications/{id}', [MedicationController::class, 'update']);
    Route::delete('Medications/{pharmacy}/{medication}', [PharmacyController::class, 'removeMedication']);
    Route::post('addMedications', [PharmacyController::class, 'addMedication']);
    Route::post('createAndAdd/{pharmacy}', [MedicationController::class, 'createAndAdd']);

    // Procedure Routes

    Route::post('Procedure', [ProcedureController::class, 'store']);
    Route::put('Procedure/{id}', [ProcedureController::class, 'update']);
    Route::delete('Procedures/{id}', [ProcedureController::class, 'destroy']);

    // User Routes

    Route::post('adminRegister', [AuthController::class, 'adminRegister']);
    Route::post('editAdmin/{id}', [AuthController::class, 'adminEdit']);
    Route::delete('deleteUser/{id}', [AuthController::class, 'deleteUser']);

    // Partners Routes

    Route::post('partner', [PartnerController::class, 'store']);
    Route::post('partner/{id}', [PartnerController::class, 'update']);
    Route::delete('partner/{id}', [PartnerController::class, 'delete']);

    // Testimonials Routes

    Route::post('testimonial', [TestimonialController::class, 'store']);
    Route::post('testimonial/{id}', [TestimonialController::class, 'update']);
    Route::delete('testimonial/{id}', [TestimonialController::class, 'delete']);
});
