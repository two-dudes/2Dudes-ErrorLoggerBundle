<?php
/**
 * Created by PhpStorm.
 * User: vin
 * Date: 06/12/13
 * Time: 16:59
 */

namespace TwoDudes\ErrorLoggerBundle\Error\ErrorType;

use Psr\Log\LogLevel;

/**
 * Class Factory
 * @package TwoDudes\ErrorLoggerBundle\Error\ErrorType
 */
class Factory
{
    /**
     * @param $type
     * @return Exception|FatalException|Notice|Warning
     */
    public static function createError($type)
    {
        switch ($type) {
            case LogLevel::WARNING:
                return new Warning();
                break;
            case LogLevel::NOTICE:
                return new Notice();
                break;
            case LogLevel::CRITICAL:
            case LogLevel::ALERT:
                return new FatalException();
                break;
            default:
                return new Exception();
                break;
        }
    }
} 