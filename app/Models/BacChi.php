<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacChi extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'bac_chi';
    protected $fillable = [
        'bac_ho_id',
        'ten_khoa_hoc',
        'ten_tieng_viet'
    ];

    // Relationships
    public function bacHo()
    {
        return $this->belongsTo(BacHo::class, 'bac_ho_id');
    }

    public function dongVat()
    {
        return $this->hasMany(DongVat::class, 'bac_chi_id');
    }

    public function thucVat()
    {
        return $this->hasMany(ThucVat::class, 'bac_chi_id');
    }
}
