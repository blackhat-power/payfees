<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeMasterParticular extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'is_tuition_fee'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Accounts\Database\factories\FeeMasterParticularFactory::new();
    }
}
