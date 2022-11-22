<?php

namespace App\Models;

use Illuminate\Support\Facades\DB as FacadesDB;


use Spatie\Multitenancy\Models\Tenant;

class CustomTenantModel extends Tenant
{
    protected $fillable =[
        'database',
        'name',
        'domain'
    ];

    protected $table = 'tenants';
}
