<?php

namespace App\Models;

use App\Models\foto;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class komenfoto extends Model
{
    use HasFactory;
    protected $fillable = ['foto_id','users_id','isi_komentar'];
    //konek ke table
    protected $table = 'komenfoto';
    //nilai balik ke user 
    public function users()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
    //nilai balik ke foto
    public function foto()
    {
        return $this->belongsTo(foto::class,'foto_id','id');
    }

}
