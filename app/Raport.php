<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Kelas;
use App\Matapelajaran;

class Raport extends Model
{

    protected $table = "raport";
    protected $primaryKey = 'id_raport';


    protected $fillable = [
        'tahun'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];


    public function guru()
    {
        return $this->belongsTo(User::class, 'id_guru');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function matapelajaran()
    {
        return $this->hasMany(Matapelajaran::class);
    }
}
