<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSchoolBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'account_no',
        'account_school_detail_id'
    ];

    public function bank(){
        return $this->belongsTo(BankDetail::class);
    }

    public function school(){
        return $this->belongsTo(AccountSchoolDetail::class);
    }

    public $timestamps = false;
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\AccountSchoolBankDetailFactory::new();
    }
}
