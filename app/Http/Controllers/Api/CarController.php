<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Traits\RespondsApi;
use Illuminate\Http\Request;
use App\Repositories\CarRepository;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    use RespondsApi;

    private $repository;

    public function __construct()
    {
        $this->repository = new CarRepository();
    }

    /**
     * @OA\Get(
     *     summary="Car list",
     *     description="Returns a list containing all Car resources",
     *     path="/carros",
     *     @OA\Response(
     *          response="200",
     *          description="A list with courses",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="Token expiration in miliseconds",
     *                         @OA\Items(
     *                         )
     *                     ),
     *                     example={
     *                         "data": {
     *                              {
     *                                  "id": "1",
     *                                  "model": "Example Model",
     *                                  "year": "2021",
     *                                  "brand_id": "1",
     *                                  "brand_name": "Example Brand Name"
     *                              }
     *                          }
     *                     }
     *                 )
     *             )
     *          }
     *     )
     *
     * ),
     *
     */
    public function index()
    {
        return $this->repository->fetchAll();
    }

    public function show(int $id)
    {
        return $this->repository->fetch($id);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'model' => 'required',
            'year' => 'required',
            'brand_id' => 'required|exists:brands,id'
        ]);

        if ($validation->fails()) return $this->error($validation->getMessageBag(), 400);

        return $this->repository->store($request->all());
    }


    public function update(Request $request, int $id)
    {
        $request['id'] = $id;
        $validation = Validator::make($request->all(), [
            'id' => 'required|exists:cars,id',
            'brand_id' => 'sometimes|required|exists:brands,id'
        ]);

        if ($validation->fails()) return $this->error($validation->getMessageBag(), 400);

        return $this->repository->update($request->all());
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
