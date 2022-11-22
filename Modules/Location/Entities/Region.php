<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'post_code',
        'zone_id',
        'descriptions'
    ];

    public function districts(){
        return $this->hasMany(District::class,'region_id');
    }

    public function wards()
    {
        
        return $this->hasManyThrough(Ward::class,District::class);

    }

    public function wardzsCount()
    {
        
        return $this->wards();

    }

    public function zone(){

        return $this->belongsTo(Zone::class);

    }

    public function getDistrictsCountAttribute(){
        return $this->districts->count('id');
    }

    public function getWardsCountAttribute(){
        return $this->districts[0]->wards;
    }



    // public function 
/* 
    public function getDistrictsAttribute(){
        return District
    } */
    
    protected static function newFactory()
    {
        return \Modules\Location\Database\factories\RegionFactory::new();
    }
}
