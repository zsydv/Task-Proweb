<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtmCash extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'denomination',
        'count'
    ];
}
