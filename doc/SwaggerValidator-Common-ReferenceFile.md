SwaggerValidator\Common\ReferenceFile
===============

Description of ReferenceFile




* Class name: ReferenceFile
* Namespace: SwaggerValidator\Common



Constants
----------


### PATH_TYPE_URL

    const PATH_TYPE_URL = 1





### PATH_TYPE_FILE

    const PATH_TYPE_FILE = 2





Properties
----------


### $fileUri

    private mixed $fileUri





* Visibility: **private**


### $fileObj

    private mixed $fileObj





* Visibility: **private**


### $fileTime

    private mixed $fileTime





* Visibility: **private**


### $fileHash

    private mixed $fileHash





* Visibility: **private**


### $basePath

    private mixed $basePath





* Visibility: **private**


### $baseType

    private mixed $baseType





* Visibility: **private**


Methods
-------


### __construct

    mixed SwaggerValidator\Common\ReferenceFile::__construct(\SwaggerValidator\Common\Context $context, $filepath)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $filepath **mixed**



### __get

    mixed SwaggerValidator\Common\ReferenceFile::__get($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### __storeData

    mixed SwaggerValidator\Common\ReferenceFile::__storeData($key, $value)

Var Export Method



* Visibility: **protected**


#### Arguments
* $key **mixed**
* $value **mixed**



### __set_state

    mixed SwaggerValidator\Common\ReferenceFile::__set_state(array $properties)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $properties **array**



### getFileTime

    mixed SwaggerValidator\Common\ReferenceFile::getFileTime(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### getReference

    mixed SwaggerValidator\Common\ReferenceFile::getReference(\SwaggerValidator\Common\Context $context, $ref)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $ref **mixed**



### extractAllReference

    mixed SwaggerValidator\Common\ReferenceFile::extractAllReference(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### extractReferenceArray

    mixed SwaggerValidator\Common\ReferenceFile::extractReferenceArray(\SwaggerValidator\Common\Context $context, array $array)





* Visibility: **private**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $array **array**



### extractReferenceObject

    mixed SwaggerValidator\Common\ReferenceFile::extractReferenceObject(\SwaggerValidator\Common\Context $context, \stdClass $stdClass)





* Visibility: **private**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $stdClass **stdClass**



### getCanonical

    mixed SwaggerValidator\Common\ReferenceFile::getCanonical(\SwaggerValidator\Common\Context $context, $fullRef)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $fullRef **mixed**



### getFileLink

    mixed SwaggerValidator\Common\ReferenceFile::getFileLink(\SwaggerValidator\Common\Context $context, $uri)





* Visibility: **private**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $uri **mixed**



### getFilePath

    mixed SwaggerValidator\Common\ReferenceFile::getFilePath(\SwaggerValidator\Common\Context $context, $filepath)





* Visibility: **private**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $filepath **mixed**



### getUrlLink

    mixed SwaggerValidator\Common\ReferenceFile::getUrlLink($url)





* Visibility: **private**


#### Arguments
* $url **mixed**


