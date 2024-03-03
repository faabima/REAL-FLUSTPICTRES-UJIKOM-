<?php

namespace App\Models;

use App\Models\foto;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class laporan extends Model
{
    use HasFactory;
    protected $table = 'laporan' ;
    protected $fillable = [
        'users_id',
        'foto_id',
        'alasan',
        'status',
    ];
        //relasi nilai balik ke foto
        public function foto()
        {
            return $this->belongsTo(foto::class,'foto_id','id');
        }
        //relasi nilai balik ke user
        public function user()
        {
            return $this->belongsTo(User::class,'users_id','id');
        }
}

