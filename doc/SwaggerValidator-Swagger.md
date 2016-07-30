SwaggerValidator\Swagger
===============

Description of Swagger




* Class name: Swagger
* Namespace: SwaggerValidator





Properties
----------


### $cacheEnable

    private mixed $cacheEnable





* Visibility: **private**
* This property is **static**.


### $cachePath

    private mixed $cachePath





* Visibility: **private**
* This property is **static**.


### $cacheLifeTime

    private mixed $cacheLifeTime





* Visibility: **private**
* This property is **static**.


### $swaggerFile

    private mixed $swaggerFile





* Visibility: **private**
* This property is **static**.


Methods
-------


### setCachePath

    mixed SwaggerValidator\Swagger::setCachePath($pathCacheFile)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $pathCacheFile **mixed**



### getCachePath

    mixed SwaggerValidator\Swagger::getCachePath()





* Visibility: **public**
* This method is **static**.




### setCacheLifeTime

    mixed SwaggerValidator\Swagger::setCacheLifeTime($maxTimeStamp)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $maxTimeStamp **mixed**



### getCacheLifeTime

    mixed SwaggerValidator\Swagger::getCacheLifeTime()





* Visibility: **public**
* This method is **static**.




### setSwaggerFile

    mixed SwaggerValidator\Swagger::setSwaggerFile($pathFileSwagger)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $pathFileSwagger **mixed**



### getSwaggerFile

    mixed SwaggerValidator\Swagger::getSwaggerFile()





* Visibility: **public**
* This method is **static**.




### load

    mixed SwaggerValidator\Swagger::load(\SwaggerValidator\Common\Context $context)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### regenSwagger

    mixed SwaggerValidator\Swagger::regenSwagger(\SwaggerValidator\Common\Context $context)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### loadCache

    mixed SwaggerValidator\Swagger::loadCache(\SwaggerValidator\Common\Context $context)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### storeCache

    mixed SwaggerValidator\Swagger::storeCache(\SwaggerValidator\Object\Swagger $swagger)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $swagger **[SwaggerValidator\Object\Swagger](SwaggerValidator-Object-Swagger.md)**


