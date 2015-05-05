<?php

use Athlete\Requests\VideoRequest;
use Sorskod\Larasponse\Larasponse;
use Athlete\Transformers\VideoTransformer;
use Athlete\Repositories\Video\VideoRepository;

class VideosController extends ApiController {

	/**
	 * @var \Sorskod\Larasponse\Larasponse $fractal
	 */
	private $fractal;

	/**
	 * @var \Athlete\Repositories\Video\VideoRepository $repository
	 */
	private $repository;

	/**
	 * @var \Athlete\Requests\VideoRequest $videoRequest
	 */
	private $videoRequest;

	/**
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 * @param VideoRepository $repository
	 * @param \Athlete\Requests\VideoRequest $videoRequest
	 */
	public function __construct(Larasponse $fractal,
	                            VideoRepository $repository,
	                            VideoRequest $videoRequest
	)
	{
		$this->fractal = $fractal;
		$this->fractal->parseIncludes($this->getIncludes());

		$this->repository = $repository;
		$this->videoRequest = $videoRequest;
	}

	/**
	 * Display a listing of the resource.
	 * GET /videos
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @return \Response
	 */
	public function index($sportId, $teamId, $playerId)
	{
		$limit = Request::get('limit') ?: 20;

		$offset = Request::get('offset') ?: 0;

		$player = Auth::user()->sports()->findOrfail($sportId)
			->teams()->findOrFail($teamId)
			->players()->findOrFail($playerId);

		$videos = $this->repository->filterByPlayer($player->id)->paginate($limit, $offset);

		$data = $this->fractal->collection($videos, new VideoTransformer(), 'videos');

		return $this->respondWithSuccess($data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /videos
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @return \Response
	 */
	public function store($sportId, $teamId, $playerId)
	{
		$formData = Input::all();

		$this->videoRequest->validate($formData);

		try {
			DB::beginTransaction();

			$player = Auth::user()->sports()->findOrfail($sportId)
				->teams()->findOrFail($teamId)
				->players()->findOrFail($playerId);

			$video = $player->videos()->create(array_merge($formData, [
				'slug' => Str::random(),
				'thumbnail' => Str::random(),
			]));

			$this->moveThumbnail($video->id, $video->thumbnail);
			$this->moveVideo($video->id, $video->slug);

			DB::commit();

		} catch(Exception $e) {
			DB::rollBack();

			return $this->respondUnprocess('Unable to save the video!');
		}

		$data = $this->fractal->item($video, new VideoTransformer());

		return $this->respondWithSuccess(array_merge($data, ['videos_count' => $player->videos->count()]));
	}

	/**
	 * Display the specified resource.
	 * GET /videos/{id}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @param $videoId
	 * @return \Response
	 */
	public function show($sportId, $teamId, $playerId, $videoId)
	{
		$player = Auth::user()->sports()->findOrfail($sportId)
			->teams()->findOrFail($teamId)
			->players()->findOrFail($playerId);

		$video = $player->videos()->findOrFail($videoId);

		$data = $this->fractal->item($video, new VideoTransformer());

		return $this->respondWithSuccess($data);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /videos/{videoId}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @param $videoId
	 * @return \Response
	 * @throws \Laracasts\Validation\FormValidationException
	 */
	public function update($sportId, $teamId, $playerId, $videoId)
	{
		$formData = Input::all();

		$this->videoRequest->updateRules()->validate($formData);

		$video = Auth::user()->sports()->findOrfail($sportId)
			->teams()->findOrFail($teamId)
			->players()->findOrFail($playerId)
			->videos()->findOrFail($videoId);

		try {
			DB::beginTransaction();

			if(Input::hasFile('video') && Input::hasFile('thumbnail_image')) {
				File::delete(storage_path("videos/{$video->id}"));

				$formData = array_merge($formData, [
					'slug' => Str::random(),
					'thumbnail' => Str::random(),
				]);
			}

			$video->update($formData);

			$this->moveThumbnail($video->id, $video->thumbnail);
			$this->moveVideo($video->id, $video->slug);

			DB::commit();

		} catch(Exception $e) {
			DB::rollBack();

			return $this->respondUnprocess('Unable to update the video!');
		}

		$data = $this->fractal->item($video, new VideoTransformer());

		return $this->respondWithSuccess($data);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /videos/{videoId}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @param $videoId
	 * @return \Response
	 */
	public function destroy($sportId, $teamId, $playerId, $videoId)
	{
		$video = Auth::user()->sports()->findOrfail($sportId)
			->teams()->findOrFail($teamId)
			->players()->findOrFail($playerId)
			->videos()->findOrFail($videoId);

		try {
			File::delete(storage_path("videos/{$video->id}"));

			$video->delete();
		} catch(Exception $e) {

			return $this->respondUnprocess('Unable to delete the video!');
		}

		return $this->respondWithSuccess('Video has been successfully deleted.');
	}

	/**
	 * Show video
	 *
	 * @param $videoId
	 * @return \Illuminate\Http\Response
	 */
	public function showVideo($videoId)
	{
		$video = Video::findOrFail($videoId);

		$path = $this->getVideoPath($video);

		$response = Response::make(file_get_contents($path), '200');

		$response->header('Content-Type', $video->video_mime);

		return $response;
	}

	/**
	 * Show video thumbnail
	 *
	 * @param $videoId
	 * @return \Illuminate\Http\Response
	 */
	public function showThumbnail($videoId)
	{
		$video = Video::findOrFail($videoId);

		$path = $this->getVideoThumbnailPath($video);

		$response = Response::make(file_get_contents($path), '200');

		$response->header('Content-Type', $video->thumbnail_mime);

		return $response;
	}

	/**
	 * Video thumbnail path
	 *
	 * @param $video
	 * @return string
	 */
	private function getVideoThumbnailPath($video)
	{
		$path = "videos/{$video->id}/thumb/{$video->thumbnail}";

		return storage_path($path);
	}

	/**
	 * Video path
	 *
	 * @param $video
	 * @return string
	 */
	private function getVideoPath($video)
	{
		$path = "videos/{$video->id}/{$video->slug}";

		return storage_path($path);
	}

	/**
	 * Move thumbnail to app/storage path
	 *
	 * @param $path
	 * @param $name
	 */
	private function moveThumbnail($path, $name)
	{
		if(Input::hasFile('thumbnail_image') && Input::file('thumbnail_image')->isValid()) {

			Input::file('thumbnail_image')->move(storage_path("videos/$path/thumb"), $name);
		}
	}

	/**
	 * Move video to app/storage path
	 *
	 * @param $path
	 * @param $name
	 */
	private function moveVideo($path, $name)
	{
		if(Input::hasFile('video') && Input::file('video')->isValid()) {

			Input::file('video')->move(storage_path("videos/$path"), $name);
		}
	}
}