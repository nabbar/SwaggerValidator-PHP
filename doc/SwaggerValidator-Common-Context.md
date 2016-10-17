SwaggerValidator\Common\Context
===============

Description of SwaggerCommonContext




* Class name: Context
* Namespace: SwaggerValidator\Common
* Parent class: [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)
* This class implements: [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md), [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md), [SwaggerValidator\Interfaces\ContextDataParser](SwaggerValidator-Interfaces-ContextDataParser.md)


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





### VALIDATION_TYPE_HOSTNAME_ERROR

    const VALIDATION_TYPE_HOSTNAME_ERROR = 'HOSTNAME'





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

    protected array $config = array('mode' => array(self::TYPE_REQUEST => self::MODE_DENY, self::TYPE_RESPONSE => self::MODE_PASS), 'log' => array('loadFile' => true, 'loadRef' => true, 'replaceRef' => true, 'registerRef' => true, 'dropRef' => true, 'reference' => true, 'decode' => true, 'validate' => true, 'model' => true, 'validation' => true, 'exception' => true, 'debug' => true))





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


### $contextDataExists

    protected boolean $contextDataExists





* Visibility: **protected**


### $contextDataEmpty

    protected boolean $contextDataEmpty





* Visibility: **protected**


### $contextDecodeError

    protected array $contextDecodeError





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


### $contextValidationCode

    protected array $contextValidationCode = null





* Visibility: **protected**


### $mockedData

    protected array $mockedData = array()





* Visibility: **protected**


Methods
-------


### __storeData

    mixed SwaggerValidator\Common\ContextBase::__storeData($key, $value)

Var Export Method



* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)


#### Arguments
* $key **mixed**
* $value **mixed**



### __set_state

    mixed SwaggerValidator\Common\ContextBase::__set_state(array $properties)





* Visibility: **public**
* This method is **static**.
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)


#### Arguments
* $properties **array**



### setConfig

    void SwaggerValidator\Common\Context::setConfig(string $optionGroup, string $optionName, mixed $value)

Set a configuration option



* Visibility: **public**
* This method is **static**.


#### Arguments
* $optionGroup **string**
* $optionName **string**
* $value **mixed**



### setConfigDropAllDebugLog

    mixed SwaggerValidator\Common\Context::setConfigDropAllDebugLog()

Method to disable all debug log



* Visibility: **public**
* This method is **static**.




### getConfig

    mixed SwaggerValidator\Common\Context::getConfig(string $optionGroup, string $optionName)

Retrieve a config value



* Visibility: **public**
* This method is **static**.


#### Arguments
* $optionGroup **string**
* $optionName **string**



### loadUri

    mixed SwaggerValidator\Interfaces\ContextDataLoader::loadUri()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)




### checkDataIsEmpty

    mixed SwaggerValidator\Interfaces\ContextDataParser::checkDataIsEmpty()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataParser](SwaggerValidator-Interfaces-ContextDataParser.md)




### getResponseStatus

    mixed SwaggerValidator\Interfaces\ContextDataLoader::getResponseStatus()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)




### dataLoad

    mixed SwaggerValidator\Interfaces\ContextDataParser::dataLoad()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataParser](SwaggerValidator-Interfaces-ContextDataParser.md)




### getRequestFormDataKey

    mixed SwaggerValidator\Interfaces\ContextDataLoader::getRequestFormDataKey()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)




### loadRequestFormData

    mixed SwaggerValidator\Interfaces\ContextDataLoader::loadRequestFormData($paramName)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)


#### Arguments
* $paramName **mixed**



### loadRequestPath

    mixed SwaggerValidator\Interfaces\ContextDataLoader::loadRequestPath($paramName)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)


#### Arguments
* $paramName **mixed**



### getRequestQueryKey

    mixed SwaggerValidator\Interfaces\ContextDataLoader::getRequestQueryKey()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)




