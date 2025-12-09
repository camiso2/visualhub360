<?php

namespace App\Custom;

use app\Scope\CompanyScope;

trait HasCompanyScope
{
    protected static function bootHasCompanyScope()
    {
        static::addGlobalScope(new CompanyScope);
    }
}
