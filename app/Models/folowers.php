<?php

namespace App\Models;

use App\Models\foto;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class folowers extends Model
{
    use HasFactory;
    protected $fillable = ['users_id','id_following'];
    //koneksi ke table
    protected $table = 'folowers';
    //nilai balik ke foto
    public function foto()
    {
        return $this->belongsTo(foto::class,'foto_id','id');
    }
    //nilai balik ke user
    public function users()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
}
