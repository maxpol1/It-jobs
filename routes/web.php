<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmployerRegisterController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [JobController::class, 'index']);
Route::get('/jobs/create', [JobController::class, 'create'])->name('job.create');
Route::post('/jobs/create', [JobController::class, 'store'])->name('job.store');
Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('job.edit');
Route::post('/jobs/{id}/edit', [JobController::class, 'update'])->name('job.update');
Route::get('/jobs/my-job', [JobController::class, 'myjob'])->name('my.job');

Route::get('/jobs/applications', [JobController::class, 'applicant'])->name('applicant');
Route::get('/jobs/alljobs', [JobController::class, 'allJobs'])->name('alljobs');

Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/jobs/{id}/{job}', [JobController::class, 'show'])->name('jobs.show');
//company
Route::get('/company/{id}/{company}', [CompanyController::class, 'index'])->name('company.index');
Route::get('company/create', [CompanyController::class, 'create'])->name('company.view');
Route::post('company/create', [CompanyController::class, 'store'])->name('company.store');


Route::post('company/coverphoto', [CompanyController::class, 'coverPhoto'])->name('cover.photo');

Route::post('company/logo', [CompanyController::class, 'companyLogo'])->name('company.logo');


//user profile
Route::get('user/profile', [UserController::class, 'index'])->name('user.profile');
Route::post('user/profile/create', [UserController::class, 'store'])->name('profile.create');

Route::post('user/coverletter', [UserController::class, 'coverletter'])->name('cover.letter');

Route::post('user/resume', [UserController::class, 'resume'])->name('resume');
Route::post('user/avatar', [UserController::class, 'avatar'])->name('avatar');


//employer view
Route::view('employer/register', 'auth.employer-register')->name('employer.register');

Route::post('employer/register', [EmployerRegisterController::class, 'employerRegister'])->name('emp.register');

Route::post('/applications/{id}', [JobController::class, 'apply'])->name('apply');


//save and unsave job
Route::post('/save/{id}', [FavouriteController::class, 'saveJob']);

Route::post('/unsave/{id}', [FavouriteController::class, ']unSaveJob']);

//category
Route::get('/category/{id}/jobs', [CategoryController::class, 'index'])->name('category.index');

//company
Route::get('/companies', [CompanyController::class, 'company'])->name('company');


//admin
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('admin');
Route::get('/dashboard/create', [DashboardController::class, 'create'])->middleware('admin');
Route::post('/dashboard/create', [DashboardController::class, 'store'])->name('post.store')->middleware('admin');
Route::post('/dashboard/destroy', [DashboardController::class, 'destroy'])->name('post.delete')->middleware('admin');

Route::get('/dashboard/{id}/edit', [DashboardController::class, 'edit'])->name('post.edit')->middleware('admin');
Route::post('/dashboard/{id}/update', [DashboardController::class, 'update'])->name('post.update')->middleware('admin');

Route::get('/dashboard/trash', [DashboardController::class, 'trash'])->middleware('admin');

Route::get('/dashboard/{id}/trash', [DashboardController::class, 'restore'])->name('post.restore')->middleware('admin');

Route::get('/dashboard/{id}/toggle', [DashboardController::class, 'toggle'])->name('post.toggle')->middleware('admin');
Route::get('/posts/{id}/{slug}', [DashboardController::class, 'show'])->name('post.show');

Route::get('/dashboard/jobs', [DashboardController::class, 'getAllJobs'])->middleware('admin');
Route::get('/dashboard/{id}/jobs', [DashboardController::class, 'changeJobStatus'])->name('job.status')->middleware('admin');


//testimonial
Route::get('testimonial', [TestimonialController::class, 'index'])->middleware('admin');

Route::get('testimonial/create', [TestimonialController::class, 'create'])->middleware('admin');
Route::post('testimonial/create', [TestimonialController::class, 'store'])->name('testimonial.store')->middleware('admin');

//email
Route::post('/job/mail', [EmailController::class, 'send'])->name('mail');



