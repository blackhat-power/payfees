<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Registration\Entities\AccountStudentDetail;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'created_by',
    ];

    public function invoices(){
        return $this->hasMany(Invoice::class,'account_id');
    }

    public function students(){
        return $this->hasMany(AccountStudentDetail::class,'account_id');
    }
    public function schools(){
        return $this->hasMany(AccountSchoolDetail::class, 'account_id');
    }
  

}
