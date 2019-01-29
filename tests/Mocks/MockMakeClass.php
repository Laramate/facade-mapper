<?php

namespace Laramate\FacadeMapper\Tests\Mocks;

class MockMakeClass
{
    protected $attributes = [];

    public function make(string $param1, $secondParam, string $third_param = 'default')
    {
        $this->attributes['param1'] = $param1;
        $this->attributes['secondParam'] = $secondParam;
        $this->attributes['third_param'] = $third_param;

        return $this;
    }

    public function makeResolve(MockMakeClass $param1, $secondParam, string $third_param = 'default')
    {
        $this->attributes['param1'] = $param1;
        $this->attributes['secondParam'] = $secondParam;
        $this->attributes['third_param'] = $third_param;

        return $this;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }
}
