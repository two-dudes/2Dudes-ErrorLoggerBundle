<?php
/**
 * Created by PhpStorm.
 * User: vin
 * Date: 06/12/13
 * Time: 16:59
 */

namespace TwoDudes\ErrorLoggerBundle\Error\ErrorType;


class Exception extends AbstractError
{
    public function getType()
    {
        return ErrorType::REGULAR_EXCEPTION;
    }

    public function processContext(array $context = array())
    {
        /** @var \Exception $exception */
        if (isset($context['exception'])) {
            $exception = $context['exception'];
            if ($exception instanceof \Exception) {
                $this->line = $exception->getLine();
                $this->file = $exception->getFile();
                $this->trace = $exception->getTraceAsString();
            }
        }
    }
}