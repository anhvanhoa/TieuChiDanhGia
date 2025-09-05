<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacNganh extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'bac_nganh';
    protected $fillable = [
        'ten_khoa_hoc',
        'ten_tieng_viet',
        'phan_loai'
    ];

    // Relationships
    public function bacLop()
    {
        return $this->hasMany(BacLop::class, 'bac_nganh_id');
    }

    public const PHAN_LOAI_ANIMAL = 'animal';
    public const PHAN_LOAI_PLANT = 'plant';
    public const PHAN_LOAI_CHOICES = [
        self::PHAN_LOAI_ANIMAL,
        self::PHAN_LOAI_PLANT
    ];
    public static function getPhanLoaiChoices()
    {
        return [
            self::PHAN_LOAI_ANIMAL => 'Động vật',
            self::PHAN_LOAI_PLANT => 'Thực vật'
        ];
    }
    public function getPhanLoaiLabel($phanLoai)
    {
        return self::getPhanLoaiChoices()[$phanLoai];
    }
}
