# Router

Router is a simple PHP library for managing routes in web applications.

## Installation

You can install Router via Composer. Run the following command:

```shell
composer require gustavodms/simplerouter
```

```php
<?php

namespace gustavodms\simplerouter;
require_once '../vendor/autoload.php';


Router::GET('teste1/{id}', function (Request $r, ResponseWriter $w) {
    $w->write($r->QuerString('id'));
});

Router::GET('teste2/{id}', function (Request $r, ResponseWriter $w) {
    $w->write($r->Params('id'));
});


Router::POST('teste/controller/{id}', [TesteController::class, 'index']);


Router::GET('teste', function () {
    echo "Teste";
});


Router::Initialize();
```

## Contributing

If you would like to contribute improvements, bug fixes, or new features to Router, feel free to submit a pull request.
We'll be glad to review it!

## License

Router is distributed under the MIT license.


