<?php

namespace Modules\Configuration\Entities;

use App\Models\Account;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Location\Entities\Street;
use Modules\Location\Entities\Village;
use Modules\Location\Entities\Ward;
use Modules\Registration\Entities\AccountStudentDetail;

class AccountSchoolDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'ownership',
        'district',
        'registration_number',
        'logo',
        'bank_id',
        'current_session'
        
    ];

    public function seasons()
    {
        return $this->hasMany(AccountSchoolDetailSeason::class,'account_school_details_id');
    }
    public function classes(){
        return $this->hasMany(AccountSchoolDetailClass::class,'account_school_details_id');
    }

 /*    public function banks(){
        return $this->belongsToMany(BankDetail::class);
    } */

    public function bankDetail(){
        return $this->hasOne(AccountSchoolBankDetail::class,'account_school_detail_id');
    }

    public function schoolCategories(){
        return $this->hasMany(AccountSchoolDetailCategory::class,'school_id');
    }

    public function street(){
        return $this->hasOne(Street::class,'school_id');
    }

    

    public function students(){
        return $this->hasMany(AccountStudentDetail::class,'account_school_details_id');
    }
    public function seasonsClasses(){
        return $this->hasManyThrough(AccountSchoolDetailSeason::class,AccountSchoolDetailClass::class);
    }

    public function newAccounts(){
        return $this->belongsTo(Account::class);
    }

    public function villages(){
        return $this->belongsTo(Village::class,'village_id');
    }

    public function hasWards(){
        return $this->hasOneThrough(Ward::class, Village::class);
    }

    public function contactable(){
        return $this->morphMany(Contact::class,'contactable');
    }
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\AccountSchoolDetailFactory::new();
    }
}
