<?php

namespace App\Models;

use App\Models\User;
use App\Models\album;
use App\Models\likefoto;
use App\Models\komenfoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class foto extends Model
{
    use HasFactory;
    protected $table = 'foto';
    protected $fillable = [
    'judul_foto',
    'deksripsi_foto',
    'lokasi_file',
    'users_id',
    'album_id',
    ];
    //relasi ke likefoto
    public function likefoto()
    {
        return $this->hasMany(likefoto::class,'foto_id','id');
    }
    //relasi ke komenfoto
    public function komenfoto()
    {
        return $this->hasMany(komenfoto::class,'foto_id','id');
    }
    //relasi nilai balik ke album
    public function album()
    {
        return $this->belongsTo(album::class,'album_id','id');
    }
    //relasi nilai balik ke user
    public function users()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
        //relasi nilai balik ke user
        public function laporan()
        {
            return $this->belongsTo(laporan::class,'foto_id','id');
        }
}
  