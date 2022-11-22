<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
                



                ];
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\CategoryItemFactory::new();
    }
}
