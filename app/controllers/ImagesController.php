<?php

class ImagesController extends \ApiController{

	/**
	 * Show sport image
	 *
	 * @param $sportId
	 * @return mixed
	 */
	public function show($sportId)
	{
		$sport = Sport::find($sportId);

		$path = $this->getSportsImagePath($sport);

		$response = Response::make(file_get_contents($path), '200');

		$response->header('Content-Type', $sport->mime);

		return $response;
	}

	/**
	 * Get sport image
	 *
	 * @param $sport
	 * @return string
	 */
	private function getSportsImagePath($sport)
	{
		$path = ($sport->image == 'default.png') ? 'images/default.png' : "images/{$sport->user_id}/{$sport->image}";

		return storage_path($path);
	}
}