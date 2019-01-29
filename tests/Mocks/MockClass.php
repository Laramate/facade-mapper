<?php

namespace Laramate\FacadeMapper\Tests\Mocks;

class MockClass
{
    protected $attributes = [];

    public function __construct(string $param1, $secondParam, string $third_param = 'default')
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
