<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresenceDetail extends Model{
    protected $fillable = [
        'presence_id',
        'nama',
        'jabatan',
        'asal_instansi',
        'tanda_tangan',
    ];

    public function presence(){
        return $this->belongsTo(Presence::class);
    }
}
