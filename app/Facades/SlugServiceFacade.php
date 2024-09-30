<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SlugServiceFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return \App\Services\SlugService::class;
    }
}
