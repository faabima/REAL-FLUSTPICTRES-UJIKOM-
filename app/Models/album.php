<?php

namespace App\Models;

use App\Models\foto;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class album extends Model
{
    use HasFactory;
    protected $fillable = ['Nama_Album','deskripsi','users_id'];
     //untuk konek ke table
     protected $table = 'album';
     //nilai ke foto
     public function foto()
     {
        return $this->hasMany(foto::class,'album_id','id');
     }
     //nilai ke user
     public function users()
     {
        return $this->belongsTo(User::class,'users_id','id');
     }
}
