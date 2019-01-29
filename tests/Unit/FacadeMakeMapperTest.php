<?php

namespace Laramate\FacadeMapper\Tests\Unit;

use Laramate\FacadeMapper\Tests\Mocks\MockMakeFacade;
use Laramate\FacadeMapper\Tests\TestCase;

class FacadeMakeMapperTest extends TestCase
{
    /**
     * Arguments in order test.
     *
     * @test
     */
    public function testArgumentsInOrder()
    {
        $mock = MockMakeFacade::make([
            'param1'      => 'value1',
            'secondParam' => 'value2',
            'third_param' => 'value3',
        ]);

        $this->assertEquals('value1', $mock->param1);
        $this->assertEquals('value2', $mock->secondParam);
        $this->assertEquals('value3', $mock->third_param);
    }

    /**
     * Arguments in order test.
     *
     * @test
     */
    public function testArgumentsWithDefaultValues()
    {
        $mock = MockMakeFacade::make([
            'param1'      => 'value1',
            'secondParam' => 'value2',
        ]);

        $this->assertEquals('value1', $mock->param1);
        $this->assertEquals('value2', $mock->secondParam);
        $this->assertEquals('default', $mock->third_param);
    }

    /**
     * Snake case arguments in order test.
     *
     * @test
     */
    public function testSnakeCaseArgumentsInOrder()
    {
        $mock = MockMakeFacade::make([
            'param1'       => 'value1',
            'second_param' => 'value2',
            'third_param'  => 'value3',
        ]);

        $this->assertEquals('value1', $mock->param1);
        $this->assertEquals('value2', $mock->secondParam);
        $this->assertEquals('value3', $mock->third_param);
    }

    /**
     * Snake case arguments not in order test.
     *
     * @test
     */
    public function testSnakeCaseArgumentsNotInOrder()
    {
        $mock = MockMakeFacade::make([
            'third_param'  => 'value3',
            'param1'       => 'value1',
            'second_param' => 'value2',
        ]);

        $this->assertEquals('value1', $mock->param1);
        $this->assertEquals('value2', $mock->secondParam);
        $this->assertEquals('value3', $mock->third_param);
    }

    /**
     * Snake case arguments not in order test.
     *
     * @test
     */
    public function testResolveClassHints()
    {
        $mock = MockMakeFacade::makeResolve([
            'second_param' => 'value2',
        ]);

        $this->assertInstanceOf(get_class($mock), $mock->param1);
        $this->assertEquals('value2', $mock->secondParam);
        $this->assertEquals('default', $mock->third_param);
    }
}
