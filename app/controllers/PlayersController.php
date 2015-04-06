<?php

use Athlete\Requests\PlayerRequest;
use Sorskod\Larasponse\Larasponse;
use Athlete\Transformers\PlayerTransformer;
use Athlete\Repositories\Player\PlayerRepository;

class PlayersController extends ApiController {

	/**
	 * @var \Sorskod\Larasponse\Larasponse $fractal
	 */
	private $fractal;

	/**
	 * @var \Athlete\Repositories\Player\PlayerRepository $repository
	 */
	private $repository;

	/**
	 * @var \Athlete\Requests\PlayerRequest $playerRequest
	 */
	private $playerRequest;

	/**
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 * @param PlayerRepository $repository
	 * @param \Athlete\Requests\PlayerRequest $playerRequest
	 */
	public function __construct(Larasponse $fractal,
	                            PlayerRepository $repository,
	                            PlayerRequest $playerRequest
	)
	{
		$this->fractal = $fractal;
		$this->fractal->parseIncludes($this->getIncludes());

		$this->repository = $repository;
		$this->playerRequest = $playerRequest;
	}

	/**
	 * Display a listing of the resource.
	 * GET /players
	 *
	 * @param $sportId
	 * @param $teamId
	 * @return \Response
	 */
	public function index($sportId, $teamId)
	{
		$limit = Request::get('limit') ?: 20;

		$offset = Request::get('offset') ?: 0;

		$team = Auth::user()->sports()->whereSportId($sportId)->teams()->findOrFail($teamId);

		$players = $this->repository->filterByTeam($team->id)->paginate($limit, $offset);

		$data = $this->fractal->collection($players, new playerTransformer(), 'players');

		return $this->respondWithSuccess($data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /sports
	 *
	 * @param $sportId
	 * @param $teamId
	 * @return \Response
	 */
	public function store($sportId, $teamId)
	{
		$formData = Input::only('name');

		$this->teamRequest->validate($formData);

		$team = Auth::user()->sports()->whereSportId($sportId)->teams()->findOrFail($teamId);

		$team = $team->players()->create($formData);


		try {
			DB::beginTransaction();

			$sport = Auth::user()->sports()->save(new Sport($formData));

			$this->moveImage($sport->user_id, $sport->image);

			DB::commit();
		} catch(Exception $e) {
			DB::rollBack();

			return $this->respondUnprocess('Unable to save the sport!');
		}

		$data = $this->fractal->item($team, new TeamTransformer());

		return $this->respondWithSuccess(array_merge($data, ['teams_count' => Team::count()]));
	}

	/**
	 * Display the specified resource.
	 * GET /sports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sport = $this->repository->filterByUser(Auth::user()->id)->findById($id);

		$data = $this->fractal->item($sport, new SportTransformer());

		return $this->respondWithSuccess($data);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /sports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$formData = Input::all();

		$this->sportRequest->updateRules()->validate($formData);

		$sport = $this->repository->filterByUser(Auth::user()->id)->findById($id);

		try {
			DB::beginTransaction();

			$sport->update($formData);

			$this->moveImage($sport->user_id, $sport->image);

			DB::commit();
		} catch(Exception $e) {
			DB::rollBack();

			return $this->respondUnprocess('Unable to update the sport!');
		}

		$data = $this->fractal->item($sport, new SportTransformer());

		return $this->respondWithSuccess($data);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /sports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$sport = $this->repository->filterByUser(Auth::user()->id)->findById($id);

		try {
			if($sport->image != 'default.png') {
				$path = storage_path("images/{$sport->user_id}/{$sport->image}");

				$sport->delete();
				File::delete($path);
			}
		} catch(Exception $e) {

			return $this->respondUnprocess('Unable to delete the sport!');
		}

		return $this->respondWithSuccess('Sport has been successfully deleted.');
	}

	/**
	 * Move image to app/storage path
	 *
	 * @param $path
	 * @param $name
	 */
	private function moveImage($path, $name)
	{
		if(Input::hasFile('image') && Input::file('image')->isValid()) {

			Input::file('image')->move(storage_path("images/$path"), $name);
		}
	}
}