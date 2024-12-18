<?php

use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    // Debug::enable(E_RECOVERABLE_ERROR & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED, false);
    // print_r(phpinfo());
    // echo phpversion().PHP_EOL;
    // echo ini_get('memory_limit').PHP_EOL;
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
