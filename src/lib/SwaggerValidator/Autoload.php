<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger;

/**
 * Description of SwaggerCommonAutoload
 *
 * @author Nabbar
 */
final class Autoload
{
    /*     * ******************************************************************************
     * PSR-0 Autoloader
     *
     * Do not use if you are using Composer to autoload dependencies.
     * ***************************************************************************** */

    /**
     * Slim PSR-0 autoloader
     */
    final public static function autoload($className)
    {
        if (\Phar::running()) {
            return self::autoloadPhar($className);
        }
        else {
            return self::autoloadSource($className);
        }
    }

    /**
     * Slim PSR-0 autoloader
     */
    final public static function autoloadPhar($className)
    {
        $currentNs = trim(__NAMESPACE__, '\\');
        $className = ltrim($className, '\\');

        if (substr($className, 0, strlen($currentNs)) != $currentNs) {
            return;
        }

        $namespace = explode('\\', substr($className, strlen($currentNs) + 1));
        $className = array_pop($namespace);
        $namespace = implode(DIRECTORY_SEPARATOR, $namespace);

        if (!empty($namespace)) {
            $namespace .= DIRECTORY_SEPARATOR;
        }

        require_once($namespace . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
    }

    /**
     * Slim PSR-0 autoloader
     */
    final public static function autoloadSource($className)
    {
        $thisClass = 'Swagger';
        $baseDir   = __DIR__;

        if (substr($baseDir, -strlen($thisClass)) === $thisClass) {
            $baseDir = substr($baseDir, 0, -strlen($thisClass));
        }

        $className = ltrim($className, '\\');
        $fileName  = $baseDir;
        $namespace = '';

        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($fileName)) {
            require_once $fileName;
        }
    }

    /**
     * Register Slim's PSR-0 autoloader
     */
    final public static function registerAutoloader()
    {
        spl_autoload_register(__CLASS__ . "::autoload");
    }

}

require_once 'Compat.php';
