<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findByIdWithTrashed(int $id): ?Model
    {
        return $this->model->withTrashed()->find($id);
    }

    public function delete(int $id): bool
    {
        $model = $this->findById($id);
        return $model ? $model->delete() : false;
    }

    public function restore(int $id): bool
    {
        $model = $this->findByIdWithTrashed($id);
        return $model ? $model->restore() : false;
    }
}