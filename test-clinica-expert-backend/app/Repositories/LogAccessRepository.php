<?php

namespace App\Repositories;

use App\Models\LogAccess;
use App\ValueObjects\LogAccessAttrs;
use Illuminate\Database\Eloquent\Collection;

class LogAccessRepository
{
    private LogAccess $model;

    public function __construct(LogAccess $logAccess)
    {
        $this->model = $logAccess;
    }

    public function list(): Collection
    {
        return $this->model::all();
    }

    public function save(LogAccessAttrs $attr): LogAccess
    {
        return $this->model::create($attr->toArray());
    }

    public function update(string $id, array $attr): LogAccess
    {
        $logAccess = $this->model::find($id);
        $logAccess->update($attr);
        return $logAccess;
    }

    public function delete(string $id): LogAccess
    {
        $logAccess = $this->model::find($id);
        $logAccess->delete();
        return $logAccess;
    }
}
