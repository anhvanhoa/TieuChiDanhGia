<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThucVatAnh extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'thuc_vat_anh';
    protected $fillable = [
        'thuc_vat_id',
        'duong_dan',
        'duong_dan_thumb'
    ];

    // Relationships
    public function thucVat()
    {
        return $this->belongsTo(ThucVat::class, 'thuc_vat_id');
    }
}
