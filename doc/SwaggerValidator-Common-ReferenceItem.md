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

    mixed SwaggerValidator\Common\ReferenceItem::__construct($jsonData)





* Visibility: **public**


#### Arguments
* $jsonData **mixed**



### __get

    mixed SwaggerValidator\Common\ReferenceItem::__get($name)





* Visibility: **public**


#### Arguments
* $name **mixed**



### extractAllReferences

    mixed SwaggerValidator\Common\ReferenceItem::extractAllReferences()





* Visibility: **public**




### extractReferenceArray

    mixed SwaggerValidator\Common\ReferenceItem::extractReferenceArray(array $array)





* Visibility: **private**


#### Arguments
* $array **array**



### extractReferenceObject

    mixed SwaggerValidator\Common\ReferenceItem::extractReferenceObject(\stdClass $stdClass)





* Visibility: **private**


#### Arguments
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

    mixed SwaggerValidator\Common\ReferenceItem::jsonUnSerialize(\SwaggerValidator\Common\Context $context, $force)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $force **mixed**


