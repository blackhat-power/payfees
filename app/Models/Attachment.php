<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = [
    'created_by',
    'path',
    'attachable_type',
    'attachable_id',
    'attachment_type',
    'name'
    ];


    public $timestamps = false;
}
