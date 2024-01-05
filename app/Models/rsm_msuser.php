<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rsm_msuser extends Model
{
    public $timestamps = false;
    protected $table = 'rsm_msuser';
    protected $primaryKey = 'usr_id';

    protected $fillable = [
        'usr_id',
        'usr_nama',
        'usr_username',
        'usr_password',
        'usr_email',
        'usr_role',
    ];
}
