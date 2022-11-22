<?php

namespace Modules\Registration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailStream;

class Promotion extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'from_class', 'from_stream', 'to_class', 'to_stream', 'grad', 'student_id',
         'from_session', 'to_session', 'status'
    ];

    public function student()
    {
        return $this->belongsTo(AccountStudentDetail::class, 'student_id');
    }

    public function fc()
    {
        return $this->belongsTo(AccountSchoolDetailClass::class, 'from_class');
    }

    public function fs()
    {
        return $this->belongsTo(AccountSchoolDetailStream::class, 'from_stream');
    }

    public function ts()
    {
        return $this->belongsTo(AccountSchoolDetailStream::class, 'to_stream');
    }

    public function tc()
    {
        return $this->belongsTo(AccountSchoolDetailClass::class, 'to_class');
    }

    protected static function newFactory()
    {
        return \Modules\Registration\Database\factories\PromotionFactory::new();
    }


}
