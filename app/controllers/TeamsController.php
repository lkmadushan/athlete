<?php

use Athlete\Requests\TeamRequest;
use Sorskod\Larasponse\Larasponse;
use Athlete\Transformers\TeamTransformer;
use Athlete\Repositories\Team\TeamRepository;

class TeamsController extends \ApiController {

	/**
	 * @var \Sorskod\Larasponse\Larasponse $fractal
	 */
	private $fractal;

	/**
	 * @var \Athlete\Repositories\Team\TeamRepository $repository
	 */
	private $repository;

	/**
	 * @var \Athlete\Requests\TeamRequest
	 */
	private $teamRequest;

	/**
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 * @param TeamRepository $repository
	 * @param TeamRequest $teamRequest
	 */
	public function __construct(Larasponse $fractal,
	                            TeamRepository $repository,
								TeamRequest $teamRequest
	)
	{
		$this->fractal = $fractal;
		$this->fractal->parseIncludes($this->getIncludes());

		$this->repository = $repository;
		$this->teamRequest = $teamRequest;
	}

	/**
	 * Display a listing of the resource.
	 * GET sports/{sportId}/teams
	 *
	 * @param $id
	 * @return \Response
	 */
	public function index($id)
	{
		$limit = Request::get('limit') ?: 20;

		$offset = Request::get('offset') ?: 0;

		$sport = Auth::user()->sports()->findOrFail($id);

		$teams = $this->repository->filterBySport($sport->id)->paginate($limit, $offset);

		$data = $this->fractal->collection($teams, new TeamTransformer(), 'teams');

		return $this->respondWithSuccess($data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST sports/{sportId}/teams
	 *
	 * @param $id
	 * @return \Response
	 * @throws \Laracasts\Validation\FormValidationException
	 */
	public function store($id)
	{
		$formData = Input::only('name');

		$this->teamRequest->validate($formData);

		$sport = Auth::user()->sports()->findOrFail($id);

		$team = $sport->teams()->create($formData);

		$data = $this->fractal->item($team, new TeamTransformer());

		return $this->respondWithSuccess(array_merge($data, ['sports_count' => Team::count()]));
	}

	/**
	 * Display the specified resource.
	 * GET /teams/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /teams/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /teams/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}