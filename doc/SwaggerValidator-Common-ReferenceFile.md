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

    mixed SwaggerValidator\Common\ReferenceFile::__construct($filepath)





* Visibility: **public**


#### Arguments
* $filepath **mixed**



### __get

    mixed SwaggerValidator\Common\ReferenceFile::__get($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



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

    mixed SwaggerValidator\Common\ReferenceFile::extractAllReference()





* Visibility: **public**




### extractReferenceArray

    mixed SwaggerValidator\Common\ReferenceFile::extractReferenceArray(array $array)





* Visibility: **private**


#### Arguments
* $array **array**



### extractReferenceObject

    mixed SwaggerValidator\Common\ReferenceFile::extractReferenceObject(\stdClass $stdClass)





* Visibility: **private**


#### Arguments
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


