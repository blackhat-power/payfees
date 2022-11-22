<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\StreamFactory::new();
    }
}
