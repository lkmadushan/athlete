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
		$formData = Input::all();

		$this->playerRequest->validate($formData);

		$team = Auth::user()->sports()->find($sportId)->teams()->findOrFail($teamId);

		try {
			DB::beginTransaction();

			if(Input::hasFile('image')) {
				$formData = array_merge($formData, ['image' => Str::random()]);
			}

			$player = $team->players()->create($formData);

			//save weight, height of the player
			$player->weight()->save(new Weight([
				'unit' => $formData['weight_unit'],
				'value' => $formData['weight_value']
			]));

			$player->height()->save(new Height([
				'unit' => $formData['height_unit'],
				'value' => $formData['height_value']
			]));

			$this->moveImage($player->id, $player->image);

			DB::commit();
		} catch(Exception $e) {
			DB::rollBack();

			return $this->respondUnprocess('Unable to save the sport!');
		}

		$data = $this->fractal->item($player, new PlayerTransformer());

		return $this->respondWithSuccess(array_merge($data, ['teams_count' => Team::count()]));
	}

	/**
	 * Display the specified resource.
	 * GET /sports/{id}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @return \Response
	 */
	public function show($sportId, $teamId, $playerId)
	{
		$team = Auth::user()->sports()->find($sportId)->teams()->findOrFail($teamId);

		$player = $team->players()->findOrFail($playerId);

		$data = $this->fractal->item($player, new SportTransformer());

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

			Input::file('image')->move(storage_path("players/$path"), $name);
		}
	}
}