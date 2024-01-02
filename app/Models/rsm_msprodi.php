<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rsm_msprodi extends Model
{
    use HasFactory;
    
    protected $table = 'rsm_msprodi';
    protected $primaryKey = 'pro_id';
    protected $fillable = [
        'pro_nama',
    ];

    public function detailsSkema()
    {
        return $this->hasMany(rsm_trdetailskema::class, 'pro_id', 'pro_id');
    }
}
