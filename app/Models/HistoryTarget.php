<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTarget extends Model
{
    use HasFactory;

    protected $fillable = ['target_id', 'jumlah_tercapai', 'tanggal_tercapai', 'description', 'media'];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}

