<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unitkerja extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    public function user()
    {
        return $this->hasMany(User::class, 'iduke');
    }
}
