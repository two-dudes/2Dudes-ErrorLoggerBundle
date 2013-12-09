<?php
/**
 * Created by PhpStorm.
 * User: vin
 * Date: 06/12/13
 * Time: 17:09
 */

namespace TwoDudes\ErrorLoggerBundle\Error\Storage;


interface StorageManagerInterface
{
    public function saveErrors(array $errors);
    
    public function fetchErrors();
    
    public function fetchError($id);
    
    public function removeError($id);
} 