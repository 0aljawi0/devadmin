<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'value' => 'array'
    ];

    public function getValueAttribute($value)
    {
        return json_decode($value);
    }
}