### loadRequestQuery

    mixed SwaggerValidator\Interfaces\ContextDataLoader::loadRequestQuery($paramName)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)


#### Arguments
* $paramName **mixed**



### parseQueryAsPHP

    mixed SwaggerValidator\Common\Context::parseQueryAsPHP($queryString)





* Visibility: **protected**


#### Arguments
* $queryString **mixed**



### parseQueryAsMulti

    mixed SwaggerValidator\Common\Context::parseQueryAsMulti($queryString)





* Visibility: **protected**


#### Arguments
* $queryString **mixed**



### loadRequestHeader

    mixed SwaggerValidator\Interfaces\ContextDataLoader::loadRequestHeader($paramName)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)


#### Arguments
* $paramName **mixed**



### loadResponseHeader

    mixed SwaggerValidator\Interfaces\ContextDataLoader::loadResponseHeader($paramName)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)


#### Arguments
* $paramName **mixed**



### loadRequestBody

    mixed SwaggerValidator\Interfaces\ContextDataLoader::loadRequestBody()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)




### loadResponseBody

    mixed SwaggerValidator\Interfaces\ContextDataLoader::loadResponseBody()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataLoader](SwaggerValidator-Interfaces-ContextDataLoader.md)




### loadBodyByContent

    mixed SwaggerValidator\Interfaces\ContextDataParser::loadBodyByContent($headers, $rawBody)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataParser](SwaggerValidator-Interfaces-ContextDataParser.md)


#### Arguments
* $headers **mixed**
* $rawBody **mixed**



### buildBodyJson

    mixed SwaggerValidator\Interfaces\ContextDataParser::buildBodyJson($contents)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataParser](SwaggerValidator-Interfaces-ContextDataParser.md)


#### Arguments
* $contents **mixed**



### buildBodyXml

    mixed SwaggerValidator\Interfaces\ContextDataParser::buildBodyXml($contents)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextDataParser](SwaggerValidator-Interfaces-ContextDataParser.md)


#### Arguments
* $contents **mixed**



### getSandBoxKeys

    array SwaggerValidator\Common\Context::getSandBoxKeys()

return the list of all params (request/response) validated
used in the end of validation process to check the TOOMANY parameters error



* Visibility: **public**




### setSandBox

    \SwaggerValidator\Common\Context SwaggerValidator\Common\Context::setSandBox()

Adding validated params to check
This method improve the TOOMANY errors at the end
of the validation process



* Visibility: **public**




### getRequestDataKeys

    array SwaggerValidator\Common\Context::getRequestDataKeys()

Method to list all received params name by location



* Visibility: **public**




### checkIsEmpty

    boolean SwaggerValidator\Common\Context::checkIsEmpty(mixed $mixed)

Method to make a empty call usable with function return



* Visibility: **private**


#### Arguments
* $mixed **mixed**



### getEnv

    mixed SwaggerValidator\Common\Context::getEnv(string $name)

Method to add capability of override the getenv function of PHP
for example to get env data in a sandbox



* Visibility: **public**


#### Arguments
* $name **string**



### getRequestHeader

    array SwaggerValidator\Common\Context::getRequestHeader()

Return the header received in the request
Use the apache_request_headers (>= PHP 4.3.0)
and the mocked data if defined
>= PHP 5.4.0 : usable for mod_apache and fastcgi
< PHP 5.4.0 : only available for apache module
>= 5.5.7 : available for PHP CLI



* Visibility: **public**




### getResponseHeader

    array SwaggerValidator\Common\Context::getResponseHeader()

Return the Response header
Use the apache_response_headers (>= PHP 4.3.0)
and the mocked data if defined
>= PHP 5.4.0 : usable for mod_apache and fastcgi
< PHP 5.4.0 : only available for apache module
>= 5.5.7 : available for PHP CLI



* Visibility: **public**




### mock

    mixed SwaggerValidator\Common\Context::mock(array $options)

