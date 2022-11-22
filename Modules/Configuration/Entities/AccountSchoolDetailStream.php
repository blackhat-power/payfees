<?php

namespace Modules\Configuration\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSchoolDetailStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'account_school_detail_class_id',
        'stream_id'
    ];

    public function classes(){
        return $this->belongsTo(AccountSchoolDetailClass::class, 'account_school_detail_class_id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Configuration\Database\factories\AccountSchoolDetailStreamFactory::new();
    }
}
