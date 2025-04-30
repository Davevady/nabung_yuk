<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tingkat_id',
        'title',
        'jumlah_target',
        'jumlah_tercapai',
        'sisa_target',
        'tanggal_target',
        'description',
        'media'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }

    public function historyTargets()
    {
        return $this->hasMany(HistoryTarget::class);
    }
}
