<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class datapesan extends Model
{
    use HasFactory;
    protected $table = 'datapesan';
    protected $fillable = [
        'username',
        'email',
        'pesan',
    ];
    //user
    // public function user()
    //     {
    //         return $this->belongsTo(User::class,'users_id','id');
    //     }
}
