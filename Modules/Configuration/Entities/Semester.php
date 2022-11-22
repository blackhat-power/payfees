<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
