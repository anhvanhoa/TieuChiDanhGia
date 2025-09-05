<?php

namespace App\Services;

use App\Models\LoaiVuonQuocGia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class LoaiVuonQuocGiaService
{
    protected $model;

    public function __construct(LoaiVuonQuocGia $model)
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

    public function findById(int $id): ?LoaiVuonQuocGia
    {
        return $this->model->find($id);
    }

    public function create(array $data): LoaiVuonQuocGia
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $loaiVuonQuocGia = $this->findById($id);

        if (!$loaiVuonQuocGia) {
            return false;
        }

        return $loaiVuonQuocGia->update($data);
    }

    public function delete(int $id): bool
    {
        $loaiVuonQuocGia = $this->findById($id);

        if (!$loaiVuonQuocGia) {
            return false;
        }

        return $loaiVuonQuocGia->delete();
    }

    public function isInUse(int $id): bool
    {
        $loaiVuonQuocGia = $this->findById($id);

        if (!$loaiVuonQuocGia) {
            return false;
        }

        return $loaiVuonQuocGia->vuonQuocGia()->count() > 0;
    }

    public function searchByName(string $name): Collection
    {
        return $this->model->where('ten_loai', 'like', '%' . $name . '%')
            ->get();
    }
}
