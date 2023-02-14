<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registration\Entities\AccountStudentDetail;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'class_id',
        'category_type',
        'amount',
        'description',
        'created_by',
        'particular_id',
        'student_id'
    ];

    public function feeItems(){
        return $this->hasMany(FeeStructureItem::class,'fee_structure_id');
    }

    public function masterCategory(){
        return $this->belongsTo(FeeMasterCategory::class);
    }

    public function students(){
        return $this->belongsTo(AccountStudentDetail::class);
    }

   

    public $timestamps = false;
    
    protected static function newFactory()
    {
        return \Modules\Accounts\Database\factories\FeeStructureFactory::new();
    }
}
