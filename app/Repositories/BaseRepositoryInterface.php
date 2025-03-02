<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function create(array $data): Model;
    public function findById(int $id): ?Model;
    public function findByIdWithTrashed(int $id): ?Model;
    public function delete(int $id): bool;
    public function restore(int $id): bool;
}
