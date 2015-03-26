<?php

class ApiController extends Controller {

	protected $statusCode = 200;

	/**
	 * Get status code
	 *
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * Set status code
	 *
	 * @param mixed $statusCode
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/**
	 * Not found response
	 *
	 * @param string $message
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function respondNotFound($message = 'Not found!')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	/**
	 * Internel error response
	 *
	 * @param string $message
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function respondInternelError($message = 'Internel error!')
	{
		return $this->setStatusCode(500)->respondWithError($message);
	}

	/**
	 * Create json response
	 *
	 * @param $data
	 * @param array $headers
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(), $headers);
	}

	/**
	 * Create error response
	 *
	 * @param $message
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function respondWithError($message)
	{
		return $this->respond([
			'success' => false,
			'error' => [
				'message' => $message,
				'status_code' => $this->getStatusCode()
			],
		]);
	}

	public function respondWithSuccess($data)
	{
		return $this->respond([
			'success' => true,
			'data' => $data,
		]);
	}
}