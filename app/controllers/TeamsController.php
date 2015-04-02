<?php

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
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 * @param TeamRepository $repository
	 */
	public function __construct(Larasponse $fractal, TeamRepository $repository)
	{
		$this->fractal = $fractal;
		$this->fractal->parseIncludes($this->getIncludes());

		$this->repository = $repository;
	}

	/**
	 * Display a listing of the resource.
	 * GET /teams
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
	 * POST /teams
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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