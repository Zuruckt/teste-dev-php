<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
     *     path="/cars",
     *     summary="Car index",
     *     description="Returns a list containing all Car resources",
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
     *                         description="Array of Car Objects",
     *                         @OA\Items()
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

    /**
     * @OA\Get(
     *     path="/cars/{id}",
     *     summary="Car lookup",
     *     description="Returns the requested Car data",
     *     @OA\Parameter(
     *          name="id",
     *          description="The unique indentifier for the car",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="A Car Object",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="Car Object data",
     *                         @OA\Items()
     *                     ),
     *                     example={
     *                         "data": {
     *                                  "id": "77",
     *                                  "model": "Celta",
     *                                  "year": "2016",
     *                                  "brand_id": "14",
     *                                  "brand_name": "Chevrolet"
     *                              }
     *                     }
     *                 )
     *             )
     *          }
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Model not found",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="error",
     *                         type="string",
     *                         description="No model found for the given ID"
     *                     ),
     *                     example={
                                    "error": "No query results for model [App\\Models\\Car] 0"
                                }
     *                 )
     *             )
     *          }
     *     )
     *
     * ),
     *
     */
    public function show(int $id)
    {
        return $this->repository->fetch($id);
    }


    /**
     * @OA\Post(
     *     path="/cars",
     *     summary="Car creation",
     *     description="Create a new Car",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                     required={
     *                          "model",
     *                          "year",
     *                          "brand_id"
     *                     },
     *                     @OA\Property (
     *                          property="model",
     *                          type="string",
     *                          description="The car's model name",
     *                          example="Uno"
     *                     ),
     *                     @OA\Property (
     *                          property="year",
     *                          type="integer",
     *                          description="The car's release year",
     *                          example="2018"
     *                     ),
     *                     @OA\Property (
     *                          property="brand_id",
     *                          type="integer",
     *                          description="The car's brand id, check /brands",
     *                          example="1"
     *                     )
     *                 )
     *             )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The Car was created successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="Car Object",
     *                         @OA\Items()
     *                     ),
     *                     example={
     *                         "data": {
     *                                  "id": "24",
     *                                  "model": "Uno",
     *                                  "year": "2018",
     *                                  "brand_id": "1",
     *                                  "brand_name": "Fiat"
     *                          }
     *                     }
     *                 )
     *             )
     *          }
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="The given data was invalid",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="Car Object",
     *                         @OA\Items()
     *                     ),
     *                     example={
     *                         "error": {
     *                                  "model": {
     *                                      "The model field is required"
     *                                   },
     *                                   "year": {
     *                                      "The year must be an integer"
     *                                   },
     *                                   "brand_id": {
     *                                      "The selected brand id is invalid"
     *                                   }
     *                          }
     *                     }
     *                 )
     *             )
     *          }
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'model' => 'required',
            'year' => 'required|integer',
            'brand_id' => 'required|exists:brands,id'
        ]);

        if ($validation->fails()) return $this->error($validation->getMessageBag(), 400);

        return $this->repository->store($request->all());
    }

    /**
     * @OA\Put(
     *     path="/cars/{id}",
     *     summary="Car update",
     *     description="Update a existing car",
     *      @OA\Parameter(
     *          name="id",
     *          description="The unique indentifier for the car",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                     @OA\Property (
     *                          property="model",
     *                          type="string",
     *                          description="The car's model name",
     *                          example="Uno"
     *                     ),
     *                     @OA\Property (
     *                          property="year",
     *                          type="integer",
     *                          description="The car's release year",
     *                          example="2018"
     *                     ),
     *                     @OA\Property (
     *                          property="brand_id",
     *                          type="integer",
     *                          description="The car's brand id, check /brands",
     *                          example="1"
     *                     )
     *                 )
     *             )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The Car was updated successfully",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="Car Object",
     *                         @OA\Items()
     *                     ),
     *                     example={
     *                         "data": {
     *                                  "id": "24",
     *                                  "model": "Uno",
     *                                  "year": "2018",
     *                                  "brand_id": "1",
     *                                  "brand_name": "Fiat"
     *                          }
     *                     }
     *                 )
     *             )
     *          }
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="The given data was invalid",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="Car Object",
     *                         @OA\Items()
     *                     ),
     *                     example={
     *                         "error": {
     *                                  "model": {
     *                                      "The model field is required"
     *                                   },
     *                                   "year": {
     *                                      "The year must be an integer"
     *                                   },
     *                                   "brand_id": {
     *                                      "The selected brand id is invalid"
     *                                   }
     *                          }
     *                     }
     *                 )
     *             )
     *          }
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Model not found",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="error",
     *                         type="string",
     *                         description="No model found for the given ID"
     *                     ),
     *                     example={
     *                                  "error": "No query results for model [App\\Models\\Car] 0"
     *                              }
     *                 )
     *             )
     *          }
     *     )
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/cars/{id}",
     *     summary="Car deletion",
     *     description="Delete the requested car",
     *     @OA\Parameter(
     *          name="id",
     *          description="The unique indentifier for the car",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Car deletion confirmation",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="Delete confirmation"
     *                     ),
     *                     example={
     *                        "message": "Resource deleted"
     *                     }
     *                 )
     *             )
     *          }
     *     )
     * ),
     *
     */
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
