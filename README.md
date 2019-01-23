# Laravel Facade Mapper

## Introduction
This package extends laravel facades: 

- Use a single array as instead of listing parameters
- Use parameters in any order
- Auto resolve class/interface type hints on any method (using laravel's application container) 

For example

```php
class MyClass
{
    myMethod(Request $request, string $string, int $integer=5) 
    {
    }
}
```

can be called

```php
    MyFacade::myMethod([
        'string' => 'value'    
    ]);
}
```



## Installation

You can install the package via composer:

```bash
composer require laramate/facade-mapper
```

## How to use?

There are two ways to use this package. 

### Using the HasFacadeMapper trait

Just use the `HasFacadeMapper` trait in your facade.

```php
<?php

namespace App\Facade;

use Laramate\FacadeMapper\Traits\HasFacadeMapper;

class MyFacade extends \Illuminate\Support\Facades\Facade
{
    use HasFacadeMapper;
}
```

### Extending the Facade class

You can simply extend the package `Facade` class

```php
<?php

namespace App\Facade;

use Laramate\FacadeMapper\Facades\Facade;

class MyFacade extends Facade
{
}
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
 
