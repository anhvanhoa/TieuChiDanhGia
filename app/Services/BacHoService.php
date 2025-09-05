<?php

namespace App\Services;

use App\Models\BacHo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BacHoService
{
    protected $model;

    public function __construct(BacHo $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with(['bacBo.bacLop.bacNganh'])->get();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with(['bacBo.bacLop.bacNganh'])->paginate($perPage);
    }

    public function findById(int $id): ?BacHo
    {
        return $this->model->with(['bacBo.bacLop.bacNganh'])->find($id);
    }

    public function create(array $data): BacHo
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $bacHo = $this->findById($id);

        if (!$bacHo) {
            return false;
        }

        return $bacHo->update($data);
    }

    public function delete(int $id): bool
    {
        $bacHo = $this->findById($id);

        if (!$bacHo) {
            return false;
        }

        return $bacHo->delete();
    }

    public function isInUse(int $id): bool
    {
        $bacHo = $this->findById($id);

        if (!$bacHo) {
            return false;
        }

        return $bacHo->bacChi()->count() > 0;
    }

    public function searchByName(string $name): Collection
    {
        return $this->model->where(function($query) use ($name) {
            $query->where('ten_khoa_hoc', 'like', '%' . $name . '%')
                  ->orWhere('ten_tieng_viet', 'like', '%' . $name . '%');
        })->with(['bacBo.bacLop.bacNganh'])->get();
    }

    public function getByBacBo(int $bacBoId): Collection
    {
        return $this->model->where('bac_bo_id', $bacBoId)
            ->with(['bacBo.bacLop.bacNganh'])
            ->get();
    }
}
