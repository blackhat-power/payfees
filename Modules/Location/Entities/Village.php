<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Configuration\Entities\AccountSchoolDetail;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'post_code',
        'ward_id'
    ];
    
    public function wards(){
        return $this->belongsTo(Ward::class);
    }

    public function schools(){
        return $this->hasMany(AccountSchoolDetail::class);
    }
    

    protected static function newFactory()
    {
        return \Modules\Location\Database\factories\VillageFactory::new();
    }
}
