<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacLop extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'bac_lop';
    protected $fillable = [
        'bac_nganh_id',
        'ten_khoa_hoc',
        'ten_tieng_viet'
    ];

    // Relationships
    public function bacNganh()
    {
        return $this->belongsTo(BacNganh::class, 'bac_nganh_id');
    }

    public function bacBo()
    {
        return $this->hasMany(BacBo::class, 'bac_lop_id');
    }
}
