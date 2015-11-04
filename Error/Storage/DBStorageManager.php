<?php
/**
 * Created by PhpStorm.
 * User: vin
 * Date: 06/12/13
 * Time: 17:09
 */

namespace TwoDudes\ErrorLoggerBundle\Error\Storage;

use PDO;
use TwoDudes\ErrorLoggerBundle\Error\ErrorType\AbstractError;

/**
 * Class DBStorageManager
 * @package TwoDudes\ErrorLoggerBundle\Error\Storage
 */
class DBStorageManager implements StorageManagerInterface
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var array
     */
    protected $params;

    /**
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return PDO
     */
    protected function getPdo()
    {
        if (null == $this->pdo) {
            $connString = 'mysql:host=' . $this->params['db_host'] . ';port=' . $this->params['db_port'] . ';dbname=' . $this->params['db_name'];
            $this->pdo = new PDO($connString, $this->params['db_user'], $this->params['db_password']);
        }
        return $this->pdo;
    }

    /**
     * @param array $errors
     */
    public function saveErrors(array $errors)
    {
        foreach ($errors as $error) {
            /** @var AbstractError $error */
            $stmt = $this->getPdo()->prepare("SELECT * FROM errors WHERE hash = :hash");
            $stmt->execute(array(':hash' => $error->getHashKey()));

            if ($stmt->rowCount() > 0) {
                $this->getPdo()->prepare("UPDATE errors SET count = count + 1, created_at = CURRENT_TIMESTAMP WHERE hash = :hash")->execute(array(':hash' => $error->getHashKey()));
            } else {
                $stmt = $this->getPdo()->prepare("INSERT INTO errors(count, message, trace, created_at, file, line, type, hash, server, tokenData) VALUES(1,?,?,?,?,?,?,?,?,?)");
                $stmt->execute(array(
                    $error->getMessage(),
                    $error->getTrace(),
                    $error->getCreatedAt(),
                    $error->getFile(),
                    $error->getLine(),
                    $error->getType(),
                    $error->getHashKey(),
                    $error->getServer(),
                    $error->getTokenData()
                ));
            }

        }
    }

    /**
     * @return \PDOStatement
     */
    public function fetchErrors()
    {
        return $this->getPdo()->query("SELECT * FROM errors");
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchError($id)
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM errors WHERE id = :id");
        $stmt->execute(array(':id' => $id));
        $error = $stmt->fetchObject();
        $error->server = unserialize($error->server);
        return $error;
    }

    /**
     * @param $id
     */
    public function removeError($id)
    {
        $this->getPdo()->prepare("DELETE FROM errors WHERE id = :id")->execute(array(':id' => $id));
    }

    /**
     *
     */
    public function clearErrors()
    {
        $this->getPdo()->prepare("DELETE FROM errors WHERE 1 = 1")->execute();
    }
}