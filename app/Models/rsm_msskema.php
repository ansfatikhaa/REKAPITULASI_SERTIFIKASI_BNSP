<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rsm_msskema extends Model
{
    use HasFactory;

    protected $table = 'rsm_msskema';
    protected $primaryKey = 'skm_id';
    public $timestamps = false;
    protected $fillable = [
        'skm_nama',
        'skm_created_by',
        'skm_modif_by',
    ];

    public function details()
    {
        return $this->hasMany(rsm_trdetailskema::class, 'skm_id', 'skm_id');
    }
}
