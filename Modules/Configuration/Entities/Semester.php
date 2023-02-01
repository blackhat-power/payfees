<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Accounts\Entities\FeeReminderSetting;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'descriptions',
        'start_date',
        'end_date',
        'account_school_detail_season_id'
    ];
    
    public function seasons(){
        return $this->belongsTo(AccountSchoolDetailSeason::class);
    }
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\SemesterFactory::new();
    }


    public function reminder(){

        return $this->hasMany(FeeReminderSetting::class, 'semester_id');

    }
}
