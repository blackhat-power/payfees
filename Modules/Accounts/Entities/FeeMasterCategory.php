<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Configuration\Entities\AccountSchoolDetailClass;

class FeeMasterCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by'
    ];

    public function feeCategoryMasterClasses(){

        return $this->hasMany(FeeMasterCategoryClass::class,'fee_master_category_id');

    }

    public function getFeeStructures(){
        return $this->hasMany(FeeStructure::class,'category_id');
    }


    // public function classes(){

    //     return $this->hasMany(AccountSchoolDetailClass::class,'class_id');

    // }
    
    protected static function newFactory()
    {
        return \Modules\Accounts\Database\factories\FeeMasterCategoryFactory::new();
    }
}
