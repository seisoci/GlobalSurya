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

    public function raport()
    {
    	return $this->belongsTo(Raport::class, 'id_matapelajaran');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'id_matapelajaran');
    }
}
