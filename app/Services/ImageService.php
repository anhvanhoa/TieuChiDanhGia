<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Imagick\Driver;


class ImageService
{
    protected $disk = 'public';
    protected $maxWidth = 1200;
    protected $maxHeight = 1200;
    protected $thumbWidth = 300;
    protected $thumbHeight = 300;
    protected $quality = 85;

    protected $imageManager;

    public function __construct()
    {
        $this->ensureDirectoriesExist();
        $this->imageManager = new ImageManager(new Driver());
    }

    public function uploadImage(UploadedFile $file, string $folder = 'images'): array
    {
        try {
            // Validate file
            $this->validateImage($file);

            // Tạo tên file unique
            $filename = $this->generateFilename($file);

            // Đường dẫn lưu trữ
            $path = "$folder/$filename";
            $thumbPath = "$folder/thumbs/$filename";

            $image = $this->imageManager->read($file);
            $image->scaleDown($this->maxWidth, $this->maxHeight);

            $imageData = $image->toJpeg($this->quality);
            Storage::disk($this->disk)->put($path, $imageData);

            // Tạo thumbnail
            $thumbImage = $this->imageManager->read($file);
            $thumbImage->cover($this->thumbWidth, $this->thumbHeight);
            $thumbData = $thumbImage->toJpeg($this->quality);
            Storage::disk($this->disk)->put($thumbPath, $thumbData);

            return [
                'success' => true,
                'path' => $path,
                'thumb_path' => $thumbPath,
                'filename' => $filename,
                'url' => $this->getImageUrl($path),
                'thumb_url' => $this->getThumbUrl($thumbPath)
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function uploadFromPath(string $filePath, string $folder = 'images'): array
    {
        try {
            if (!file_exists($filePath)) {
                throw new \Exception('File không tồn tại');
            }

            // Validate file
            $this->validateImageFromPath($filePath);

            // Tạo tên file
            $filename = $this->generateFilename(null, pathinfo($filePath, PATHINFO_EXTENSION));
            $path = $folder . '/' . $filename;
            $thumbPath = $folder . '/thumbs/' . $filename;

            // Xử lý ảnh gốc
            $image = $this->imageManager->read($filePath);
            $image->scaleDown($this->maxWidth, $this->maxHeight);

            $processedData = $image->toJpeg($this->quality);
            Storage::disk($this->disk)->put($path, $processedData);

            // Tạo thumbnail
            $thumbImage = $this->imageManager->read($filePath);
            $thumbImage->cover($this->thumbWidth, $this->thumbHeight);
            $thumbData = $thumbImage->toJpeg($this->quality);
            Storage::disk($this->disk)->put($thumbPath, $thumbData);

            return [
                'success' => true,
                'path' => $path,
                'thumb_path' => $thumbPath,
                'filename' => $filename,
                'url' => $this->getImageUrl($path),
                'thumb_url' => $this->getThumbUrl($thumbPath)
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function deleteImage(string $path, ?string $thumbPath = null): bool
    {
        try {
            if (Storage::disk($this->disk)->exists($path)) {
                Storage::disk($this->disk)->delete($path);
            }

            if ($thumbPath && Storage::disk($this->disk)->exists($thumbPath)) {
                Storage::disk($this->disk)->delete($thumbPath);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function rollbackUpload(array $uploadResult): bool
    {
        if (!$uploadResult['success']) {
            return true;
        }

        try {
            $deleted = true;

            if (isset($uploadResult['path'])) {
                $deleted = $deleted && $this->deleteImage($uploadResult['path']);
            }

            if (isset($uploadResult['thumb_path'])) {
                $deleted = $deleted && $this->deleteImage($uploadResult['thumb_path']);
            }

            return $deleted;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function rollbackMultipleUploads(array $uploadResults): bool
    {
        $allDeleted = true;

        foreach ($uploadResults as $result) {
            if (!$this->rollbackUpload($result)) {
                $allDeleted = false;
            }
        }

        return $allDeleted;
    }

    protected function validateImage(UploadedFile $file): void
    {
        // Kiểm tra loại file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            throw new \Exception('Định dạng file không được hỗ trợ. Chỉ chấp nhận: JPG, PNG, GIF, WEBP');
        }

        // Kiểm tra kích thước file (5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            throw new \Exception('Kích thước file quá lớn. Tối đa 5MB');
        }

        // Kiểm tra kích thước ảnh
        $imageInfo = getimagesize($file->getPathname());
        if (!$imageInfo) {
            throw new \Exception('File không phải là hình ảnh hợp lệ');
        }

        if ($imageInfo[0] > 4000 || $imageInfo[1] > 4000) {
            throw new \Exception('Kích thước ảnh quá lớn. Tối đa 4000x4000 pixels');
        }
    }

    protected function validateImageFromPath(string $filePath): void
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $mimeType = mime_content_type($filePath);

        if (!in_array($mimeType, $allowedTypes)) {
            throw new \Exception('Định dạng file không được hỗ trợ. Chỉ chấp nhận: JPG, PNG, GIF, WEBP');
        }

        if (filesize($filePath) > 5 * 1024 * 1024) {
            throw new \Exception('Kích thước file quá lớn. Tối đa 5MB');
        }

        $imageInfo = getimagesize($filePath);
        if (!$imageInfo) {
            throw new \Exception('File không phải là hình ảnh hợp lệ');
        }

        if ($imageInfo[0] > 4000 || $imageInfo[1] > 4000) {
            throw new \Exception('Kích thước ảnh quá lớn. Tối đa 4000x4000 pixels');
        }
    }

    protected function generateFilename(?UploadedFile $file = null, ?string $extension = null): string
    {
        $extension = $extension ?: ($file ? $file->getClientOriginalExtension() : 'jpg');
        return Str::uuid() . '.' . $extension;
    }

    protected function ensureDirectoriesExist(): void
    {
        $directories = [
            'images',
            'images/thumbs',
            'images/dong-vat',
            'images/dong-vat/thumbs',
            'images/thuc-vat',
            'images/thuc-vat/thumbs'
        ];

        foreach ($directories as $directory) {
            if (!Storage::disk($this->disk)->exists($directory)) {
                Storage::disk($this->disk)->makeDirectory($directory);
            }
        }
    }

    public function getImageUrl(string $path): string
    {
        return asset("storage/$path");
    }

    public function getThumbUrl(string $thumbPath): string
    {
        return asset("storage/$thumbPath");
    }

    public function fileExists(string $path): bool
    {
        return Storage::disk($this->disk)->exists($path);
    }

    public function getFileInfo(string $path): array
    {
        if (!$this->fileExists($path)) {
            return [];
        }

        return [
            'size' => Storage::disk($this->disk)->size($path),
            'last_modified' => Storage::disk($this->disk)->lastModified($path),
            'mime_type' => mime_content_type(Storage::disk($this->disk)->path($path))
        ];
    }
}
