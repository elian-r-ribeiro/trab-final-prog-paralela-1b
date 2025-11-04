<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function show(string $id)
    {
        return $this->model->find($id);
    }

    public function update(array $data, string $id)
    {
        $user = $this->find($id);

        $user->update($data);

        return $user->fresh();
    }

    public function find(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function destroy(string $id)
    {
        $this->find($id)->delete();
    }
}
