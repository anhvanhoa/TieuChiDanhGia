<?php

namespace App\Services;

use App\Models\BacChi;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BacChiService
{
    protected $model;

    public function __construct(BacChi $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with(['bacHo.bacBo.bacLop.bacNganh'])->get();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with(['bacHo.bacBo.bacLop.bacNganh'])->paginate($perPage);
    }

    public function findById(int $id): ?BacChi
    {
        return $this->model->with(['bacHo.bacBo.bacLop.bacNganh'])->find($id);
    }

    public function create(array $data): BacChi
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $bacChi = $this->findById($id);

        if (!$bacChi) {
            return false;
        }

        return $bacChi->update($data);
    }

    public function delete(int $id): bool
    {
        $bacChi = $this->findById($id);

        if (!$bacChi) {
            return false;
        }

        return $bacChi->delete();
    }

    public function isInUse(int $id): bool
    {
        $bacChi = $this->findById($id);

        if (!$bacChi) {
            return false;
        }

        return $bacChi->dongVat()->count() > 0 || $bacChi->thucVat()->count() > 0;
    }

    public function searchByName(string $name): Collection
    {
        return $this->model->where(function($query) use ($name) {
            $query->where('ten_khoa_hoc', 'like', '%' . $name . '%')
                  ->orWhere('ten_tieng_viet', 'like', '%' . $name . '%');
        })->with(['bacHo.bacBo.bacLop.bacNganh'])->get();
    }

    public function getByBacHo(int $bacHoId): Collection
    {
        return $this->model->where('bac_ho_id', $bacHoId)
            ->with(['bacHo.bacBo.bacLop.bacNganh'])
            ->get();
    }
}
