<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'post_code',
        'district_id',
        'descriptions'
    ];

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function villages(){
        return $this->hasMany(Village::class,'ward_id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Location\Database\factories\WardFactory::new();
    }
}
