<?php

function buildErrorResponse($message, $code)
{
	return [
		'success' => false,
		'error' => [
			'message' => $message,
			'status_code' => $code,
		]
	];
}