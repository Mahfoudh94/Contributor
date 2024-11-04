<?php

use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/social_login',[SocialLoginController::class,'login']);
