<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bank_name',
        'account_number',
        'swift_code',
        'location'
    ];


    public function schools(){
        
        return $this->hasMany(AccountSchoolDetail::class,'bank_id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\BankDetailFactory::new();
    }
}
