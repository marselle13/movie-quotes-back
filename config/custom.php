<?php

return [
	/*
|--------------------------------------------------------------------------
| Authentication Expiration
|--------------------------------------------------------------------------
	*/
	'remember_me_time' => env('REMEMBER_ME_TIME', 360),
	'expiration_time'  => env('EXPIRATION_TIME', 180),

	/*
|--------------------------------------------------------------------------
| Verify Email Expiration
|--------------------------------------------------------------------------
	*/
	'verify_email_time' => env('VERIFY_EMAIL_TIME', 2),

	/*
|--------------------------------------------------------------------------
| Front App Url
|--------------------------------------------------------------------------
	*/
	'front_app' => env('FRONT_APP', 'http://localhost:5173'),
];
