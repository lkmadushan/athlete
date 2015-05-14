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

		return $this->respondWithSuccess(array_merge($data, ['teams_count' => Auth::user()->teams->count()]));
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

		$this->teamRequest->rules($id)->validate($formData);

		$sport = Auth::user()->sports()->findOrFail($id);

		$team = $sport->teams()->create($formData);

		$data = $this->fractal->item($team, new TeamTransformer());

		return $this->respondWithSuccess(array_merge($data, ['teams_count' => Auth::user()->teams->count()]));
	}

	/**
	 * Display the specified resource.
	 * GET sports/{sportId}/teams/{teamId}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @return Response
	 */
	public function show($sportId, $teamId)
	{
		$sport = Auth::user()->sports()->findOrFail($sportId);

		$team = $this->repository->filterBySport($sport->id)->findById($teamId);

		$data = $this->fractal->item($team, new TeamTransformer());

		return $this->respondWithSuccess($data);
	}

	/**
	 * Update the specified resource in storage.
	 * PATCH sports/{sportId}/teams/{teamId}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @return \Response
	 */
	public function update($sportId, $teamId)
	{
		$formData = Input::only('name');

		$this->teamRequest->rules($sportId, $teamId)->validate($formData);

		$sport = Auth::user()->sports()->findOrFail($sportId);

		$team = $this->repository->filterBySport($sport->id)->findById($teamId);

		$team->update($formData);

		$data = $this->fractal->item($team, new TeamTransformer());

		return $this->respondWithSuccess($data);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE sports/{sportId}/teams/{teamId}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @return \Response
	 */
	public function destroy($sportId, $teamId)
	{
		$sport = Auth::user()->sports()->findOrFail($sportId);

		$team = $this->repository->filterBySport($sport->id)->findById($teamId);

		$team->delete();

		return $this->respondWithSuccess('Team has been successfully deleted.');
	}
}