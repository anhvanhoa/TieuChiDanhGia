<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacBo extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'bac_bo';
    protected $fillable = [
        'bac_lop_id',
        'ten_khoa_hoc',
        'ten_tieng_viet'
    ];

    // Relationships
    public function bacLop()
    {
        return $this->belongsTo(BacLop::class, 'bac_lop_id');
    }

    public function bacHo()
    {
        return $this->hasMany(BacHo::class, 'bac_bo_id');
    }
}
