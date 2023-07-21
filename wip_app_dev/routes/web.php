<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Http\Controllers\BookController;
use App\Http\Controllers\WipChatSystemController;
use App\Http\Controllers\WipDomainController;
use App\Http\Controllers\WipGroupController;
use App\Http\Controllers\WipPermGroupController;
use App\Http\Controllers\WipScoreController;
use App\Http\Controllers\WipUserController;
use App\Http\Controllers\WipUserGroupController;
use App\Http\Controllers\WipUserProfileController;
use App\Http\Controllers\WipSupervisorGroupController;
use App\Models\WipChatSystem;
use App\Models\WipDomain;
use App\Models\WipPermGroup;
use App\Models\WipUserProfile;
use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth'], function() {
});


// Yamazaki-san's Video to make Book Shop
Route::get('/book', [BookController::class, 'index'])->name('book_index');
Route::post('/books', [BookController::class, 'store'])->name('book_store');
Route::post('/booksedit/{book}', [BookController::class, 'edit'])->name('book_edit');
Route::get('/booksedit/{book}', [BookController::class, 'edit'])->name('edit');
Route::post('/books/update', [BookController::class, 'update'])->name('book_update');
Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('book_destory');

// WIP DOMAIN (Company):: Routings
Route::get('/domains', [WipDomainController::class, 'index'])->name('domain_index');
Route::post('/domain', [WipDomainController::class, 'store'])->name('domain_store');
Route::post('/domainedit/{domain_id}', [WipDomainController::class, 'edit'])->name('domain_edit');
Route::get('/domainedit/{domain_id}', [WipDomainController::class, 'edit'])->name('edit');
Route::post('/domain/update', [WipDomainController::class, 'update'])->name('domain_update');
Route::delete('/domain/{domain_id}', [WipDomainController::class, 'destroy'])->name('domain_destroy');

// WIP GROUP :: Routings
Route::get('/groups', [WipGroupController::class, 'index'])->name('group_index');
Route::post('/group', [WipGroupController::class, 'store'])->name('group_store');
Route::post('/groupedit/{group_id}', [WipGroupController::class, 'edit'])->name('group_edit');
Route::get('/groupedit/{group_id}', [WipGroupController::class, 'edit'])->name('edit');
Route::post('/group/update', [WipGroupController::class, 'update'])->name('group_update');
route::delete('/group/{group_id}', [WipGroupController::class, 'destroy'])->name('group_destroy');

// WIP USERS :: Routings
Route::get('/users', [WipUserController::class, 'index'])->name('user_index');
Route::post('/user', [WipUserController::class, 'store'])->name('user_store');
Route::post('/useredit/{user_id}', [WipUserController::class, 'edit'])->name('user_edit');
Route::get('/useredit/{user_id}', [WipUserController::class, 'edit'])->name('edit');
Route::post('/user/update', [WipUserController::class, 'update'])->name('user_update');
Route::delete('/user/{user_id}', [WipUserController::class, 'destroy'])->name('user_destroy');

// WIP_USER_PROFILE :: Routings
Route::get('/user_profiles', [WipUserProfileController::class, 'index'])->name('user_profile_index');
Route::post('/user_profile', [WipUserProfileController::class, 'store'])->name('user_profile_store');
Route::post('/user_profileedit/{user_profile_id}', [WipUserProfileController::class, 'edit'])->name('user_profile_edit');
Route::get('/user_profileedit/{user_profile_id}', [WipUserProfileController::class, 'edit'])->name('edit');
Route::post('/user_profile/update', [WipUserProfileController::class, 'update'])->name('user_profile_update');
Route::delete('/user_profile/{user_profile_id}', [WipUserProfileController::class, 'destroy'])->name('user_profile_destroy');

// WIP_CHAT_SYSTEM::Routings
Route::get('/chat_systems', [WipChatSystemController::class, 'index'])->name('chat_system_index');
Route::post('/chat_system', [WipChatSystemController::class, 'store'])->name('chat_system_store');
Route::post('/chat_systemedit/{chat_sys}', [WipChatSystemController::class, 'edit'])->name('chat_sytem_edit');
Route::get('/chat_systemedit/{chat_sys}', [WipChatSystemController::class, 'edit'])->name('edit');
Route::post('/chat_system/update', [WipChatSystemController::class, 'update'])->name('chat_system_update');
Route::delete('/chat_system/{chat_sys}', [WipChatSystemController::class, 'destroy'])->name('chat_system_destroy');

// WIP_PERMISSION_GROUP::Routing
Route::get('/perm_groups', [WipPermGroupController::class, 'index'])->name('perm_group_index');
Route::post('/perm_group', [WipPermGroupController::class, 'store'])->name('perm_group_store');
Route::post('/perm_groupedit/{perm_group_id}', [WipPermGroupController::class, 'edit'])->name('perm_group_edit');
Route::get('/perm_groupedit/{perm_gorup_id}', [WipPermGroupController::class, 'edit'])->name('edit');
Route::post('/perm_group/update', [WipPermGroupController::class, 'update'])->name('perm_group_update');
Route::delete('/perm_group/{perm_group_id}', [WipPermGroupController::class, 'destroy'])->name('perm_group_destroy');

// WIP_USER_GROUP::Routing
Route::get('/user_groups', [WipUserGroupController::class, 'index'])->name('user_group_index');
Route::post('/user_group', [WipUserGroupController::class, 'store'])->name('user_group_store');
Route::post('/user_groupedit/{user_group_id}', [WipUserGroupController::class, 'edit'])->name('user_group_edit');
Route::get('/user_groupedit/{user_group_id', [WipUserGroupController::class, 'edit'])->name('edit');
Route::post('/user_group/update', [WipUserGroupController::class, 'update'])->name('user_group_update');
Route::delete('/user_group/{user_group_id}', [WipUserGroupController::class, 'destroy'])->name('user_group_destroy');


// WIP_SUPERVISOR_GROUP::Routing
Route::get('/supervisor_groups', [WipSupervisorGroupController::class, 'index'])->name('supervisor_group_index');
Route::post('/supervisor_group', [WipSupervisorGroupController::class, 'store'])->name('supervisor_group_store');
Route::post('/supervisor_groupedit/{supervisor_group_id}', [WipSupervisorGroupController::class, 'edit'])->name('supervisor_group_edit');
Route::get('/supervisor_groupedit/{supervisor_group_id', [WipSupervisorGroupController::class, 'edit'])->name('edit');
Route::post('/supervisor_group/update', [WipSupervisorGroupController::class, 'update'])->name('supervisor_group_update');
Route::delete('/supervisor_group/{supervisor_group_id}', [WipSupervisorGroupController::class, 'destroy'])->name('supervisor_group_destroy');

// WIP_SCORE::Routing
Route::get('/scores', [WipScoreController::class, 'index'])->name('score_index');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard_noperm', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
