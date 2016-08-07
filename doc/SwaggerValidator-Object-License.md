SwaggerValidator\Object\License
===============

Description of License




* Class name: License
* Namespace: SwaggerValidator\Object
* Parent class: [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)





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




### jsonUnSerialize

    mixed SwaggerValidator\Common\CollectionSwagger::jsonUnSerialize(\SwaggerValidator\Common\Context $context, string $jsonData)





* Visibility: **public**
* This method is **abstract**.
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $jsonData **string** - &lt;p&gt;The Json Data to be unserialized&lt;/p&gt;



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



### getModelGeneric

    mixed SwaggerValidator\Common\CollectionSwagger::getModelGeneric(\SwaggerValidator\Common\Context $context, $generalItems, $typeKey)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $generalItems **mixed**
* $typeKey **mixed**



### getModelConsumeProduce

    mixed SwaggerValidator\Common\CollectionSwagger::getModelConsumeProduce($generalItems)





* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $generalItems **mixed**



### checkJsonObject

    boolean SwaggerValidator\Common\CollectionSwagger::checkJsonObject(\SwaggerValidator\Common\Context $context, \stdClass $jsonData)

Check that entry JsonData is an object of stdClass



* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $jsonData **stdClass**



### checkJsonObjectOrArray

    boolean SwaggerValidator\Common\CollectionSwagger::checkJsonObjectOrArray(\SwaggerValidator\Common\Context $context, \stdClass $jsonData)

Check that entry JsonData is an object of stdClass or an array



* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $jsonData **stdClass**



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



### throwException

    mixed SwaggerValidator\Common\Collection::throwException(string $message, mixed $context, $method, $line)

Throw a new \SwaggerValidator\Exception with automatic find method, line, .

..

* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $message **string**
* $context **mixed**
* $method **mixed**
* $line **mixed**


