<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory; 

    protected $fillable = [
        'app_name',
        'logo',
        'user_name',
        'email'
    ];
}
