<?php

namespace TwoDudes\ErrorLoggerBundle\EventListener;


use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener extends ContainerAware
{
    public function onKernelException(GetResponseForExceptionEvent $exception)
    {
        $exception = $exception->getException();
        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() == 404 && !$this->container->getParameter('two_dudes.log404')) {
            return;
        }
        $this->container->get('two_dudes.error_logger')->error($exception->getMessage(), array('exception' => $exception));
    }
} 