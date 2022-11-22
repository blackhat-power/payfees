<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'

                    ];
    
    public function regions(){
        return $this->hasMany(Region::class);
    }


}
