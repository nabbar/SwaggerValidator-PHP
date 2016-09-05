SwaggerValidator\Common\ContextBase
===============

Description of ContextAbstract




* Class name: ContextBase
* Namespace: SwaggerValidator\Common
* This class implements: [SwaggerValidator\Interfaces\ContextBase](SwaggerValidator-Interfaces-ContextBase.md)




Properties
----------


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


### $mockedData

    protected array $mockedData = array()





* Visibility: **protected**


Methods
-------


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


#### Arguments
* $nb **mixed**



### searchDataPath

    mixed SwaggerValidator\Common\ContextBase::searchDataPath($search, $nb)





* Visibility: **public**


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


#### Arguments
* $value **boolean**



### setDataValueEmpty

    \SwaggerValidator\Common\ContextBase SwaggerValidator\Common\ContextBase::setDataValueEmpty(Boolean $value)





* Visibility: **public**


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



