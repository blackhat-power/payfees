<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSchoolDetailFeeStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'created_by',
        'account_school_details_class_id',
        'fee_group_id',
        'installments',
        'season_id'
    ];

    public function items(){
        return $this->hasMany(AccountSchoolDetailFeeStructureItem::class);
    }

    public function classes(){
        return $this->belongsTo(AccountSchoolDetailClass::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\AccountSchoolDetailFeeStructureFactory::new();
    }
}
