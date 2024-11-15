<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\SocialIconController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SubscriptionController;
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

Route::get('/', function () {
    return redirect('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
});

Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::view('/admin', 'dashboard');
    Route::get('/users', [ProfileController::class, 'userList'])->name('admin.userList');
    Route::post('/users/allow', [ProfileController::class, 'allowUser'])->name('admin.allowUser');
});
require __DIR__.'/auth.php';

Route::prefix('user')->middleware('auth')->group(function () {
    //profilelinks
    Route::get('/profilelists', [ProfileController::class, 'profileList'])->name('profilelists');
    Route::post('/profile/store', [ProfileController::class, 'storeProfile'])->name('store.profile');
    Route::get('/profile/change', [ProfileController::class, 'changeProfile'])->name('change.profile');
    // QR-Code
    Route::post('/generate-qrcode', [ProfileController::class, 'generateQrCode'])->name('qrcode.generate');
    
    //Appearance
    Route::get('/appearance/{id}', [ThemeController::class, 'addEditAppearance'])->name('themes.appearance');
    Route::post('/appearance', [ThemeController::class, 'updateAppearance'])->name('themes.updateAppearance');
    Route::post('/appearance/remove-profile-image', [ThemeController::class, 'removeProfileImage'])->name('user.remove.profile.image');
    Route::post('/set-theme', [ThemeController::class, 'setTheme'])->name('setTheme');
    Route::post('/set-custom-theme', [ThemeController::class, 'setCustomTheme'])->name('customTheme');
    
    // add list
    Route::get('/listing/{id}', [ListingController::class, 'show'])->name('edit.listing');
    Route::post('/links/create', [ListingController::class, 'create'])->name('createListing');
    Route::post('/links/update', [ListingController::class, 'update'])->name('updateListing');
    Route::post('/links/delete', [ListingController::class, 'delete'])->name('deleteListing');
    Route::post('/links/visiblity', [ListingController::class, 'linksVisibility'])->name('links.visibility');
    Route::post('/links/upload-thumbnail', [ListingController::class, 'uploadThumbnail'])->name('links.uploadThumbnail');
    Route::post('/links/remove-thumbnail', [ListingController::class, 'removeThumbnail'])->name('links.removeThumbnail');
    
    //Settings
    //Social Icon
    Route::get('/settings/{id}', [SocialIconController::class, 'index'])->name('settings.index');
    Route::any('/social/create', [SocialIconController::class, 'store'])->name('social.store');
    Route::post('/social/edit', [SocialIconController::class, 'update'])->name('social.update');
    Route::delete('/social/delete', [SocialIconController::class, 'delete'])->name('social.delete');
    //QR Logo Upload/Remove
    Route::post('/upload-qr-icon', [SocialIconController::class, 'uploadQrIcon'])->name('qrIcon.upload');
    Route::post('/delete-qr-icon', [SocialIconController::class, 'deleteQrIcon'])->name('qrIcon.delete');
    
    // Stripe
    Route::get('/plans', [SubscriptionController::class, 'plans'])->name('plans');
    Route::get('/pay', [SubscriptionController::class, 'payment'])->name('pay');
    Route::get('/pay-pro', [SubscriptionController::class, 'proPayment'])->name('proPayment');
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::view('/subscribe', 'confirmPayment');
});
Route::fallback(function () {
    return view('themes.notFound');
});
Route::get('/{urlSlug?}', [ThemeController::class, 'index'])->name('index');
Route::get('/analytics/data', [AnalyticsController::class, 'analyticsData'])->name('analytics');


