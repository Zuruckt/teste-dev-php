<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\RespondsApi;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use RespondsApi;

    /**
     * @OA\Get(
     *     path="/brands",
     *     summary="Brand index",
     *     description="Returns a list containing all Brand resources",
     *     @OA\Response(
     *          response="200",
     *          description="A list with all registered brands",
     *          content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="Array of Brand models",
     *                         @OA\Items()
     *                     ),
     *                     example={
     *                         "data": {
     *                              {
     *                                  "id": 1,
     *                                  "name": "Ford"
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
    public function __invoke()
    {
        return $this->success(Brand::all());
    }
}