Method to define a batch of data to be used to
simulate the playback of external data



* Visibility: **public**


#### Arguments
* $options **array**



### cleanParams

    mixed SwaggerValidator\Common\Context::cleanParams()

Used to clean params if validation error occured for mode PASS



* Visibility: **public**




### logLoadFile

    mixed SwaggerValidator\Interfaces\ContextLog::logLoadFile($file, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $file **mixed**
* $method **mixed**
* $line **mixed**



### logDecode

    mixed SwaggerValidator\Interfaces\ContextLog::logDecode($className, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $className **mixed**
* $method **mixed**
* $line **mixed**



### logValidate

    mixed SwaggerValidator\Interfaces\ContextLog::logValidate($className, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $className **mixed**
* $method **mixed**
* $line **mixed**



### logModel

    mixed SwaggerValidator\Interfaces\ContextLog::logModel($method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $method **mixed**
* $line **mixed**



### logReference

    mixed SwaggerValidator\Interfaces\ContextLog::logReference($type, $ref, $oldRef, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $type **mixed**
* $ref **mixed**
* $oldRef **mixed**
* $method **mixed**
* $line **mixed**



### logMessage

    mixed SwaggerValidator\Interfaces\ContextLog::logMessage($type, $message, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $type **mixed**
* $message **mixed**
* $method **mixed**
* $line **mixed**



### logValidationError

    mixed SwaggerValidator\Interfaces\ContextLog::logValidationError($validationType, $messageException, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $validationType **mixed**
* $messageException **mixed**
* $method **mixed**
* $line **mixed**



### logException

    mixed SwaggerValidator\Interfaces\ContextLog::logException($messageException, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $messageException **mixed**
* $method **mixed**
* $line **mixed**



### throwException

    mixed SwaggerValidator\Interfaces\ContextLog::throwException($message, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $message **mixed**
* $method **mixed**
* $line **mixed**



### setValidationError

    mixed SwaggerValidator\Interfaces\ContextLog::setValidationError($valitionType, $messageException, $method, $line)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextLog](SwaggerValidator-Interfaces-ContextLog.md)


#### Arguments
* $valitionType **mixed**
* $messageException **mixed**
* $method **mixed**
* $line **mixed**



### __construct

    mixed SwaggerValidator\Interfaces\ContextBase::__construct($mode, $type)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $mode **mixed**
* $type **mixed**



### formatVarName

    mixed SwaggerValidator\Common\ContextBase::formatVarName($name)





* Visibility: **private**
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)


#### Arguments
* $name **mixed**



### __get

    mixed SwaggerValidator\Interfaces\ContextBase::__get($name)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $name **mixed**



### __set

    mixed SwaggerValidator\Interfaces\ContextBase::__set($name, $value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $name **mixed**
* $value **mixed**



### __isset

    mixed SwaggerValidator\Interfaces\ContextBase::__isset($name)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $name **mixed**



### __unset

    mixed SwaggerValidator\Interfaces\ContextBase::__unset($name)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $name **mixed**



### __toString

    mixed SwaggerValidator\Interfaces\ContextBase::__toString()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### __debugInfo

    mixed SwaggerValidator\Interfaces\ContextBase::__debugInfo()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setMode

    mixed SwaggerValidator\Interfaces\ContextBase::setMode($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getMode

    mixed SwaggerValidator\Interfaces\ContextBase::getMode()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setType

    mixed SwaggerValidator\Interfaces\ContextBase::setType($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getType

    mixed SwaggerValidator\Interfaces\ContextBase::getType()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setLocation

    mixed SwaggerValidator\Interfaces\ContextBase::setLocation($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getLocation

    mixed SwaggerValidator\Interfaces\ContextBase::getLocation()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setMethod

    mixed SwaggerValidator\Interfaces\ContextBase::setMethod($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getMethod

    mixed SwaggerValidator\Interfaces\ContextBase::getMethod()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### loadMethod

    mixed SwaggerValidator\Interfaces\ContextBase::loadMethod()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setBasePath

    mixed SwaggerValidator\Interfaces\ContextBase::setBasePath($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getBasePath

    mixed SwaggerValidator\Interfaces\ContextBase::getBasePath()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setRoutePath

    mixed SwaggerValidator\Interfaces\ContextBase::setRoutePath($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getRoutePath

    mixed SwaggerValidator\Interfaces\ContextBase::getRoutePath()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setRequestPath

    mixed SwaggerValidator\Interfaces\ContextBase::setRequestPath($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getRequestPath

    mixed SwaggerValidator\Interfaces\ContextBase::getRequestPath()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setScheme

    mixed SwaggerValidator\Interfaces\ContextBase::setScheme($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getScheme

    mixed SwaggerValidator\Interfaces\ContextBase::getScheme()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setHost

    mixed SwaggerValidator\Interfaces\ContextBase::setHost($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getHost

    mixed SwaggerValidator\Interfaces\ContextBase::getHost()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### addContext

    mixed SwaggerValidator\Interfaces\ContextBase::addContext($key, $value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $key **mixed**
* $value **mixed**



### getContext

    mixed SwaggerValidator\Interfaces\ContextBase::getContext()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setCombined

    mixed SwaggerValidator\Interfaces\ContextBase::setCombined($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getCombined

    mixed SwaggerValidator\Interfaces\ContextBase::getCombined()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setDataPath

    mixed SwaggerValidator\Interfaces\ContextBase::setDataPath($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getDataPath

    mixed SwaggerValidator\Interfaces\ContextBase::getDataPath()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### getLastDataPath

    mixed SwaggerValidator\Common\ContextBase::getLastDataPath($nb)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)


#### Arguments
* $nb **mixed**



### searchDataPath

    mixed SwaggerValidator\Common\ContextBase::searchDataPath($search, $nb)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)


#### Arguments
* $search **mixed**
* $nb **mixed**



### setExternalRef

    mixed SwaggerValidator\Interfaces\ContextBase::setExternalRef($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getExternalRef

    mixed SwaggerValidator\Interfaces\ContextBase::getExternalRef()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### getLastExternalRef

    mixed SwaggerValidator\Interfaces\ContextBase::getLastExternalRef()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### checkExternalRef

    mixed SwaggerValidator\Interfaces\ContextBase::checkExternalRef($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### setDataCheck

    mixed SwaggerValidator\Interfaces\ContextBase::setDataCheck($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### getDataCheck

    mixed SwaggerValidator\Interfaces\ContextBase::getDataCheck()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setDataValue

    mixed SwaggerValidator\Interfaces\ContextBase::setDataValue($value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)


#### Arguments
* $value **mixed**



### setDataValueExists

    \SwaggerValidator\Common\ContextBase SwaggerValidator\Common\ContextBase::setDataValueExists(boolean $value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)


#### Arguments
* $value **boolean**



### setDataValueEmpty

    \SwaggerValidator\Common\ContextBase SwaggerValidator\Common\ContextBase::setDataValueEmpty(Boolean $value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)


#### Arguments
* $value **Boolean**



### getDataValue

    mixed SwaggerValidator\Interfaces\ContextBase::getDataValue()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### isDataExists

    mixed SwaggerValidator\Interfaces\ContextBase::isDataExists()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### isDataEmpty

    mixed SwaggerValidator\Interfaces\ContextBase::isDataEmpty()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




### setValidationErrorCode

    mixed SwaggerValidator\Common\ContextBase::setValidationErrorCode(\SwaggerValidator\Common\constant $code)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)


#### Arguments
* $code **SwaggerValidator\Common\constant**



### getValidationErrorCode

    mixed SwaggerValidator\Common\ContextBase::getValidationErrorCode()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\ContextBase](SwaggerValidator-Common-ContextBase.md)



