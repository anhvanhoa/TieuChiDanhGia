<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpatialRefSys extends Model
{
    use HasFactory;

    protected $table = 'spatial_ref_sys';
    protected $fillable = [
        'srid',
        'auth_name',
        'auth_srid',
        'srtext',
        'proj4text'
    ];

    protected $casts = [
        'srid' => 'integer',
        'auth_srid' => 'integer',
    ];

    public $timestamps = false;
}
