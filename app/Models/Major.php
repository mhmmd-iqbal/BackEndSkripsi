<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'majors';

    protected $fillabel = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];
}
