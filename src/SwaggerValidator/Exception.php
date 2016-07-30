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
 * Description of Exception
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Exception extends \Exception
{

    /**
     *
     * @var \SwaggerValidator\Common\Context
     */
    private $contextError;

    public static function newException($message, $context = null, $file = null, $line = null)
    {
        $e = new static($message);

        $e->setFile($file);
        $e->setLine($line);
        $e->setContext($context);

        \SwaggerValidator\Common\Context::logDebug('Exception find : ' . $message . json_encode($context, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), __METHOD__, __LINE__);

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
