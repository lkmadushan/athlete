<?php

use Sorskod\Larasponse\Larasponse;
use Athlete\Repositories\Sport\SportRepository;
use Athlete\Transformers\SportTransformer;

class SportsController extends ApiController {

	/**
	 * @var \Sorskod\Larasponse\Larasponse $fractal
	 */
	private $fractal;

	/**
	 * @var \Athlete\Repositories\Sport\SportRepository $repository
	 */
	private $repository;

	/**
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 * @param \Athlete\Repositories\Sport\SportRepository $repository
	 */
	public function __construct(Larasponse $fractal, SportRepository $repository)
	{
		$this->fractal = $fractal;
		$this->fractal->parseIncludes($this->getIncludes());

		$this->repository = $repository;
	}

	/**
	 * Display a listing of the resource.
	 * GET /sports
	 *
	 * @return Response
	 */
	public function index()
	{
		$limit = Request::get('limit') ?: 10;

		$sports = $this->repository->filterByUser(Auth::user()->id)->paginate($limit);

		$data = $this->fractal->paginatedCollection($sports, new SportTransformer(), 'sports');

		return $this->respondWithSuccess($data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /sports
	 *
	 * @return Response
	 */
	public function store()
	{
		dd('hi');
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
		$sport = $this->repository->filterByUser(Auth::user()->id)->findById($id);

		try {
			DB::beginTransaction();

			$sport->update(Input::all());

			if(Input::hasFile('image') && Input::file('image')->isValid()) {

				Input::file('image')->move(storage_path("images/{$sport->id}"), $sport->image);
			}

			DB::commit();
		} catch(Exception $e) {
			DB::rollBack();
		}
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
		//
	}
}