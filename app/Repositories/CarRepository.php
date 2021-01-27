<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Car;
use App\Traits\RespondsApi;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarRepository
{
    use RespondsApi;

    private $model;

    public function __construct()
    {
        $this->model = new Car();
    }

    public function fetchAll()
    {
        return $this->success($this->model->all());
    }

    public function fetch(int $id)
    {
        try {
            $data = $this->model->findOrFail($id);
            return $this->success($data);
        } catch (ModelNotFoundException $exception) {
            return $this->error($exception->getMessage(), 404);
        }
    }

    public function store(array $data)
    {
        $car = $this->model->create([
            'model' => $data['model'],
            'year' => $data['year'],
            'brand_id' => $data['brand_id']
        ]);

        return $this->success($car, 201);
    }

    public function update(array $data)
    {
        $car = $this->model->find($data['id']);
        $car->update($data);

        return $this->success($car);
    }

    public function delete(int $id)
    {
        return $this->deleted($this->model->destroy($id));
    }
}
