<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);

	switch($code) {
		case 500:
			return Response::json(buildErrorResponse('Internel server error!', $code), 500);

		case 404:
			return Response::json(buildErrorResponse('Not found!', $code), 404);

		case 405:
			return Response::json(buildErrorResponse('Method not allowed!', $code), 404);
	}
});

App::error(function(\Athlete\Filters\ApiKeyMismatchException $exception)
{
	return Response::json(buildErrorResponse($exception->getMessage(), 400), 400);
});

App::error(function(\Athlete\Filters\UnauthorizedUserException $exception)
{
	return Response::json(buildErrorResponse($exception->getMessage(), 401), 401);
});

App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $exception)
{
	return Response::json(buildErrorResponse($exception->getModel(). " not found!", 404), 404);
});

App::error(function(\Laracasts\Validation\FormValidationException $exception)
{
	return Response::json([
		'success' => false,
		'error' => [
			'message' => $exception->getErrors()->first(),
			'status_code' => 422
		],
	], 422);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Require The Helpers File
|--------------------------------------------------------------------------
|
*/

require app_path().'/helpers.php';
