<?php

namespace TwoDudes\ErrorLoggerBundle;

use Monolog\ErrorHandler;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TwoDudesErrorLoggerBundle extends Bundle
{
    public function boot()
    {
        $logger = $this->container->get('two_dudes.error_logger');

        $handler = new ErrorHandler($logger);
        $handler->registerErrorHandler();
        $handler->registerExceptionHandler();
        $handler->registerFatalHandler();

        register_shutdown_function(array($logger, 'saveErrors'));
    }

}