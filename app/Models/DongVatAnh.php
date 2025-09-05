<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DongVatAnh extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'dong_vat_anh';
    protected $fillable = [
        'dong_vat_id',
        'duong_dan',
        'duong_dan_thumb'
    ];

    // Relationships
    public function dongVat()
    {
        return $this->belongsTo(DongVat::class, 'dong_vat_id');
    }
}
