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
final class SwaggerAutoload
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
        if (\Phar::running() && defined('PHAR_SWAGGER_VALIDATOR_ROOT_PATH')) {
            $baseDir = PHAR_SWAGGER_VALIDATOR_ROOT_PATH;
        }
        elseif (\Phar::running()) {
            $baseDir = null;
        }
        else {
            $baseDir = __DIR__ . DIRECTORY_SEPARATOR;
        }

        $thisClass = 'SwaggerValidator';

        $namespace = explode('\\', $className);
        $className = array_pop($namespace);
        $rootPath  = array_shift($namespace);

        if ($rootPath == $thisClass) {
            $namespace = $baseDir . trim(implode(DIRECTORY_SEPARATOR, $namespace), DIRECTORY_SEPARATOR);
        }
        else {
            $namespace = $baseDir . trim($rootPath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $namespace), DIRECTORY_SEPARATOR);
        }

        if (substr($namespace, -1, 1) != DIRECTORY_SEPARATOR) {
            $namespace .= DIRECTORY_SEPARATOR;
        }

        if ($namespace == DIRECTORY_SEPARATOR) {
            $namespace = "";
        }

        $fileName = $namespace . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($fileName)) {
            require_once $fileName;
        }
    }

    /**
     * Register Slim's PSR-0 autoloader
     */
    final public static function registerAutoloader()
    {
        spl_autoload_register("\\SwaggerValidator\\SwaggerAutoload::autoload");
    }

}

require_once 'Compat.php';
