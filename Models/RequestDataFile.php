<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDataFile extends Model
{
    use HasFactory;

    public function requestData()
    {
        return $this->belongsTo(RequestDatas::class);
    }
}
