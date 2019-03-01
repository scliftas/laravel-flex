<?php

namespace Shaunclift\Flex;

use Illuminate\Support\Facades\Facade;

class FlexFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flex';
    }
}