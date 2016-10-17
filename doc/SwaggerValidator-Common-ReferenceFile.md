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



### throwException

    mixed SwaggerValidator\Common\ReferenceFile::throwException(string $message, mixed $context, $file, $line)

Throw a new \SwaggerValidator\Exception with automatic find method, line, .

..

* Visibility: **protected**


#### Arguments
* $message **string**
* $context **mixed**
* $file **mixed**
* $line **mixed**



### getFileTime

    mixed SwaggerValidator\Common\ReferenceFile::getFileTime()





* Visibility: **public**




### getReference

    mixed SwaggerValidator\Common\ReferenceFile::getReference($ref)





* Visibility: **public**


#### Arguments
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

    mixed SwaggerValidator\Common\ReferenceFile::getCanonical($fullRef)





* Visibility: **public**


#### Arguments
* $fullRef **mixed**



### getFileLink

    mixed SwaggerValidator\Common\ReferenceFile::getFileLink($uri)





* Visibility: **private**


#### Arguments
* $uri **mixed**



### getFilePath

    mixed SwaggerValidator\Common\ReferenceFile::getFilePath($filepath)





* Visibility: **private**


#### Arguments
* $filepath **mixed**



### getUrlLink

    mixed SwaggerValidator\Common\ReferenceFile::getUrlLink($url)





* Visibility: **private**


#### Arguments
* $url **mixed**


