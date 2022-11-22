<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSchoolDetailCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'school_id'
    ];

    public function school(){

        return $this->belongsTo(AccountSchoolDetail::class);

    }

    public $timestamps = false;
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\AccountSchoolDetailCategoryFactory::new();
    }
}
