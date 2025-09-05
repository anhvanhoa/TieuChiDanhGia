<?php

namespace App\Services;

use App\Models\DongVat;
use App\Models\DongVatAnh;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class DongVatService
{
    protected $model;
    protected $imageService;

    public function __construct(DongVat $model, ImageService $imageService)
    {
        $this->model = $model;
        $this->imageService = $imageService;
    }

    public function getAll(): Collection
    {
        return $this->model->with(['bacChi.bacHo.bacBo.bacLop.bacNganh'])->get();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with(['bacChi.bacHo.bacBo.bacLop.bacNganh'])->paginate($perPage);
    }

    public function findById(int $id): ?DongVat
    {
        return $this->model->with(['bacChi.bacHo.bacBo.bacLop.bacNganh'])->find($id);
    }

    public function create(array $data): DongVat
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $dongVat = $this->findById($id);

        if (!$dongVat) {
            return false;
        }

        return $dongVat->update($data);
    }

    public function delete(int $id): bool
    {
        $dongVat = $this->findById($id);

        if (!$dongVat) {
            return false;
        }

        // Xóa tất cả hình ảnh trước khi xóa động vật
        $this->deleteAllImages($id);

        return $dongVat->delete();
    }

    public function isInUse(int $id): bool
    {
        $dongVat = $this->findById($id);

        if (!$dongVat) {
            return false;
        }

        // Kiểm tra các relationship có dữ liệu không
        $relationships = [
            'dongVatAnh',
            'loaiDongVatNguyCap',
            'phanBoLoaiDongVat',
            'soLuongQuanTheDongVat',
            'tanSuatBatGapDongVat'
        ];

        foreach ($relationships as $relationship) {
            if ($dongVat->$relationship()->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function searchByName(string $name): Collection
    {
        return $this->model->where(function($query) use ($name) {
            $query->where('ten_khoa_hoc', 'like', '%' . $name . '%')
                  ->orWhere('ten_tieng_viet', 'like', '%' . $name . '%');
        })->with(['bacChi.bacHo.bacBo.bacLop.bacNganh'])->get();
    }

    public function getByBacChi(int $bacChiId): Collection
    {
        return $this->model->where('bac_chi_id', $bacChiId)
            ->with(['bacChi.bacHo.bacBo.bacLop.bacNganh'])
            ->get();
    }

    public function getBySachDo(string $sachDo): Collection
    {
        return $this->model->where('sach_do', $sachDo)
            ->with(['bacChi.bacHo.bacBo.bacLop.bacNganh'])
            ->get();
    }

    public function getByIucn(string $iucn): Collection
    {
        return $this->model->where('iucn', $iucn)
            ->with(['bacChi.bacHo.bacBo.bacLop.bacNganh'])
            ->get();
    }

    public function getStatistics(): array
    {
        return [
            'total' => $this->model->count(),
            'by_sach_do' => $this->model->selectRaw('sach_do, count(*) as count')
                ->groupBy('sach_do')
                ->pluck('count', 'sach_do'),
            'by_iucn' => $this->model->selectRaw('iucn, count(*) as count')
                ->groupBy('iucn')
                ->pluck('count', 'iucn'),
            'by_dac_huu' => $this->model->selectRaw('dac_huu, count(*) as count')
                ->groupBy('dac_huu')
                ->pluck('count', 'dac_huu')
        ];
    }

    /**
     * Thêm hình ảnh cho động vật
     */
    public function addImage(int $dongVatId, UploadedFile $file): array
    {
        $uploadResult = null;

        try {
            $dongVat = $this->findById($dongVatId);
            if (!$dongVat) {
                return ['success' => false, 'error' => 'Động vật không tồn tại'];
            }

            $uploadResult = $this->imageService->uploadImage($file, 'images/dong-vat');
            if (!$uploadResult['success']) {
                return $uploadResult;
            }

            // Thử tạo record trong database
            $dongVatAnh = DongVatAnh::create([
                'dong_vat_id' => $dongVatId,
                'duong_dan' => $uploadResult['path'],
                'duong_dan_thumb' => $uploadResult['thumb_path']
            ]);

            return [
                'success' => true,
                'image' => $dongVatAnh,
                'url' => $uploadResult['url'],
                'thumb_url' => $uploadResult['thumb_url']
            ];

        } catch (\Exception $e) {
            // Rollback: xóa ảnh đã upload nếu lưu DB thất bại
            if ($uploadResult && $uploadResult['success']) {
                $this->imageService->rollbackUpload($uploadResult);
            }

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Thêm hình ảnh từ file path
     */
    public function addImageFromPath(int $dongVatId, string $filePath): array
    {
        try {
            $dongVat = $this->findById($dongVatId);
            if (!$dongVat) {
                return ['success' => false, 'error' => 'Động vật không tồn tại'];
            }

            $result = $this->imageService->uploadFromPath($filePath, 'images/dong-vat');
            if (!$result['success']) {
                return $result;
            }

            $dongVatAnh = DongVatAnh::create([
                'dong_vat_id' => $dongVatId,
                'duong_dan' => $result['path'],
                'duong_dan_thumb' => $result['thumb_path']
            ]);

            return [
                'success' => true,
                'image' => $dongVatAnh,
                'url' => $result['url'],
                'thumb_url' => $result['thumb_url']
            ];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Xóa hình ảnh
     */
    public function deleteImage(int $imageId): array
    {
        try {
            $dongVatAnh = DongVatAnh::find($imageId);
            if (!$dongVatAnh) {
                return ['success' => false, 'error' => 'Hình ảnh không tồn tại'];
            }

            // Xóa file từ storage
            $this->imageService->deleteImage($dongVatAnh->duong_dan, $dongVatAnh->duong_dan_thumb);

            // Xóa record từ database
            $dongVatAnh->delete();

            return ['success' => true];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Lấy danh sách hình ảnh của động vật
     */
    public function getImages(int $dongVatId): Collection
    {
        return DongVatAnh::where('dong_vat_id', $dongVatId)->get();
    }

    /**
     * Thêm nhiều hình ảnh với rollback
     */
    public function addMultipleImages(int $dongVatId, array $files): array
    {
        $uploadResults = [];
        $successCount = 0;

        try {
            $dongVat = $this->findById($dongVatId);
            if (!$dongVat) {
                return ['success' => false, 'error' => 'Động vật không tồn tại'];
            }

            // Upload tất cả ảnh trước
            foreach ($files as $file) {
                $result = $this->imageService->uploadImage($file, 'images/dong-vat');
                $uploadResults[] = $result;

                if (!$result['success']) {
                    // Nếu có ảnh upload thất bại, rollback tất cả ảnh đã upload
                    $this->imageService->rollbackMultipleUploads($uploadResults);
                    return ['success' => false, 'error' => 'Upload ảnh thất bại: ' . $result['error']];
                }
            }

            // Lưu tất cả vào database
            $savedImages = [];
            foreach ($uploadResults as $result) {
                try {
                    $dongVatAnh = DongVatAnh::create([
                        'dong_vat_id' => $dongVatId,
                        'duong_dan' => $result['path'],
                        'duong_dan_thumb' => $result['thumb_path']
                    ]);
                    $savedImages[] = $dongVatAnh;
                    $successCount++;
                } catch (\Exception $e) {
                    // Nếu lưu DB thất bại, rollback tất cả ảnh đã upload
                    $this->imageService->rollbackMultipleUploads($uploadResults);
                    return ['success' => false, 'error' => 'Lưu database thất bại: ' . $e->getMessage()];
                }
            }

            return [
                'success' => true,
                'count' => $successCount,
                'images' => $savedImages,
                'message' => "Đã thêm thành công {$successCount} hình ảnh"
            ];

        } catch (\Exception $e) {
            // Rollback tất cả ảnh đã upload
            $this->imageService->rollbackMultipleUploads($uploadResults);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Xóa tất cả hình ảnh của động vật
     */
    public function deleteAllImages(int $dongVatId): bool
    {
        try {
            $images = $this->getImages($dongVatId);

            foreach ($images as $image) {
                $this->imageService->deleteImage($image->duong_dan, $image->duong_dan_thumb);
                $image->delete();
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
