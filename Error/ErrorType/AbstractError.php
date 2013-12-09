<?php
/**
 * Created by PhpStorm.
 * User: vin
 * Date: 06/12/13
 * Time: 16:59
 */

namespace TwoDudes\ErrorLoggerBundle\Error\ErrorType;

/**
 * Class AbstractError
 * @package TwoDudes\ErrorLoggerBundle\Error\ErrorType
 */
/**
 * Class AbstractError
 * @package TwoDudes\ErrorLoggerBundle\Error\ErrorType
 */
abstract class AbstractError
{
    /**
     * @var
     */
    protected $line;

    /**
     * @var
     */
    protected $file;

    /**
     * @var
     */
    protected $message;

    /**
     * @var
     */
    protected $createdAt;

    /**
     * @var
     */
    protected $trace;

    /**
     * @var
     */
    protected $server;

    /**
     *
     */
    function __construct()
    {
        $this->server = serialize($_SERVER);
        $this->createdAt = date('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    abstract public function getType();


    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $trace
     */
    public function setTrace($trace)
    {
        $this->trace = $trace;
    }

    /**
     * @return mixed
     */
    public function getTrace()
    {
        return $this->trace;
    }


    /**
     * @return string
     */
    public function getHashKey()
    {
        return md5($this->line . $this->file . $this->message);
    }

    /**
     * @param array $context
     */
    public function processContext(array $context = array())
    {
        $this->line = $context['line'];
        $this->file = $context['file'];
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }

    /**
     * @return mixed
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }
}