<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\CategoryFactory::new();
    }
}
