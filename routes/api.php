<?php

use App\Http\Controllers\v1\SocialLoginController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/social_login',[SocialLoginController::class,'login']);
