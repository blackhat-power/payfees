<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSchoolDetailFeeStructureItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_school_detail_fee_structure_id',
        'name',
        'installments',
        'currency_id',
        'exchange_rate',
        'amount'
    ];
    public function feeStructure(){
        
        return $this->belongsTo(AccountSchoolDetailFeeStructure::class);
    }
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\AccountSchoolDetailFeeStructureItemFactory::new();
    }
}
