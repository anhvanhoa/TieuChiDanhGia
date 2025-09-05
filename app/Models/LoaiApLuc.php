<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiApLuc extends Model
{
    use HasFactory;

    protected $table = 'loai_ap_luc';
    protected $fillable = [
        'ten_ap_luc'
    ];

    // Relationships
    public function apLucTacDong()
    {
        return $this->hasMany(ApLucTacDong::class, 'loai_ap_luc_id');
    }
}
