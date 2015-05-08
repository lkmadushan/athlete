<?php

use Athlete\Requests\SkillRequest;
use Sorskod\Larasponse\Larasponse;
use Athlete\Transformers\SkillTransformer;
use Athlete\Repositories\Skill\SkillRepository;

class SkillsController extends ApiController {

	/**
	 * @var \Sorskod\Larasponse\Larasponse $fractal
	 */
	private $fractal;

	/**
	 * @var \Athlete\Repositories\Skill\SkillRepository $repository
	 */
	private $repository;

	/**
	 * @var \Athlete\Requests\SkillRequest $skillRequest
	 */
	private $skillRequest;

	/**
	 * @param \Sorskod\Larasponse\Larasponse $fractal
	 * @param SkillRepository $repository
	 * @param \Athlete\Requests\SkillRequest $skillRequest
	 */
	public function __construct(Larasponse $fractal,
	                            SkillRepository $repository,
	                            SkillRequest $skillRequest
	)
	{
		$this->fractal = $fractal;
		$this->fractal->parseIncludes($this->getIncludes());

		$this->repository = $repository;
		$this->skillRequest = $skillRequest;
	}

	/**
	 * Display a listing of the resource.
	 * GET /skills
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

		$skills = $this->repository->filterByPlayer($player->id)->paginate($limit, $offset);

		$data = $this->fractal->collection($skills, new SkillTransformer(), 'skills');

		return $this->respondWithSuccess($data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /skills
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @return \Response
	 */
	public function store($sportId, $teamId, $playerId)
	{
		if(Input::isJson()) {

			$formData = Input::json();

			$this->skillRequest->validateJson($formData);

			$player = Auth::user()->sports()->findOrfail($sportId)
				->teams()->findOrFail($teamId)
				->players()->findOrFail($playerId);

			$skills = $player->skills()->createMany($formData->all());

			$data = $this->fractal->collection($skills, new SkillTransformer());

			return $this->respondWithSuccess($data);
		}

		return $this->respondWithError('JSON content is required!');
	}

	/**
	 * Display the specified resource.
	 * GET /skills/{id}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @param $skillId
	 * @return \Response
	 */
	public function show($sportId, $teamId, $playerId, $skillId)
	{
		$player = Auth::user()->sports()->findOrfail($sportId)
			->teams()->findOrFail($teamId)
			->players()->findOrFail($playerId);

		$skill = $player->skills()->findOrFail($skillId);

		$data = $this->fractal->item($skill, new SkillTransformer());

		return $this->respondWithSuccess($data);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /skills/{skillId}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @param $skillIds
	 * @return \Response
	 * @throws \Laracasts\Validation\FormValidationException
	 */
	public function update($sportId, $teamId, $playerId, $skillIds = null)
	{
		if(Input::isJson()) {

			$formData = Input::json('skills');

			$this->skillRequest->validate($formData);

			$player = Auth::user()->sports()->findOrfail($sportId)
				->teams()->findOrFail($teamId)
				->players()->findOrFail($playerId);

			$skills = $this->repository->updatePlayerSkills($formData->all(), $player);

			$data = $this->fractal->collection($skills, new SkillTransformer());

			return $this->respondWithSuccess($data);
		}

		return $this->respondWithError('JSON content is required!');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /skills/{skillId}
	 *
	 * @param $sportId
	 * @param $teamId
	 * @param $playerId
	 * @param $skillId
	 * @return \Response
	 */
	public function destroy($sportId, $teamId, $playerId, $skillId)
	{
		$player = Auth::user()->sports()->findOrfail($sportId)
			->teams()->findOrFail($teamId)
			->players()->findOrFail($playerId);

		$skill = $player->skills()->findOrFail($skillId);

		$skill->delete();

		return $this->respondWithSuccess('Skill has been successfully deleted.');
	}
}