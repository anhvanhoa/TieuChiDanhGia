<?php

namespace App\Services;

use App\Models\BacNganh;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BacNganhService
{
    protected $model;

    public function __construct(BacNganh $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function findById(int $id): ?BacNganh
    {
        return $this->model->find($id);
    }

    public function create(array $data): BacNganh
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $bacNganh = $this->findById($id);

        if (!$bacNganh) {
            return false;
        }

        return $bacNganh->update($data);
    }

    public function delete(int $id): bool
    {
        $bacNganh = $this->findById($id);

        if (!$bacNganh) {
            return false;
        }

        return $bacNganh->delete();
    }

    public function isInUse(int $id): bool
    {
        $bacNganh = $this->findById($id);

        if (!$bacNganh) {
            return false;
        }

        return $bacNganh->bacLop()->count() > 0;
    }

    public function searchByName(string $name): Collection
    {
        return $this->model->where(function ($query) use ($name) {
            $query->where('ten_khoa_hoc', 'like', '%' . $name . '%')
                ->orWhere('ten_tieng_viet', 'like', '%' . $name . '%');
        })->get();
    }

    public function getByPhanLoai(string $phanLoai): Collection
    {
        return $this->model->where('phan_loai', $phanLoai)->get();
    }

    public function getPhanLoaiChoices(): array
    {
        return BacNganh::getPhanLoaiChoices();
    }
}
