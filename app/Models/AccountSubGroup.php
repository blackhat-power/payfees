<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSubGroup extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'account_group_id'

    ];
}
