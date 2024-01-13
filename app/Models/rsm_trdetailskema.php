<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rsm_trdetailskema extends Model
{
    use HasFactory;

    protected $table = 'rsm_trdetailskema';
    protected $primaryKey = 'dtl_id';
    public $timestamps = false;
    protected $fillable = [
        'skm_id',
        'pro_id',
        'dtl_tanggal_mulai',
        'dtl_tanggal_berakhir',
        'dtl_total_peserta',
        'dtl_kompeten',
        'dtl_belum_kompeten',
        'dtl_tidak_hadir',
        'dtl_created_by',
        'dtl_created_date',
        'dtl_modif_by',
        'dtl_modif_date',
    ];

    public function skema()
    {
        return $this->belongsTo(rsm_msskema::class, 'skm_id', 'skm_id');
    }

    public function prodi()
    {
        return $this->belongsTo(rsm_msprodi::class, 'pro_id', 'pro_id');
    }
}
