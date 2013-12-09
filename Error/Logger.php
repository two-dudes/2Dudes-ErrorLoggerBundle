<?php
/**
 * Created by PhpStorm.
 * User: vin
 * Date: 06/12/13
 * Time: 16:51
 */

namespace TwoDudes\ErrorLoggerBundle\Error;


use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\DependencyInjection\ContainerAware;
use TwoDudes\ErrorLoggerBundle\Error\ErrorType\Exception;
use TwoDudes\ErrorLoggerBundle\Error\ErrorType\Factory;
use TwoDudes\ErrorLoggerBundle\Error\ErrorType\FatalException;
use TwoDudes\ErrorLoggerBundle\Error\ErrorType\Notice;
use TwoDudes\ErrorLoggerBundle\Error\ErrorType\Warning;
use TwoDudes\ErrorLoggerBundle\Error\Storage\StorageManagerInterface;

/**
 * Class Logger
 * @package TwoDudes\ErrorLoggerBundle\Error
 */
class Logger extends ContainerAware implements LoggerInterface
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var StorageManagerInterface
     */
    protected $storage;

    /**
     * @var
     */
    protected $storageServiceId;

    /**
     * @param $storageServiceId
     */
    function __construct($storageServiceId)
    {
        $this->storageServiceId = $storageServiceId;
    }

    /**
     * @return StorageManagerInterface
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->storage = $this->container->get($this->storageServiceId);
        }
        return $this->storage;
    }

    /**
     *
     */
    public function saveErrors()
    {
        $this->getStorage()->saveErrors($this->errors);
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $error = Factory::createError($level);
        $error->setMessage($message);
        $error->processContext($context);
        $this->errors[]= $error;
    }
}