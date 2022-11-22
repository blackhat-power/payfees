<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;


    protected $fillable = [
        'code',
        'account_name',
        'currency',
        'account_group_id'
    ];
}
