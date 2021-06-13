<?php

use Athlete\Repositories\Player\PlayerRepository;
use Athlete\Requests\PlayerRequest;
use Athlete\Transformers\PlayerTransformer;
use Sorskod\Larasponse\Larasponse;

class PlayersController extends ApiController
{

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

        $team = Auth::user()->sports()->findOrfail($sportId)->teams()->findOrFail($teamId);

        $players = $this->repository->filterByTeam($team->id)->paginate($limit, $offset);

        $data = $this->fractal->collection($players, new playerTransformer(), 'players');

        return $this->respondWithSuccess(array_merge($data, ['players_count' => $team->players->count()]));
    }

    /**
     * Store a newly created resource in storage.
     * POST /players
     *
     * @param $sportId
     * @param $teamId
     * @return \Response
     */
    public function store($sportId, $teamId)
    {
        $formData = Input::all();

        $this->playerRequest->validate($formData);

        $team = Auth::user()->sports()->findOrFail($sportId)->teams()->findOrFail($teamId);

        try {
            DB::beginTransaction();

            if (Input::hasFile('image')) {
                $formData = array_merge($formData, ['image' => Str::random()]);
            }

            $player = $team->players()->create($formData);

            //save weight, height of the player if they exists
            if (array_key_exists('weight_unit', $formData)) {

                $player->weight()->save(new Weight([
                    'unit' => $formData['weight_unit'],
                    'value' => $formData['weight_value']
                ]));
            }

            if (array_key_exists('height_unit', $formData)) {

                $player->height()->save(new Height([
                    'unit' => $formData['height_unit'],
                    'value' => $formData['height_value']
                ]));
            }

            $this->moveImage($player->id, $player->image);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->respondUnprocess('Unable to save the player!');
        }

        $data = $this->fractal->item($player, new PlayerTransformer());

        return $this->respondWithSuccess(array_merge($data, ['players_count' => $team->players->count()]));
    }

    /**
     * Move image to app/storage path
     *
     * @param $path
     * @param $name
     */
    private function moveImage($path, $name)
    {
        if (Input::hasFile('image') && Input::file('image')->isValid()) {

            Input::file('image')->move(storage_path("players/$path"), $name);
        }
    }

    /**
     * Display the specified resource.
     * GET /players/{id}
     *
     * @param $sportId
     * @param $teamId
     * @param $playerId
     * @return \Response
     */
    public function show($sportId, $teamId, $playerId)
    {
        $team = Auth::user()->sports()->findOrFail($sportId)->teams()->findOrFail($teamId);

        $player = $team->players()->findOrFail($playerId);

        $data = $this->fractal->item($player, new playerTransformer());

        return $this->respondWithSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     * PUT /players/{playerId}
     *
     * @param $sportId
     * @param $teamId
     * @param $playerId
     * @return \Response
     * @throws \Laracasts\Validation\FormValidationException
     */
    public function update($sportId, $teamId, $playerId)
    {
        $formData = Input::all();

        $this->playerRequest->updateRules()->validate($formData);

        $team = Auth::user()->sports()->findOrFail($sportId)->teams()->findOrFail($teamId);

        $player = $team->players()->findOrFail($playerId);

        try {
            DB::beginTransaction();

            // rename the image name to clear caching for mobile devices
            if (Input::hasFile('image')) {
                $path = storage_path("players/{$player->id}/{$player->image}");
                File::delete($path);

                $formData = array_merge($formData, ['image' => Str::random()]);
            }

            $player->update($formData);

            //update weight, height of the player
            if (array_key_exists('weight_unit', $formData)) {

                Weight::updateOrCreate([
                    'id' => $playerId
                ], [
                    'unit' => $formData['weight_unit'],
                    'value' => $formData['weight_value']
                ]);
            }

            if (array_key_exists('height_unit', $formData)) {

                Height::updateOrCreate([
                    'id' => $playerId
                ], [
                    'unit' => $formData['height_unit'],
                    'value' => $formData['height_value']
                ]);
            }

            $this->moveImage($player->id, $player->image);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->respondUnprocess('Unable to update the player!');
        }

        $data = $this->fractal->item($player, new PlayerTransformer());

        return $this->respondWithSuccess($data);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /players/{playerId}
     *
     * @param $sportId
     * @param $teamId
     * @param $playerId
     * @return \Response
     */
    public function destroy($sportId, $teamId, $playerId)
    {
        $team = Auth::user()->sports()->findOrFail($sportId)->teams()->findOrFail($teamId);

        $player = $team->players()->findOrFail($playerId);

        try {
            if ($player->image != 'default.png') {
                $path = storage_path("players/{$player->id}");

                $player->delete();
                File::delete($path);
            }
        } catch (Exception $e) {

            return $this->respondUnprocess('Unable to delete the player!');
        }

        return $this->respondWithSuccess('Player has been successfully deleted.');
    }
}
