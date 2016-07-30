SwaggerValidator\Common\CollectionReference
===============

Description of ReferenceCollection




* Class name: CollectionReference
* Namespace: SwaggerValidator\Common
* Parent class: [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)



Constants
----------


### ID_PREFIX

    const ID_PREFIX = 'id:'





Properties
----------


### $instance

    private \SwaggerValidator\Common\CollectionReference $instance





* Visibility: **private**
* This property is **static**.


### $refIdList

    private array $refIdList = array()





* Visibility: **private**
* This property is **static**.


### $refIdDefinitions

    private array $refIdDefinitions = array()





* Visibility: **private**
* This property is **static**.


### $collection

    private array $collection = array()





* Visibility: **private**


### $originTypeArray

    protected boolean $originTypeArray = false





* Visibility: **protected**


Methods
-------


### __construct

    mixed SwaggerValidator\Common\CollectionReference::__construct()

Private construct for singleton



* Visibility: **private**




### getInstance

    \SwaggerValidator\Common\CollectionReference SwaggerValidator\Common\CollectionReference::getInstance()

get the singleton of this collection



* Visibility: **public**
* This method is **static**.




### setInstance

    mixed SwaggerValidator\Common\CollectionReference::setInstance(\SwaggerValidator\Common\CollectionReference $instance)

replace the singleton of this collection



* Visibility: **public**
* This method is **static**.


#### Arguments
* $instance **[SwaggerValidator\Common\CollectionReference](SwaggerValidator-Common-CollectionReference.md)**



### prune

    mixed SwaggerValidator\Common\CollectionReference::prune()

prune the singleton of this collection



* Visibility: **public**
* This method is **static**.




### __isset

    mixed SwaggerValidator\Common\Collection::__isset($key)

Property Overloading



* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**



### __unset

    mixed SwaggerValidator\Common\Collection::__unset($key)





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



### get

    \SwaggerValidator\Common\ReferenceItem SwaggerValidator\Common\CollectionReference::get(string $ref)

Return the content of the reference as object or mixed data



* Visibility: **public**


#### Arguments
* $ref **string**



### set

    mixed SwaggerValidator\Common\CollectionReference::set($ref, $value)





* Visibility: **public**


#### Arguments
* $ref **mixed**
* $value **mixed**



### getIdFromRef

    mixed SwaggerValidator\Common\CollectionReference::getIdFromRef($fullRef)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $fullRef **mixed**



### getRefFromId

    mixed SwaggerValidator\Common\CollectionReference::getRefFromId($id)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $id **mixed**



### registerDefinition

    mixed SwaggerValidator\Common\CollectionReference::registerDefinition($fullRef)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $fullRef **mixed**



### cleanReferenceDefinitions

    mixed SwaggerValidator\Common\CollectionReference::cleanReferenceDefinitions()





* Visibility: **public**




### unserializeReferenceDefinitions

    mixed SwaggerValidator\Common\CollectionReference::unserializeReferenceDefinitions(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



### getDefinitions

    mixed SwaggerValidator\Common\CollectionReference::getDefinitions()





* Visibility: **public**
* This method is **static**.




### jsonUnSerialize

    mixed SwaggerValidator\Common\CollectionReference::jsonUnSerialize(\SwaggerValidator\Common\Context $context)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**



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


