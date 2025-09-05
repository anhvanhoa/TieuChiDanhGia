<?php

namespace App\Services;

use App\Models\VuonQuocGia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class VuonQuocGiaService
{
    protected $model;

    public function __construct(VuonQuocGia $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with('loaiVuonQuocGia')->get();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('loaiVuonQuocGia')->paginate($perPage);
    }

    public function findById(int $id): ?VuonQuocGia
    {
        return $this->model->with('loaiVuonQuocGia')->find($id);
    }

    public function create(array $data): VuonQuocGia
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $vuonQuocGia = $this->findById($id);

        if (!$vuonQuocGia) {
            return false;
        }

        return $vuonQuocGia->update($data);
    }

    public function delete(int $id): bool
    {
        $vuonQuocGia = $this->findById($id);

        if (!$vuonQuocGia) {
            return false;
        }

        return $vuonQuocGia->delete();
    }

    public function isInUse(int $id): bool
    {
        $vuonQuocGia = $this->findById($id);

        if (!$vuonQuocGia) {
            return false;
        }

        // Kiểm tra các relationship có dữ liệu không
        $relationships = [
            'users',
            'apLucTacDong',
            'cauTrucRung',
            'dacTrungKieuHeSinhThai',
            'dienTichKieuHeSinhThai',
            'dienTichRungDatLamNghiep',
            'loaiDongVatNguyCap',
            'loaiMoiPhatHien',
            'loaiThucVatNguyCap',
            'mucDoNghiemTrongApLuc',
            'phamViAnhHuongApLuc',
            'phanBoLoaiDongVat',
            'phanBoLoaiThucVat',
            'ranSanHoCoBien',
            'soLuongQuanTheDongVat',
            'soLuongQuanTheThucVat',
            'taiSinhRung',
            'tanSuatBatGapDongVat',
            'tangTruongRung',
            'thanhPhanLoaiDongVat',
            'thanhPhanLoaiThucVat',
            'truLuongSinhKhoiCarbon'
        ];

        foreach ($relationships as $relationship) {
            if ($vuonQuocGia->$relationship()->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function searchByName(string $name): Collection
    {
        return $this->model->where('ten_vuon', 'like', '%' . $name . '%')
            ->with('loaiVuonQuocGia')
            ->get();
    }

    public function getByLoaiVuonQuocGia(int $loaiId): Collection
    {
        return $this->model->where('loai_vuon_quoc_gia_id', $loaiId)
            ->with('loaiVuonQuocGia')
            ->get();
    }

    public function getStatistics(): array
    {
        return [
            'total' => $this->model->count(),
            'by_loai' => $this->model->with('loaiVuonQuocGia')
                ->get()
                ->groupBy('loaiVuonQuocGia.ten_loai')
                ->map->count()
        ];
    }
}
