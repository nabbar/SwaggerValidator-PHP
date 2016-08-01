SwaggerValidator\Swagger
===============

Description of Swagger




* Class name: Swagger
* Namespace: SwaggerValidator





Properties
----------


### $cacheEnable

    private boolean $cacheEnable

flag to store capability of using cache file



* Visibility: **private**
* This property is **static**.


### $cachePath

    private string $cachePath

Path for the cache file



* Visibility: **private**
* This property is **static**.


### $cacheLifeTime

    private integer $cacheLifeTime

Timestamp addition to check if the modify time of the cache file is out or not



* Visibility: **private**
* This property is **static**.


### $swaggerFile

    private string $swaggerFile

the swagger json definition file path or file url



* Visibility: **private**
* This property is **static**.


Methods
-------


### setCachePath

    mixed SwaggerValidator\Swagger::setCachePath(string $pathCacheFile)

Store the cache path and check if the file cache can enabled or not



* Visibility: **public**
* This method is **static**.


#### Arguments
* $pathCacheFile **string**



### getCachePath

    string|null SwaggerValidator\Swagger::getCachePath()

return the cache file path



* Visibility: **public**
* This method is **static**.




### setCacheLifeTime

    mixed SwaggerValidator\Swagger::setCacheLifeTime(integer $maxTimeStamp)

Store the number of second for available lifetime for cache file



* Visibility: **public**
* This method is **static**.


#### Arguments
* $maxTimeStamp **integer**



### getCacheLifeTime

    integer SwaggerValidator\Swagger::getCacheLifeTime()

return the value of the cache lifetime



* Visibility: **public**
* This method is **static**.




### setSwaggerFile

    mixed SwaggerValidator\Swagger::setSwaggerFile(string $pathFileSwagger)

The pathfile or url to the swagger file definition
For multi file specify only the main definition file (other references must be in relative path based of location of each current file)



* Visibility: **public**
* This method is **static**.


#### Arguments
* $pathFileSwagger **string**



### getSwaggerFile

    string|null SwaggerValidator\Swagger::getSwaggerFile()

Return the path/url of the Swagger Definition File



* Visibility: **public**
* This method is **static**.




### load

    \SwaggerValidator\Object\Swagger SwaggerValidator\Swagger::load(\SwaggerValidator\Common\Context $context)

Load the Swagger Object from the cache file or create a new



* Visibility: **public**
* This method is **static**.


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### regenSwagger

    \SwaggerValidator\Object\Swagger SwaggerValidator\Swagger::regenSwagger(\SwaggerValidator\Common\Context $context)

Return a Swagger Object new object



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### loadCache

    \SwaggerValidator\Object\Swagger SwaggerValidator\Swagger::loadCache(\SwaggerValidator\Common\Context $context)

load cache file or call regen file cache



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### storeCache

    \SwaggerValidator\Object\Swagger SwaggerValidator\Swagger::storeCache(\SwaggerValidator\Object\Swagger $swagger)

store the new swagger object is available



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $swagger **[SwaggerValidator\Object\Swagger](SwaggerValidator-Object-Swagger.md)**



### cleanInstances

    mixed SwaggerValidator\Swagger::cleanInstances()





* Visibility: **public**
* This method is **static**.



