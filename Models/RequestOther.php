<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOther extends Model
{
    use HasFactory;

    public function datas()
    {
        return $this->hasMany(NotAvailable::class, 'request_other_id');
    }
}
