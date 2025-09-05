<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacHo extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'bac_ho';
    protected $fillable = [
        'bac_bo_id',
        'ten_khoa_hoc',
        'ten_tieng_viet'
    ];

    // Relationships
    public function bacBo()
    {
        return $this->belongsTo(BacBo::class, 'bac_bo_id');
    }

    public function bacChi()
    {
        return $this->hasMany(BacChi::class, 'bac_ho_id');
    }
}
