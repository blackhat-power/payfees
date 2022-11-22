<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSchoolDetailSeason extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_school_details_id',
        'start_date',
        'end_date',
        'name',
        'status'
    ];
    public function accountSchoolDetail(){
        return $this->belongsTo(AccountSchoolDetail::class,'account_school_details_id');
    }

    public function classes(){
        return $this->hasMany(AccountSchoolDetailClass::class);
    }

    public function semesters(){
        return $this->hasMany(Semester::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\AccountSchoolDetailSeasonFactory::new();
    }
}
