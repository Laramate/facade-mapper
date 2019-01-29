<?php

namespace Laramate\FacadeMapper\Tests\Unit;

use Laramate\FacadeMapper\Tests\Mocks\MockFacade;
use Laramate\FacadeMapper\Tests\TestCase;

class FacadeMapperTest extends TestCase
{
    /**
     * Constructor test.
     *
     * @test
     */
    public function testConstructor()
    {
        $mock = MockFacade::make([
            'param1'      => 'value1',
            'secondParam' => 'value2',
            'third_param' => 'value3',
        ]);

        $this->assertEquals('value1', $mock->param1);
        $this->assertEquals('value2', $mock->secondParam);
        $this->assertEquals('value3', $mock->third_param);
    }
}
