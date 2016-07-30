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

if (file_exists('SwaggerValidator.phar')) {
    require_once "phar://SwaggerValidator.phar";
    \SwaggerValidator\Autoload::registerAutoloader();
}
else {
    require_once 'Autoload.php';
    \SwaggerValidator\Autoload::registerAutoloader();
}

/**
 * Description of Swagger
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Swagger
{

    private static $cacheEnable;
    private static $cachePath;
    private static $cacheLifeTime;
    private static $swaggerFile;

    public static function setCachePath($pathCacheFile)
    {
        if (!empty($pathCacheFile) && file_exists($pathCacheFile)) {
            self::$cacheEnable = true;
            self::$cachePath   = $pathCacheFile;
        }
        elseif (!empty($pathCacheFile) && touch($pathCacheFile)) {
            unlink($pathCacheFile);
            self::$cacheEnable = true;
            self::$cachePath   = $pathCacheFile;
        }
        else {
            self::$cacheEnable = false;
        }
    }

    public static function getCachePath()
    {
        return self::$cachePath;
    }

    public static function setCacheLifeTime($maxTimeStamp)
    {
        self::$cacheLifeTime = (int) $maxTimeStamp;
    }

    public static function getCacheLifeTime()
    {
        return self::$cacheLifeTime;
    }

    public static function setSwaggerFile($pathFileSwagger)
    {
        self::$swaggerFile = $pathFileSwagger;
    }

    public static function getSwaggerFile()
    {
        return self::$swaggerFile;
    }

    public static function load(\SwaggerValidator\Common\Context $context)
    {
        if (self::$cacheEnable !== true || !file_exists(self::$cachePath)) {
            return self::regenSwagger($context);
        }

        if ((filemtime(self::$cachePath) + self::$cacheLifeTime) < time() && self::$cacheLifeTime > 0) {
            return self::regenSwagger($context);
        }

        return self::loadCache($context);
    }

    protected static function regenSwagger(\SwaggerValidator\Common\Context $context)
    {
        $fileObj = \SwaggerValidator\Common\CollectionFile::getInstance()->get(self::$swaggerFile);

        if (!is_object($fileObj) && ($fileObj instanceof \SwaggerValidator\Common\ReferenceFile)) {
            \SwaggerValidator\Exception::throwNewException('Cannot load the given file "' . self::$swaggerFile . '"', $context, __METHOD__, __LINE__);
        }

        $swagger = \SwaggerValidator\Common\Factory::getInstance()->get('Swagger');

        if (!is_object($swagger) && ($swagger instanceof \SwaggerValidator\Object\Swagger)) {
            \SwaggerValidator\Exception::throwNewException('Cannot create the swagger object !!', $context, __METHOD__, __LINE__);
        }

        $swagger->jsonUnSerialize($context, $fileObj->fileObj);

        if (self::$cacheEnable !== true) {
            return $swagger;
        }

        return self::storeCache($swagger);
    }

    protected static function loadCache(\SwaggerValidator\Common\Context $context)
    {
        $swagger = unserialize(base64_decode(trim(file_get_contents(self::$cachePath))));

        if (!is_object($swagger) && ($swagger instanceof \SwaggerValidator\Object\Swagger)) {
            return self::regenSwagger($context);
        }

        return $swagger;
    }

    protected static function storeCache(\SwaggerValidator\Object\Swagger $swagger)
    {
        if (self::$cacheEnable !== true) {
            return $swagger;
        }

        if (!file_exists(self::$cachePath) && !touch(self::$cachePath)) {
            self::$cacheEnable = false;
            return $swagger;
        }

        file_put_contents(self::$cachePath, base64_decode(serialize($swagger)));
        touch(self::$cachePath);

        return $swagger;
    }

}