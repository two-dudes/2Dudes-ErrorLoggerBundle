<?php
/**
 * Created by PhpStorm.
 * User: vin
 * Date: 16/12/13
 * Time: 10:33
 */

namespace TwoDudes\ErrorLoggerBundle\EventListener;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener extends ContainerAware
{
    public function onKernelException(GetResponseForExceptionEvent $exception)
    {
        $exception = $exception->getException();
        $this->container->get('two_dudes.error_logger')->error($exception->getMessage(), array('exception' => $exception));
    }
} 