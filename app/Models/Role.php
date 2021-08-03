<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Manage;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function manages()
    {
        return $this->belongsToMany(Manage::class)->withPivot('read', 'add', 'update', 'delete');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
