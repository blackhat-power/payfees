<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registration\Entities\AccountStudentDetail;

class FeeStructureItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_structure_id',
        'student_id',
    ];


    public function feeStructure(){

        return $this->belongsTo(FeeStructure::class);
    }

    public function students(){
        return $this->belongsTo(AccountStudentDetail::class,'student_id');
    }

    // public function getStudentTotalAttribute(){


        

    // }

    public $timestamps = false;
    
    protected static function newFactory()
    {
        return \Modules\Accounts\Database\factories\FeeStructureItemFactory::new();
    }
}
