<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentFeeStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'category_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Accounts\Database\factories\StudentFeeStructureFactory::new();
    }
}
