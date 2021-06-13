<?php

use Athlete\Repositories\Sport\SportRepository;
use Athlete\Requests\SportRequest;
use Athlete\Transformers\SportTransformer;
use Sorskod\Larasponse\Larasponse;

class SportsController extends ApiController
{

    /**
     * @var \Sorskod\Larasponse\Larasponse $fractal
     */
    private $fractal;

    /**
     * @var \Athlete\Repositories\Sport\SportRepository $repository
     */
    private $repository;

    /**
     * @var \Athlete\Requests\UpdateSportRequest $updateSportRequest
     */
    private $sportRequest;

    /**
     * @param \Sorskod\Larasponse\Larasponse $fractal
     * @param \Athlete\Repositories\Sport\SportRepository $repository
     * @param SportRequest $sportRequest
     */
    public function __construct(Larasponse $fractal,
                                SportRepository $repository,
                                SportRequest $sportRequest
    )
    {
        $this->fractal = $fractal;
        $this->fractal->parseIncludes($this->getIncludes());

        $this->repository = $repository;
        $this->sportRequest = $sportRequest;
    }

    /**
     * Display a listing of the resource.
     * GET /sports
     *
     * @return Response
     */
    public function index()
    {
        $limit = Request::get('limit') ?: 20;

        $offset = Request::get('offset') ?: 0;

        $sports = $this->repository->filterByUser(Auth::user()->id)->paginate($limit, $offset);

        $data = $this->fractal->collection($sports, new SportTransformer(), 'sports');

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
        $formData = Input::all();

        $this->sportRequest->rules(Auth::user()->id)->validate($formData);

        try {
            DB::beginTransaction();

            if (Input::hasFile('image')) {
                $formData = array_merge($formData, ['image' => Str::random()]);
            }

            $sport = Auth::user()->sports()->save(new Sport($formData));

            $this->moveImage($sport->user_id, $sport->image);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return $this->respondUnprocess('Unable to save the sport!');
        }

        $data = $this->fractal->item($sport, new SportTransformer());

        return $this->respondWithSuccess($data);
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

            Input::file('image')->move(storage_path("images/$path"), $name);
        }
    }

    /**
     * Display the specified resource.
     * GET /sports/{id}
     *
     * @param int $id
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
     * @param int $id
     * @return Response
     */
    public function update($id)
    {
        $formData = Input::all();

        $userId = Auth::user()->id;

        $this->sportRequest->updateRules($userId, $id)->validate($formData);

        $sport = $this->repository->filterByUser($userId)->findById($id);

        try {
            DB::beginTransaction();

            // rename the image name to clear caching for mobile devices
            if (Input::hasFile('image')) {
                $path = storage_path("images/{$sport->user_id}/{$sport->image}");
                File::delete($path);

                $formData = array_merge($formData, ['image' => Str::random()]);
            }

            $sport->update($formData);

            $this->moveImage($sport->user_id, $sport->image);

            DB::commit();
        } catch (Exception $e) {
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
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $sport = $this->repository->filterByUser(Auth::user()->id)->findById($id);

        try {
            if ($sport->image != 'default.png') {
                $path = storage_path("images/{$sport->user_id}/{$sport->image}");

                $sport->delete();
                File::delete($path);
            }
        } catch (Exception $e) {

            return $this->respondUnprocess('Unable to delete the sport!');
        }

        return $this->respondWithSuccess('Sport has been successfully deleted.');
    }
}
