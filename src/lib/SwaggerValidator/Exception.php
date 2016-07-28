<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger;

/**
 * Description of Exception
 *
 * @author Nabbar
 */
class Exception extends \Exception
{

    /**
     *
     * @var \Swagger\Common\Context
     */
    private $contextError;

    public static function newException($message, $context = null, $file = null, $line = null)
    {
        $e = new static($message);

        $e->setFile($file);
        $e->setLine($line);
        $e->setContext($context);

        return $e;
    }

    public static function throwNewException($message, $context = null, $file = null, $line = null)
    {
        throw self::newException($message, $context, $file, $line);
    }

    public function setFile($file)
    {
        if (!empty($file) && is_string($file)) {
            $this->file = $file;
        }
    }

    public function setLine($line)
    {
        if (!empty($line) && is_integer($line)) {
            $this->line = $line;
        }
    }

    public function setContext($context = null)
    {
        $this->contextError = $context;
    }

    public function getContext()
    {
        return $this->contextError;
    }

}
