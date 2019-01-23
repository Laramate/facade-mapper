<?php

namespace Laramate\FacadeMapper\Tests\Mocks;

use Laramate\FacadeMapper\Facades\Facade;

class MockFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MockClass::class;
    }
}
