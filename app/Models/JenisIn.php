<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisIn extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'icon', 'color', 'title', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashIns()
    {
        return $this->hasMany(CashIn::class);
    }
}
