<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\HomeAboutController;
use App\Http\Controllers\TestimonialController;

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});

Route::match(['get', 'post'], '/', [AdminController::class, 'Login']);

Route::prefix('admin')->group( function() {
    Route::middleware('admin')->group( function(){
        Route::get('dashboard', [AdminController::class, 'dashboard']);
        Route::match(['get', 'post'], '/slider', [SliderController::class, 'UploadSliderImage']);
        Route::delete('/slider/{id}', [SliderController::class, 'DeleteSliderImage'])->name('slider.delete');
        Route::match(['get', 'post'], '/home-about/{id?}', [HomeAboutController::class, 'AboutIndex']);
        Route::match(['get', 'post'], '/testimonial/{id?}', [TestimonialController::class, 'Testimonial']);                                                                                                                                                   
        Route::get('logout', [AdminController::class, 'Logout']);
    });
});
