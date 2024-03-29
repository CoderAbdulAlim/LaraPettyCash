<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewacName extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'actype_id',
    ];
}
