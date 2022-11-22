<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'post_code',
        'region_id'
    ];
    
    public function region(){

        return $this->belongsTo(Region::class);
        
    }


        public function wards(){
            return $this->hasMany(Ward::class);
        }


    public function wardzsCount()
    {
        
        return $this->wards();

    }
  

    public function getWardsCountAttribute(){
        return $this->districts[0]->wards;
    }

    protected static function newFactory()
    {
        return \Modules\Location\Database\factories\DistrictFactory::new();
    }
}
