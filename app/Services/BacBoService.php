<?php

namespace App\Services;

use App\Models\BacBo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BacBoService
{
    protected $model;

    public function __construct(BacBo $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with(['bacLop.bacNganh'])->get();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with(['bacLop.bacNganh'])->paginate($perPage);
    }

    public function findById(int $id): ?BacBo
    {
        return $this->model->with(['bacLop.bacNganh'])->find($id);
    }

    public function create(array $data): BacBo
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $bacBo = $this->findById($id);

        if (!$bacBo) {
            return false;
        }

        return $bacBo->update($data);
    }

    public function delete(int $id): bool
    {
        $bacBo = $this->findById($id);

        if (!$bacBo) {
            return false;
        }

        return $bacBo->delete();
    }

    public function isInUse(int $id): bool
    {
        $bacBo = $this->findById($id);

        if (!$bacBo) {
            return false;
        }

        return $bacBo->bacHo()->count() > 0;
    }

    public function searchByName(string $name): Collection
    {
        return $this->model->where(function($query) use ($name) {
            $query->where('ten_khoa_hoc', 'like', '%' . $name . '%')
                  ->orWhere('ten_tieng_viet', 'like', '%' . $name . '%');
        })->with(['bacLop.bacNganh'])->get();
    }

    public function getByBacLop(int $bacLopId): Collection
    {
        return $this->model->where('bac_lop_id', $bacLopId)
            ->with(['bacLop.bacNganh'])
            ->get();
    }
}
