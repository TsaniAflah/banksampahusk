<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetoranItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setoran()
    {
        return $this->belongsTo(Setoran::class, 'setoran_id', 'id');
    }

    public function jenis_sampah()
    {
        return $this->belongsTo(JenisSampah::class, 'jenis_sampah_id', 'id');
    }
}
