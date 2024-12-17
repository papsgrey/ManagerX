<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\UMServerController;
use App\Http\Controllers\UMClientController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\DhcpController;
use App\Http\Controllers\HSClientController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\PolicyEditController;
use Illuminate\Support\Facades\Route;




// Route to Display the signin form 
Route::get('/', [HomeController::class, 'index_signin'])->name('signin');

// Route to handle signin form 
Route::post('/', [HomeController::class, 'signin'])->name('signin.submit');

// Route to the admin dashboard (after successful login)
Route::get('admin/dashboard', function () { return view('admin.dashboard_admin');
})->middleware('auth')->name('admin.dashboard');

// Route to Display Reset Password Form
Route::get('pass_reset', [HomeController::class, 'auth_pass_reset'])->name('pass_reset');

// Route to Display the signup form 
Route::get('signup', [RegisterController::class, 'auth_signup'])->name('signup');
// Route to handle the signup form submission
Route::post('signup', [RegisterController::class, 'signup'])->name('signup.submit');

//Route to handle signout
Route::post('signout', [MiscController::class, 'signout'])->name('signout');
//Route to display signout success 
Route::get('signout_success', [MiscController::class, 'signout_success'])->name('signout_success');

//Route to handle admin_setting
Route::post('admin_setting', [MiscController::class, 'admin_setting'])->name('admin_setting');

//Route to display admin_profile
Route::post('admin_profile', [MiscController::class, 'admin_profile'])->name('admin_profile');

Route::prefix('um-servers')->group(function () {
    Route::get('/', [UMServerController::class, 'show_list_umservers'])->name('show_list_umservers');
    Route::get('/create', [UMServerController::class, 'create_umserver'])->name('create_umservers');
    Route::post('/', [UMServerController::class, 'store_umservers'])->name('store_umservers');
    Route::get('/{id}/edit', [UMServerController::class, 'edit_umservers'])->name('edit_umservers');
    Route::put('/{id}', [UMServerController::class, 'update_umservers'])->name('update_umservers');
    Route::delete('/{id}', [UMServerController::class, 'destroy_umservers'])->name('destroy_umservers');
});

// Routes For UMCLIENTS
Route::prefix('um-clients')->group(function () {
    Route::get('/', [UMClientController::class, 'show_list_umclient'])->name('show_list_umclients'); 
    Route::get('/create', [UMClientController::class, 'create_umclients'])->name('create_umclients'); 
    Route::post('/', [UMClientController::class, 'store_umclient'])->name('store_umclients'); 
    Route::get('/{id}/edit', [UMClientController::class, 'edit_umclient'])->name('edit_umclients'); 
    Route::put('/{id}', [UMClientController::class, 'update_umclient'])->name('update_umclients'); 
    Route::delete('/{id}', [UMClientController::class, 'destroy_umclient'])->name('destroy_umclients'); 
    Route::post('/send-configuration', [UMClientController::class, 'umclients_sendConfiguration'])->name('umclients_sendConfigurations');
});



//Route for displaying Logs
Route::get('/logs', [LogController::class, 'showLogs'])->name('logs');

//Route for DhcpServer
Route::get('/dhcp-list', [DhcpController::class, 'showDhcpList'])->name('dhcp_list');
Route::get('/dhcp-lease/{client_id}', [DhcpController::class, 'showDhcpLease'])->name('dhcp_lease');
Route::get('/dhcp/add-server', [DhcpController::class, 'showAddDhcpServer'])->name('dhcp_addserver');
Route::post('/dhcp/store-server', [DhcpController::class, 'storeDhcpServer'])->name('store_dhcp_server');

