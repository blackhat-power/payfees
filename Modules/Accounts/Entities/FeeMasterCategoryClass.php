<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeMasterCategoryClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_master_category_id',
        'class_id'
    ];

    public $timestamps = false;


    public function feeCategory(){

        return $this->belongsTo(FeeMasterCategory::class);

    }
    
    protected static function newFactory()
    {
        return \Modules\Accounts\Database\factories\FeeMasterCategoryClassFactory::new();
    }
}
