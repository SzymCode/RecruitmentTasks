<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $casts = [
        'tenancy_db_username' => 'encrypted',
        'tenancy_db_password' => 'encrypted',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'tenancy_db_username',
            'tenancy_db_password',
        ];
    }
}
