<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'contact',
        'contactable_id',
        'contactable_type',
        'contact_type_id'
    ];
    
    public function contactable(){
        return $this->morphTo();
    }
}