//Route for HSClients
Route::get('/hs_clients', [HSClientController::class, 'showHSClients'])->name('hs_client');
Route::get('/hs_clients/add', [HSClientController::class, 'addHSClient'])->name('add_hs_client');
Route::post('/hs_clients/store', [HSClientController::class, 'storeHSClient'])->name('store_hs_client');
Route::post('/hs_clients/send-configuration', [HSClientController::class, 'sendConfiguration'])->name('send_hs_configuration');
Route::get('/hs_clients/{id}/edit', [HSClientController::class, 'editHSClient'])->name('edit_hs_client');
Route::put('/hs_clients/{id}', [HSClientController::class, 'updateHSClient'])->name('update_hs_client');
Route::delete('/hs_clients/{id}', [HSClientController::class, 'deleteHSClient'])->name('delete_hs_client');
Route::get('/hs-dhcp-list', [HSClientController::class, 'showHSDHCPList'])->name('hs_dhcp_list');
Route::post('/hs-dhcp/store-server', [HSClientController::class, 'storeHSDhcpServer'])->name('store_hs_dhcp_server');
Route::get('/hs-dhcp/add-server', [HSClientController::class, 'showAddHSDhcpServer'])->name('hs_dhcp_addserver');
Route::get('/hs-client/{id}/dhcp-lease', [HSClientController::class, 'showHSDhcpLease'])->name('hs_dhcp_lease');


//Route for Set Bundle Policy
Route::get('/set-bundle', [PolicyController::class, 'showSetBundle'])->name('set.bundle');

//Route for Fetching Profiles
Route::post('/fetch-profiles', [PolicyController::class, 'fetchProfiles'])->name('fetch.profiles');
Route::post('/fetch-limits', [PolicyController::class, 'fetchLimits'])->name('fetch_limits');
Route::post('/fetch-profile-limits', [PolicyController::class, 'fetchProfileLimits'])->name('fetch_profile_limits');
Route::get('/api/fetch-limitations/{serverId}', [PolicyController::class, 'fetchLimitations']);
Route::get('/api/fetch-profiles/{serverId}', [PolicyController::class, 'fetchUMProfiles']);

//Route For creating Limits
Route::get('/policy/create-limits', [PolicyController::class, 'createLimits'])->name('create_limits');
Route::get('/policy/create-profile', [PolicyController::class, 'createProfile'])->name('create_profile');
Route::get('/policy/create-profile-limitation', [PolicyController::class, 'createProfileLimitation'])->name('create_profile_limitation');
Route::post('/policy/store-limit', [PolicyController::class, 'storeLimit'])->name('store_limit');
Route::post('/policy/store-profile', [PolicyController::class, 'storeProfile'])->name('store_profile');
Route::post('/policy/store-profile-limitation', [PolicyController::class, 'storeProfileLimitation'])->name('store_profile_limitation');

//Route For Editing and Deleting Limits
// Routes for Profiles
Route::get('/profiles/edit/{id}', [PolicyEditController::class, 'editProfile'])->name('profiles.edit');
Route::put('/profiles/update/{id}', [PolicyEditController::class, 'updateProfile'])->name('profiles.update');
Route::delete('/profiles/delete/{id}', [PolicyEditController::class, 'deleteProfile'])->name('profiles.delete');

// Routes for Limits
Route::get('/limits/edit/{id}', [PolicyEditController::class, 'editLimits'])->name('limits.edit');
Route::put('/limits/update/{id}', [PolicyEditController::class, 'updateLimits'])->name('limits.update');
Route::delete('/limits/delete/{id}', [PolicyEditController::class, 'deleteLimits'])->name('limits.delete');

// Routes for Profile Limits
Route::get('/profilelimits/edit/{id}', [PolicyEditController::class, 'editProfileLimits'])->name('profilelimits.edit');
Route::put('/profilelimits/update/{id}', [PolicyEditController::class, 'updateProfileLimits'])->name('profilelimits.update');
Route::delete('/profilelimits/delete/{id}', [PolicyEditController::class, 'deleteProfileLimits'])->name('profilelimits.delete');


















//Route::get('/test-mikrotik-connection', [\App\Http\Controllers\UMServerController::class, 'testMikroTikConnection']);
//Route::get('/ping-test', function () {   dd(exec("ping -n 2 8.8.8.8", $output, $status)); });




require __DIR__.'/auth.php';