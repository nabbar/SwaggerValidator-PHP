SwaggerValidator\Common\ReferenceItem
===============

Description of ReferenceItem




* Class name: ReferenceItem
* Namespace: SwaggerValidator\Common





Properties
----------


### $contents

    private mixed $contents





* Visibility: **private**


### $object

    private mixed $object





* Visibility: **private**


Methods
-------


### __construct

    mixed SwaggerValidator\Common\ReferenceItem::__construct()





* Visibility: **public**




### setJsonData

    mixed SwaggerValidator\Common\ReferenceItem::setJsonData($jsonData)





* Visibility: **public**


#### Arguments
* $jsonData **mixed**



### __get

    mixed SwaggerValidator\Common\ReferenceItem::__get($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### __storeData

    mixed SwaggerValidator\Common\ReferenceItem::__storeData($key, $value)

Var Export Method



* Visibility: **protected**


#### Arguments
* $key **mixed**
* $value **mixed**



### __set_state

    mixed SwaggerValidator\Common\ReferenceItem::__set_state(array $properties)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $properties **array**



### extractAllReferences

    mixed SwaggerValidator\Common\ReferenceItem::extractAllReferences(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### extractReferenceArray

    mixed SwaggerValidator\Common\ReferenceItem::extractReferenceArray(\SwaggerValidator\Common\Context $context, array $array)





* Visibility: **private**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $array **array**



### extractReferenceObject

    mixed SwaggerValidator\Common\ReferenceItem::extractReferenceObject(\SwaggerValidator\Common\Context $context, \stdClass $stdClass)





* Visibility: **private**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $stdClass **stdClass**



### getJson

    mixed SwaggerValidator\Common\ReferenceItem::getJson(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### getObject

    mixed SwaggerValidator\Common\ReferenceItem::getObject(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### getCleanClass

    mixed SwaggerValidator\Common\ReferenceItem::getCleanClass($class)





* Visibility: **protected**


#### Arguments
* $class **mixed**



### jsonUnSerialize

    mixed SwaggerValidator\Common\ReferenceItem::jsonUnSerialize(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**


