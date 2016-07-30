SwaggerValidator\Common\Context
===============

Description of SwaggerCommonContext




* Class name: Context
* Namespace: SwaggerValidator\Common



Constants
----------


### MODE_PASS

    const MODE_PASS = 'PASS'





### MODE_DENY

    const MODE_DENY = 'DENY'





### TYPE_REQUEST

    const TYPE_REQUEST = 'REQUEST'





### TYPE_RESPONSE

    const TYPE_RESPONSE = 'RESPONSE'





### METHOD_GET

    const METHOD_GET = 'get'





### METHOD_POST

    const METHOD_POST = 'post'





### METHOD_PUT

    const METHOD_PUT = 'put'





### METHOD_PATCH

    const METHOD_PATCH = 'patch'





### METHOD_DELETE

    const METHOD_DELETE = 'delete'





### METHOD_HEAD

    const METHOD_HEAD = 'head'





### METHOD_OPTIONS

    const METHOD_OPTIONS = 'options'





### CONTENT_TYPE_JSON

    const CONTENT_TYPE_JSON = 'json'





### CONTENT_TYPE_XML

    const CONTENT_TYPE_XML = 'xml'





### CONTENT_TYPE_OTHER

    const CONTENT_TYPE_OTHER = 'other'





### VALIDATION_TYPE_BASEPATH_ERROR

    const VALIDATION_TYPE_BASEPATH_ERROR = 'BASEPATH'





### VALIDATION_TYPE_DATASIZE

    const VALIDATION_TYPE_DATASIZE = 'DATASIZE'





### VALIDATION_TYPE_DATATYPE

    const VALIDATION_TYPE_DATATYPE = 'DATATYPE'





### VALIDATION_TYPE_DATAVALUE

    const VALIDATION_TYPE_DATAVALUE = 'DATAVALUE'





### VALIDATION_TYPE_METHOD_ERROR

    const VALIDATION_TYPE_METHOD_ERROR = 'METHOD'





### VALIDATION_TYPE_NOTFOUND

    const VALIDATION_TYPE_NOTFOUND = 'NOTFOUND'





### VALIDATION_TYPE_PATTERN

    const VALIDATION_TYPE_PATTERN = 'PATTERN'





### VALIDATION_TYPE_RESPONSE_ERROR

    const VALIDATION_TYPE_RESPONSE_ERROR = 'RESPONSE'





### VALIDATION_TYPE_ROUTE_ERROR

    const VALIDATION_TYPE_ROUTE_ERROR = 'ROUTE'





### VALIDATION_TYPE_SWAGGER_ERROR

    const VALIDATION_TYPE_SWAGGER_ERROR = 'SWAGGER'





### VALIDATION_TYPE_TOOMANY

    const VALIDATION_TYPE_TOOMANY = 'TOOMANY'





Properties
----------


### $config

    protected array $config = array('mode' => array(self::TYPE_REQUEST => self::MODE_DENY, self::TYPE_RESPONSE => self::MODE_PASS), 'log' => array('loadFile' => true, 'loadRef' => true, 'replaceRef' => true, 'decode' => true, 'validate' => true, 'model' => true))





* Visibility: **protected**
* This property is **static**.


### $contextMode

    protected string $contextMode





* Visibility: **protected**


### $contextType

    protected string $contextType





* Visibility: **protected**


### $contextLocation

    protected string $contextLocation





* Visibility: **protected**


### $contextScheme

    protected string $contextScheme





* Visibility: **protected**


### $contextHost

    protected string $contextHost





* Visibility: **protected**


### $contextBasePath

    protected string $contextBasePath





* Visibility: **protected**


### $contextRequestPath

    protected string $contextRequestPath





* Visibility: **protected**


### $contextRoutePath

    protected string $contextRoutePath





* Visibility: **protected**


### $contextMethod

    protected string $contextMethod





* Visibility: **protected**


### $contextDataPath

    protected array $contextDataPath





* Visibility: **protected**


### $contextDataCheck

    protected array $contextDataCheck





* Visibility: **protected**


### $contextDataValue

    protected mixed $contextDataValue





* Visibility: **protected**


### $contextDataValueExists

    protected boolean $contextDataValueExists





* Visibility: **protected**


### $contextDataValueEmpty

    protected boolean $contextDataValueEmpty





* Visibility: **protected**


### $contextDataDecodeError

    protected array $contextDataDecodeError





* Visibility: **protected**


### $contextDataType

    protected string $contextDataType





* Visibility: **protected**


### $contextOther

    protected array $contextOther





* Visibility: **protected**


### $contextExternalRef

    protected array $contextExternalRef





* Visibility: **protected**


### $contextIsCombined

    protected boolean $contextIsCombined





* Visibility: **protected**


### $contextValidatedParams

    protected array $contextValidatedParams = array()





* Visibility: **protected**
* This property is **static**.


### $mockedData

    protected array $mockedData = array()





* Visibility: **protected**


Methods
-------


### __construct

    mixed SwaggerValidator\Common\Context::__construct(string|null $mode, string|null $type)





* Visibility: **public**


#### Arguments
* $mode **string|null**
* $type **string|null**



