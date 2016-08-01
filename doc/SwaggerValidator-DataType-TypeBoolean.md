SwaggerValidator\DataType\TypeBoolean
===============

Description of Boolean




* Class name: TypeBoolean
* Namespace: SwaggerValidator\DataType
* Parent class: [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)





Properties
----------


### $mandatoryKeys

    private array $mandatoryKeys = array()





* Visibility: **private**


### $collection

    private array $collection = array()





* Visibility: **private**


### $originTypeArray

    protected boolean $originTypeArray = false





* Visibility: **protected**


Methods
-------


### __construct

    mixed SwaggerValidator\Common\CollectionSwagger::__construct()





* Visibility: **public**
* This method is **abstract**.
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)




### validate

    mixed SwaggerValidator\DataType\TypeBoolean::validate(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### format

    mixed SwaggerValidator\DataType\TypeCommon::format(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### type

    mixed SwaggerValidator\DataType\TypeCommon::type(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### getExampleFormat

    mixed SwaggerValidator\DataType\TypeCommon::getExampleFormat(\SwaggerValidator\Common\Context $context)





* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### getExampleType

    mixed SwaggerValidator\DataType\TypeCommon::getExampleType(\SwaggerValidator\Common\Context $context)





* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### jsonUnSerialize

    mixed SwaggerValidator\Common\CollectionSwagger::jsonUnSerialize(\SwaggerValidator\Common\Context $context, string $jsonData)





* Visibility: **public**
* This method is **abstract**.
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $jsonData **string** - &lt;p&gt;The Json Data to be unserialized&lt;/p&gt;



### isRequired

    mixed SwaggerValidator\DataType\TypeCommon::isRequired()





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)




### pattern

    mixed SwaggerValidator\DataType\TypeCommon::pattern(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### allowEmptyValue

    mixed SwaggerValidator\DataType\TypeCommon::allowEmptyValue(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### hasFormat

    mixed SwaggerValidator\DataType\TypeCommon::hasFormat()





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)




### hasDefault

    mixed SwaggerValidator\DataType\TypeCommon::hasDefault()





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)




### getDefault

    mixed SwaggerValidator\DataType\TypeCommon::getDefault(\SwaggerValidator\Common\Context $context)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### hasExample

    mixed SwaggerValidator\DataType\TypeCommon::hasExample()





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)




### getExample

    mixed SwaggerValidator\DataType\TypeCommon::getExample(\SwaggerValidator\Common\Context $context)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### hasEnum

    mixed SwaggerValidator\DataType\TypeCommon::hasEnum()





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)




