<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $primaryKey = 'id_absen';
    protected $table = "absen";

    protected $fillable = [
        'id_users', 'ganjilsakit', 'ganjilizin', 'ganjilalpha', 'genapsakit', 'genapizin', 'genapalpha'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
