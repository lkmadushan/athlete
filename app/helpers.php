<?php

function buildErrorResponse($message, $code)
{
	return [
		'success' => false,
		'error' => [
			'status_code' => $code,
			'message' => $message
		]
	];
}