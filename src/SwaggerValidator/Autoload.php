<?php

/*
 * Copyright 2016 Nicolas JUHEL <swaggervalidator@nabbar.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace SwaggerValidator;

/**
 * Description of SwaggerCommonAutoload
 *
 * @author Nicolas JUHEL <swaggervalidator@nabbar.com>
 * @version 1.0.0
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
        $thisClass = trim(__NAMESPACE__, '\\');
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
