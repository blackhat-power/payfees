<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Configuration\Entities\Semester;

class FeeReminderSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_category_id',
        'semester',
        'amount',
        'class_id',
        'counter',
        'academic_year_id',
        'period_btn_reminders'
    ];

    public function semester(){

        return $this->belongsTo(Semester::class);
    }

    // public function getSemesterAttribute(){

    //     return $this->semester();
    // }
    
    protected static function newFactory()
    {
        return \Modules\Accounts\Database\factories\FeeReminderSettingFactory::new();
    }
}
