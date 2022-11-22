<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    
}
