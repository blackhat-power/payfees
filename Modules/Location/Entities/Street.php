<?php

namespace Modules\Location\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Configuration\Entities\AccountSchoolDetail;

class Street extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ward_id',
        'school_id'
    ];

    public function school(){

        return $this->belongsTo(AccountSchoolDetail::class);

    }

    public $timestamps =  false;
    
    protected static function newFactory()
    {
        return \Modules\Location\Database\factories\StreetFactory::new();
    }
}
