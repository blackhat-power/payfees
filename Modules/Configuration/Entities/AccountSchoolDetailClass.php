<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registration\Entities\AccountStudentDetail;

class AccountSchoolDetailClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'streams',
        'short_form',
        'account_school_detail_season_id'
    ];

    public function accountSchoolDetail(){
        return $this->belongsTo(AccountSchoolDetail::class);
    }
    public function seasons(){
        return $this->belongsTo(AccountSchoolDetailSeason::class, 'account_school_detail_season_id');
    }
    public function streams(){

        return $this->hasMany(AccountSchoolDetailStream::class, 'account_school_detail_class_id');
        
    }
    public function students(){
        return $this->hasMany(AccountStudentDetail::class,'account_school_details_class_id');
    }

    public function feeStructures(){
        return $this->hasMany(AccountSchoolDetailFeeStructure::class,'account_school_details_class_id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\AccountSchoolDetailClassFactory::new();
    }
}
