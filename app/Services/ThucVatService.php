<?php

namespace App\Services;

use App\Models\ThucVat;
use App\Models\ThucVatAnh;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class ThucVatService
{
    protected $model;
    protected $imageService;

    public function __construct(ThucVat $model, ImageService $imageService)
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

    public function findById(int $id): ?ThucVat
    {
        return $this->model->with(['bacChi.bacHo.bacBo.bacLop.bacNganh'])->find($id);
    }

    public function create(array $data): ThucVat
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $thucVat = $this->findById($id);

        if (!$thucVat) {
            return false;
        }

        return $thucVat->update($data);
    }

    public function delete(int $id): bool
    {
        $thucVat = $this->findById($id);

        if (!$thucVat) {
            return false;
        }

        // Xóa tất cả hình ảnh trước khi xóa thực vật
        $this->deleteAllImages($id);

        return $thucVat->delete();
    }

    public function isInUse(int $id): bool
    {
        $thucVat = $this->findById($id);

        if (!$thucVat) {
            return false;
        }

        // Kiểm tra các relationship có dữ liệu không
        $relationships = [
            'thucVatAnh',
            'loaiThucVatNguyCap',
            'phanBoLoaiThucVat',
            'soLuongQuanTheThucVat'
        ];

        foreach ($relationships as $relationship) {
            if ($thucVat->$relationship()->count() > 0) {
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

    public function getByDacHuu(string $dacHuu): Collection
    {
        return $this->model->where('dac_huu', $dacHuu)
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
     * Thêm hình ảnh cho thực vật
     */
    public function addImage(int $thucVatId, UploadedFile $file): array
    {
        $uploadResult = null;

        try {
            $thucVat = $this->findById($thucVatId);
            if (!$thucVat) {
                return ['success' => false, 'error' => 'Thực vật không tồn tại'];
            }

            $uploadResult = $this->imageService->uploadImage($file, 'images/thuc-vat');
            if (!$uploadResult['success']) {
                return $uploadResult;
            }

            // Thử tạo record trong database
            $thucVatAnh = ThucVatAnh::create([
                'thuc_vat_id' => $thucVatId,
                'duong_dan' => $uploadResult['path'],
                'duong_dan_thumb' => $uploadResult['thumb_path']
            ]);

            return [
                'success' => true,
                'image' => $thucVatAnh,
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
    public function addImageFromPath(int $thucVatId, string $filePath): array
    {
        try {
            $thucVat = $this->findById($thucVatId);
            if (!$thucVat) {
                return ['success' => false, 'error' => 'Thực vật không tồn tại'];
            }

            $result = $this->imageService->uploadFromPath($filePath, 'images/thuc-vat');
            if (!$result['success']) {
                return $result;
            }

            $thucVatAnh = ThucVatAnh::create([
                'thuc_vat_id' => $thucVatId,
                'duong_dan' => $result['path'],
                'duong_dan_thumb' => $result['thumb_path']
            ]);

            return [
                'success' => true,
                'image' => $thucVatAnh,
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
            $thucVatAnh = ThucVatAnh::find($imageId);
            if (!$thucVatAnh) {
                return ['success' => false, 'error' => 'Hình ảnh không tồn tại'];
            }

            // Xóa file từ storage
            $this->imageService->deleteImage($thucVatAnh->duong_dan, $thucVatAnh->duong_dan_thumb);

            // Xóa record từ database
            $thucVatAnh->delete();

            return ['success' => true];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Lấy danh sách hình ảnh của thực vật
     */
    public function getImages(int $thucVatId): Collection
    {
        return ThucVatAnh::where('thuc_vat_id', $thucVatId)->get();
    }

    /**
     * Thêm nhiều hình ảnh với rollback
     */
    public function addMultipleImages(int $thucVatId, array $files): array
    {
        $uploadResults = [];
        $successCount = 0;

        try {
            $thucVat = $this->findById($thucVatId);
            if (!$thucVat) {
                return ['success' => false, 'error' => 'Thực vật không tồn tại'];
            }

            // Upload tất cả ảnh trước
            foreach ($files as $file) {
                $result = $this->imageService->uploadImage($file, 'images/thuc-vat');
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
                    $thucVatAnh = ThucVatAnh::create([
                        'thuc_vat_id' => $thucVatId,
                        'duong_dan' => $result['url'],
                        'duong_dan_thumb' => $result['thumb_url']
                    ]);
                    $savedImages[] = $thucVatAnh;
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
     * Xóa tất cả hình ảnh của thực vật
     */
    public function deleteAllImages(int $thucVatId): bool
    {
        try {
            $images = $this->getImages($thucVatId);

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
