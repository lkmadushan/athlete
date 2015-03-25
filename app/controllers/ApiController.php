<?php

class ApiController extends Controller {

	protected $statusCode;

	/**
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @param mixed $statusCode
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
	}

	public function respondNotFound($message = 'Not Found!')
	{

	}
}