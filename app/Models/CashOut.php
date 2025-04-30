<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashOut extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jenis_out_id', 'title', 'jumlah', 'media', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisOut()
    {
        return $this->belongsTo(JenisOut::class);
    }
}
