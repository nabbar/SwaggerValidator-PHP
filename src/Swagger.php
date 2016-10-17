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

if (file_exists('SwaggerValidator.phar') && !class_exists('\SwaggerValidator\SwaggerAutoload')) {
    require_once "phar://SwaggerValidator.phar";
    \SwaggerValidator\SwaggerAutoload::registerAutoloader();
}
elseif (!class_exists('\SwaggerValidator\SwaggerAutoload')) {
    require_once 'SwaggerAutoload.php';
    \SwaggerValidator\SwaggerAutoload::registerAutoloader();
}

/**
 * Description of Swagger
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Swagger
{

    /**
     * flag to store capability of using cache file
     * @var boolean
     */
    private static $cacheEnable;

    /**
     * Path for the cache file
     * @var string
     */
    private static $cachePath;

    /**
     * Timestamp addition to check if the modify time of the cache file is out or not
     * @var integer
     */
    private static $cacheLifeTime;

    /**
     * the swagger json definition file path or file url
     * @var string
     */
    private static $swaggerFile;

    /**
     * Store the cache path and check if the file cache can enabled or not
     * @param string $pathCacheFile
     */
    public static function setCachePath($pathCacheFile)
    {
        self::$cacheEnable = false;

        if (!empty($pathCacheFile) && file_exists($pathCacheFile)) {
            self::$cacheEnable = true;
            self::$cachePath   = $pathCacheFile;
        }
        elseif (!empty($pathCacheFile) && !file_exists(dirname($pathCacheFile))) {
            self::$cacheEnable = false;
            self::$cachePath   = $pathCacheFile;
        }
        elseif (!empty($pathCacheFile) && touch($pathCacheFile)) {
            unlink($pathCacheFile);
            self::$cacheEnable = true;
            self::$cachePath   = $pathCacheFile;
        }
    }

    /**
     * return the cache file path
     * @return string|null
     */
    public static function getCachePath()
    {
        return self::$cachePath;
    }

    /**
     * Store the number of second for available lifetime for cache file
     * @param integer $maxTimeStamp
     */
    public static function setCacheLifeTime($maxTimeStamp)
    {
        self::$cacheLifeTime = (int) $maxTimeStamp;
    }

    /**
     * return the value of the cache lifetime
     * @return integer
     */
    public static function getCacheLifeTime()
    {
        return (int) self::$cacheLifeTime;
    }

    /**
     * The pathfile or url to the swagger file definition
     * For multi file specify only the main definition file (other references must be in relative path based of location of each current file)
     * @param string $pathFileSwagger
     */
    public static function setSwaggerFile($pathFileSwagger)
    {
        self::$swaggerFile = $pathFileSwagger;
    }

    /**
     * Return the path/url of the Swagger Definition File
     * @return string|null
     */
    public static function getSwaggerFile()
    {
        return self::$swaggerFile;
    }

    /**
     * Load the Swagger Object from the cache file or create a new
     * @param \SwaggerValidator\Common\Context $context
     * @return \SwaggerValidator\Object\Swagger
     */
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

    /**
     * Return a Swagger Object new object
     * @param \SwaggerValidator\Common\Context $context
     * @return \SwaggerValidator\Object\Swagger
     */
    protected static function regenSwagger(\SwaggerValidator\Common\Context $context)
    {
        $fileObj = \SwaggerValidator\Common\CollectionFile::getInstance()->get($context, self::$swaggerFile);

        if (!is_object($fileObj) && ($fileObj instanceof \SwaggerValidator\Common\ReferenceFile)) {
            $context->throwException('Cannot load the given file "' . self::$swaggerFile . '"', __METHOD__, __LINE__);
        }

        $swagger = \SwaggerValidator\Common\Factory::getInstance()->get(\SwaggerValidator\Common\CollectionType::Swagger);

        if (!is_object($swagger) && ($swagger instanceof \SwaggerValidator\Object\Swagger)) {
            $context->throwException('Cannot create the swagger object !!', __METHOD__, __LINE__);
        }

        $swagger->jsonUnSerialize($context, $fileObj->fileObj);

        if (self::$cacheEnable !== true) {
            return $swagger;
        }

        return self::storeCache($swagger, $context);
    }

    /**
     * load cache file or call regen file cache
     * @param \SwaggerValidator\Common\Context $context
     * @return \SwaggerValidator\Object\Swagger
     */
    protected static function loadCache(\SwaggerValidator\Common\Context $context)
    {
        self::cleanInstances();

        $swagger = include self::$cachePath;

        if (!is_array($swagger)) {
            $context->throwException('Cannot Load Cache file : ' . self::$cachePath, __METHOD__, __LINE__);
        }

        $swagger = $swagger['swg'];

        if (!is_object($swagger) && ($swagger instanceof \SwaggerValidator\Object\Swagger)) {
            $context->throwException('Cannot Load Cache file : ' . self::$cachePath, __METHOD__, __LINE__);
        }

        return $swagger;
    }

    /**
     * store the new swagger object is available
     * @param \SwaggerValidator\Object\Swagger $swagger
     * @return \SwaggerValidator\Object\Swagger
     */
    protected static function storeCache(\SwaggerValidator\Object\Swagger $swagger, \SwaggerValidator\Common\Context $context)
    {
        if (self::$cacheEnable !== true) {
            return $swagger;
        }

        if (!file_exists(self::$cachePath) && !touch(self::$cachePath)) {
            self::$cacheEnable = false;
            $context->throwException('Cannot Write Cache file : ' . self::$cachePath, __METHOD__, __LINE__);
        }

        $array = array(
            'ref' => \SwaggerValidator\Common\CollectionReference::getInstance(),
            'swg' => $swagger,
        );

        file_put_contents(self::$cachePath, '<?php return ' . var_export($array, true) . ';');
        touch(self::$cachePath);

        return $swagger;
    }

    public static function cleanInstances()
    {
        \SwaggerValidator\Common\CollectionReference::pruneInstance();
        \SwaggerValidator\Common\CollectionFile::pruneInstance();
        \SwaggerValidator\Common\FactorySwagger::pruneInstance();
        \SwaggerValidator\Common\Sandbox::pruneInstance();
    }

}
