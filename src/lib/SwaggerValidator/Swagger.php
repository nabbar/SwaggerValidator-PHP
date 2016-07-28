<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger;

if (file_exists('SwaggerValidator.phar')) {
    require_once "phar://SwaggerValidator.phar";
    \Swagger\Autoload::registerAutoloader();
}
else {
    require_once 'Autoload.php';
    \Swagger\Autoload::registerAutoloader();
}

/**
 * Description of Swagger
 *
 * @author Nabbar
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

    public static function load()
    {
        if (self::$cacheEnable !== true || !file_exists(self::$cachePath)) {
            return self::regenSwagger();
        }

        if ((filemtime(self::$cachePath) + self::$cacheLifeTime) < time() && self::$cacheLifeTime > 0) {
            return self::regenSwagger();
        }

        return self::loadCache();
    }

    protected static function regenSwagger()
    {
        $context = new \Swagger\Common\Context();
        $fileObj = \Swagger\Common\CollectionFile::getInstance()->get(self::$swaggerFile);

        if (!is_object($fileObj) && ($fileObj instanceof \Swagger\Common\ReferenceFile)) {
            \Swagger\Exception::throwNewException('Cannot load the given file "' . self::$swaggerFile . '"', $context, __METHOD__, __LINE__);
        }

        $swagger = \Swagger\Common\Factory::getInstance()->get('Swagger');
        if (!is_object($swagger) && ($swagger instanceof \Swagger\Object\Swagger)) {
            \Swagger\Exception::throwNewException('Cannot create the swagger object !!', $context, __METHOD__, __LINE__);
        }

        $swagger->jsonUnSerialize($context, $fileObj->fileObj);

        if (self::$cacheEnable !== true) {
            return $swagger;
        }

        return self::storeCache($swagger);
    }

    protected static function loadCache($param)
    {
        $swagger = unserialize(base64_decode(trim(file_get_contents(self::$cachePath))));

        if (!is_object($swagger) && ($swagger instanceof \Swagger\Object\Swagger)) {
            return self::regenSwagger();
        }
    }

    protected static function storeCache(\Swagger\Object\Swagger $swagger)
    {
        file_put_contents(self::$cachePath, base64_decode(serialize(file_get_contents($swagger))));
        return $swagger;
    }

}
