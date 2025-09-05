<?php

namespace App\Services;

use App\Models\BacLop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BacLopService
{
    protected $model;

    public function __construct(BacLop $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with('bacNganh')->get();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('bacNganh')->paginate($perPage);
    }

    public function findById(int $id): ?BacLop
    {
        return $this->model->with('bacNganh')->find($id);
    }

    public function create(array $data): BacLop
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $bacLop = $this->findById($id);

        if (!$bacLop) {
            return false;
        }

        return $bacLop->update($data);
    }

    public function delete(int $id): bool
    {
        $bacLop = $this->findById($id);

        if (!$bacLop) {
            return false;
        }

        return $bacLop->delete();
    }

    public function isInUse(int $id): bool
    {
        $bacLop = $this->findById($id);

        if (!$bacLop) {
            return false;
        }

        return $bacLop->bacBo()->count() > 0;
    }

    public function searchByName(string $name): Collection
    {
        return $this->model->where(function($query) use ($name) {
            $query->where('ten_khoa_hoc', 'like', '%' . $name . '%')
                  ->orWhere('ten_tieng_viet', 'like', '%' . $name . '%');
        })->with('bacNganh')->get();
    }

    public function getByBacNganh(int $bacNganhId): Collection
    {
        return $this->model->where('bac_nganh_id', $bacNganhId)
            ->with('bacNganh')
            ->get();
    }
}
