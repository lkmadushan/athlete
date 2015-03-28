<?php

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth.once', 'Athlete\Filters\VerifyAuthentication');
Route::filter('api.key', 'Athlete\Filters\VerifyApiKey');
