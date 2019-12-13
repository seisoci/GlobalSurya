<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matapelajaran extends Model
{
    protected $table = "matapelajaran";
    protected $primaryKey = 'id_matapelajaran';

    protected $fillable = [
        'mata_pelajaran'
    ];
}