### setConfig

    mixed SwaggerValidator\Common\Context::setConfig($optionGroup, $optionName, $value)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $optionGroup **mixed**
* $optionName **mixed**
* $value **mixed**



### getConfig

    mixed SwaggerValidator\Common\Context::getConfig($optionGroup, $optionName)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $optionGroup **mixed**
* $optionName **mixed**



### formatVarName

    mixed SwaggerValidator\Common\Context::formatVarName($name)





* Visibility: **private**


#### Arguments
* $name **mixed**



### __get

    mixed SwaggerValidator\Common\Context::__get($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### __set

    mixed SwaggerValidator\Common\Context::__set($name, $value)





* Visibility: **public**


#### Arguments
* $name **mixed**
* $value **mixed**



### __isset

    mixed SwaggerValidator\Common\Context::__isset($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### __unset

    mixed SwaggerValidator\Common\Context::__unset($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### __toString

    mixed SwaggerValidator\Common\Context::__toString()





* Visibility: **public**




### __debugInfo

    mixed SwaggerValidator\Common\Context::__debugInfo()





* Visibility: **public**




### setMode

    mixed SwaggerValidator\Common\Context::setMode($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getMode

    mixed SwaggerValidator\Common\Context::getMode()





* Visibility: **public**




### setType

    mixed SwaggerValidator\Common\Context::setType($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getType

    mixed SwaggerValidator\Common\Context::getType()





* Visibility: **public**




### setLocation

    mixed SwaggerValidator\Common\Context::setLocation($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getLocation

    mixed SwaggerValidator\Common\Context::getLocation()





* Visibility: **public**




### setMethod

    mixed SwaggerValidator\Common\Context::setMethod($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getMethod

    mixed SwaggerValidator\Common\Context::getMethod()





* Visibility: **public**




### loadMethod

    mixed SwaggerValidator\Common\Context::loadMethod()





* Visibility: **public**




### setBasePath

    mixed SwaggerValidator\Common\Context::setBasePath($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getBasePath

    mixed SwaggerValidator\Common\Context::getBasePath()





* Visibility: **public**




### setRoutePath

    mixed SwaggerValidator\Common\Context::setRoutePath($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getRoutePath

    mixed SwaggerValidator\Common\Context::getRoutePath()





* Visibility: **public**




### setRequestPath

    mixed SwaggerValidator\Common\Context::setRequestPath($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getRequestPath

    mixed SwaggerValidator\Common\Context::getRequestPath()





* Visibility: **public**




### setScheme

    mixed SwaggerValidator\Common\Context::setScheme($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getScheme

    mixed SwaggerValidator\Common\Context::getScheme()





* Visibility: **public**




### setHost

    mixed SwaggerValidator\Common\Context::setHost($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getHost

    mixed SwaggerValidator\Common\Context::getHost()





* Visibility: **public**




### loadUri

    mixed SwaggerValidator\Common\Context::loadUri()





* Visibility: **public**




### addContext

    mixed SwaggerValidator\Common\Context::addContext($key, $value)





* Visibility: **public**


#### Arguments
* $key **mixed**
* $value **mixed**



### getContext

    mixed SwaggerValidator\Common\Context::getContext()





* Visibility: **public**




### setCombined

    mixed SwaggerValidator\Common\Context::setCombined($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getCombined

    mixed SwaggerValidator\Common\Context::getCombined()





* Visibility: **public**




### setDataPath

    mixed SwaggerValidator\Common\Context::setDataPath($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getDataPath

    mixed SwaggerValidator\Common\Context::getDataPath()





* Visibility: **public**




### setExternalRef

    mixed SwaggerValidator\Common\Context::setExternalRef($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getExternalRef

    mixed SwaggerValidator\Common\Context::getExternalRef()





* Visibility: **public**




### getLastExternalRef

    mixed SwaggerValidator\Common\Context::getLastExternalRef()





* Visibility: **public**




### checkExternalRef

    mixed SwaggerValidator\Common\Context::checkExternalRef($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### setDataCheck

    mixed SwaggerValidator\Common\Context::setDataCheck($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getDataCheck

    mixed SwaggerValidator\Common\Context::getDataCheck()





* Visibility: **public**




### setDataValue

    mixed SwaggerValidator\Common\Context::setDataValue($value)





* Visibility: **public**


#### Arguments
* $value **mixed**



### getDataValue

    mixed SwaggerValidator\Common\Context::getDataValue()





* Visibility: **public**




### isDataExists

    mixed SwaggerValidator\Common\Context::isDataExists()





* Visibility: **public**




### isDataEmpty

    mixed SwaggerValidator\Common\Context::isDataEmpty()





* Visibility: **public**




### checkDataIsEmpty

    mixed SwaggerValidator\Common\Context::checkDataIsEmpty()





* Visibility: **public**




### getResponseStatus

    mixed SwaggerValidator\Common\Context::getResponseStatus()





* Visibility: **public**




### dataLoad

    mixed SwaggerValidator\Common\Context::dataLoad()





* Visibility: **public**




### getRequestFormDataKey

    mixed SwaggerValidator\Common\Context::getRequestFormDataKey()





* Visibility: **public**




### loadRequestFormData

    mixed SwaggerValidator\Common\Context::loadRequestFormData($paramName)





* Visibility: **public**


#### Arguments
* $paramName **mixed**



### loadRequestPath

    mixed SwaggerValidator\Common\Context::loadRequestPath($paramName)





* Visibility: **public**


#### Arguments
* $paramName **mixed**



### getRequestQueryKey

    mixed SwaggerValidator\Common\Context::getRequestQueryKey()





* Visibility: **public**




### loadRequestQuery

    mixed SwaggerValidator\Common\Context::loadRequestQuery($paramName)





* Visibility: **public**


#### Arguments
* $paramName **mixed**



### loadRequestHeader

    mixed SwaggerValidator\Common\Context::loadRequestHeader($paramName)





* Visibility: **public**


#### Arguments
* $paramName **mixed**



### loadResponseHeader

    mixed SwaggerValidator\Common\Context::loadResponseHeader($paramName)





* Visibility: **public**


#### Arguments
* $paramName **mixed**



### loadRequestBody

    mixed SwaggerValidator\Common\Context::loadRequestBody()





* Visibility: **public**




### getRequestBodyRawData

    mixed SwaggerValidator\Common\Context::getRequestBodyRawData()





* Visibility: **public**




### loadResponseBody

    mixed SwaggerValidator\Common\Context::loadResponseBody()





* Visibility: **public**




### getResponseBodyRawData

    mixed SwaggerValidator\Common\Context::getResponseBodyRawData()





* Visibility: **public**




### setValidationError

    mixed SwaggerValidator\Common\Context::setValidationError($valitionType, $messageException, $method, $line)





* Visibility: **public**


#### Arguments
* $valitionType **mixed**
* $messageException **mixed**
* $method **mixed**
* $line **mixed**



### logLoadFile

    mixed SwaggerValidator\Common\Context::logLoadFile($file, $method, $line)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $file **mixed**
* $method **mixed**
* $line **mixed**



### logLoadRef

    mixed SwaggerValidator\Common\Context::logLoadRef($ref, $method, $line)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $ref **mixed**
* $method **mixed**
* $line **mixed**



### logReplaceRef

    mixed SwaggerValidator\Common\Context::logReplaceRef($oldRef, $newRef, $method, $line)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $oldRef **mixed**
* $newRef **mixed**
* $method **mixed**
* $line **mixed**



### logDecode

    mixed SwaggerValidator\Common\Context::logDecode($decodePath, $decodeType, $method, $line)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $decodePath **mixed**
* $decodeType **mixed**
* $method **mixed**
* $line **mixed**



### logValidate

    mixed SwaggerValidator\Common\Context::logValidate($path, $type, $method, $line)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $path **mixed**
* $type **mixed**
* $method **mixed**
* $line **mixed**



### logModel

    mixed SwaggerValidator\Common\Context::logModel($path, $method, $line)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $path **mixed**
* $method **mixed**
* $line **mixed**



### logDebug

    mixed SwaggerValidator\Common\Context::logDebug(string $message, string $method, \SwaggerValidator\Common\TypeInteger $line)

Used to customizing log and more when a debug is send



* Visibility: **public**
* This method is **static**.


#### Arguments
* $message **string**
* $method **string**
* $line **SwaggerValidator\Common\TypeInteger**



### logValidationError

    mixed SwaggerValidator\Common\Context::logValidationError(\SwaggerValidator\Common\const $validationType, $method, $line)

Used to customizing log and more when a validation error is occured



* Visibility: **public**


#### Arguments
* $validationType **SwaggerValidator\Common\const**
* $method **mixed**
* $line **mixed**



### cleanParams

    mixed SwaggerValidator\Common\Context::cleanParams()

Used to clean params if validation error occured for mode PASS



* Visibility: **public**




### cleanCheckedDataName

    mixed SwaggerValidator\Common\Context::cleanCheckedDataName()





* Visibility: **public**
* This method is **static**.




### getCheckedDataName

    mixed SwaggerValidator\Common\Context::getCheckedDataName()





* Visibility: **public**
* This method is **static**.




### getCheckedMethodFormLocation

    mixed SwaggerValidator\Common\Context::getCheckedMethodFormLocation($type, $location)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $type **mixed**
* $location **mixed**



### addCheckedDataName

    mixed SwaggerValidator\Common\Context::addCheckedDataName($location, $name)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $location **mixed**
* $name **mixed**



### mock

    mixed SwaggerValidator\Common\Context::mock($options)





* Visibility: **public**


#### Arguments
* $options **mixed**



### checkIsEmpty

    mixed SwaggerValidator\Common\Context::checkIsEmpty($mixed)





* Visibility: **private**


#### Arguments
* $mixed **mixed**



### getEnv

    mixed SwaggerValidator\Common\Context::getEnv($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### getRequestHeader

    mixed SwaggerValidator\Common\Context::getRequestHeader()





* Visibility: **public**




### getResponseHeader

    mixed SwaggerValidator\Common\Context::getResponseHeader()





* Visibility: **public**