### getModel

    mixed SwaggerValidator\DataType\TypeCommon::getModel(\SwaggerValidator\Common\Context $context)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### enum

    mixed SwaggerValidator\DataType\TypeCommon::enum(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### multipleOf

    mixed SwaggerValidator\DataType\TypeCommon::multipleOf(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### minimum

    mixed SwaggerValidator\DataType\TypeCommon::minimum(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### maximum

    mixed SwaggerValidator\DataType\TypeCommon::maximum(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### minLength

    mixed SwaggerValidator\DataType\TypeCommon::minLength(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### maxLength

    mixed SwaggerValidator\DataType\TypeCommon::maxLength(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### minItems

    mixed SwaggerValidator\DataType\TypeCommon::minItems(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### maxItems

    mixed SwaggerValidator\DataType\TypeCommon::maxItems(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### uniqueItems

    mixed SwaggerValidator\DataType\TypeCommon::uniqueItems(\SwaggerValidator\Common\Context $context, $valueParams)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $valueParams **mixed**



### collectionFormat

    mixed SwaggerValidator\DataType\TypeCommon::collectionFormat(\SwaggerValidator\Common\Context $context)





* Visibility: **public**
* This method is defined by [SwaggerValidator\DataType\TypeCommon](SwaggerValidator-DataType-TypeCommon.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### callException

    mixed SwaggerValidator\Common\CollectionSwagger::callException($message, $context)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $message **mixed**
* $context **mixed**



### buildException

    mixed SwaggerValidator\Common\CollectionSwagger::buildException($message, $context)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $message **mixed**
* $context **mixed**



### registerMandatoryKey

    mixed SwaggerValidator\Common\CollectionSwagger::registerMandatoryKey(string $key)

List of keys mandatory for the current object type



* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $key **string**



### checkMandatoryKey

    boolean|string SwaggerValidator\Common\CollectionSwagger::checkMandatoryKey()

Return true if all mandatory keys are defined or the missing key name



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)




### getCleanClass

    mixed SwaggerValidator\Common\CollectionSwagger::getCleanClass($class)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $class **mixed**



### extractNonRecursiveReference

    mixed SwaggerValidator\Common\CollectionSwagger::extractNonRecursiveReference(\SwaggerValidator\Common\Context $context, $jsonData)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $jsonData **mixed**



### registerRecursiveDefinitions

    mixed SwaggerValidator\Common\CollectionSwagger::registerRecursiveDefinitions($jsonData)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $jsonData **mixed**



### registerRecursiveDefinitionsFromObject

    mixed SwaggerValidator\Common\CollectionSwagger::registerRecursiveDefinitionsFromObject(\stdClass $jsonData)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $jsonData **stdClass**



### registerRecursiveDefinitionsFromArray

    mixed SwaggerValidator\Common\CollectionSwagger::registerRecursiveDefinitionsFromArray($jsonData)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $jsonData **mixed**



### get

    mixed SwaggerValidator\Common\CollectionSwagger::get(string $key)

Return the content of the reference as object or mixed data



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $key **string**



### set

    mixed SwaggerValidator\Common\CollectionSwagger::set($key, $value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $key **mixed**
* $value **mixed**



### __isset

    mixed SwaggerValidator\Common\Collection::__isset($key)

Property Overloading



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**



### __get

    mixed SwaggerValidator\Common\Collection::__get($key)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**



### __set

    mixed SwaggerValidator\Common\Collection::__set($key, $value)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**
* $value **mixed**



### __unset

    mixed SwaggerValidator\Common\Collection::__unset($key)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**



### offsetSet

    mixed SwaggerValidator\Common\Collection::offsetSet($key, $value)

Array Access



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**
* $value **mixed**



### offsetExists

    mixed SwaggerValidator\Common\Collection::offsetExists($key)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**



### offsetUnset

    mixed SwaggerValidator\Common\Collection::offsetUnset($key)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**



### offsetGet

    mixed SwaggerValidator\Common\Collection::offsetGet($key)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**



### getIterator

    mixed SwaggerValidator\Common\Collection::getIterator()

IteratorAggregate



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)




### count

    mixed SwaggerValidator\Common\Collection::count()

Countable



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)




### setJSONIsArray

    mixed SwaggerValidator\Common\Collection::setJSONIsArray()





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)




### jsonSerialize

    mixed SwaggerValidator\Common\Collection::jsonSerialize()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)




### serialize

    mixed SwaggerValidator\Common\Collection::serialize()





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)




### unserialize

    mixed SwaggerValidator\Common\Collection::unserialize($data)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $data **mixed**



### all

    array SwaggerValidator\Common\Collection::all()

Fetch set data



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)




### keys

    array SwaggerValidator\Common\Collection::keys()

Fetch set data keys



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)




### has

    boolean SwaggerValidator\Common\Collection::has(string $key)

Does this set contain a key?



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **string** - &lt;p&gt;The data key&lt;/p&gt;



### remove

    mixed SwaggerValidator\Common\Collection::remove(string $key)

Remove value with key from this set



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **string** - &lt;p&gt;The data key&lt;/p&gt;



### clear

    mixed SwaggerValidator\Common\Collection::clear()

Clear all values



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)




### jsonEncode

    mixed SwaggerValidator\Common\Collection::jsonEncode($mixed)





* Visibility: **public**
* This method is **static**.
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $mixed **mixed**



### jsonEncodePretty

    mixed SwaggerValidator\Common\Collection::jsonEncodePretty($mixed)





* Visibility: **public**
* This method is **static**.
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $mixed **mixed**


