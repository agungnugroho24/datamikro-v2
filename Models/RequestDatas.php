<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDatas extends Model
{
    use HasFactory;

    public function files()
    {
        return $this->hasMany(RequestDataFile::class, 'request_data_id');
    }

    public function hasils()
    {
        return $this->hasMany(Hasil::class, 'request_data_id');
    }
}
