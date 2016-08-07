SwaggerValidator\Common\Factory
===============

Description of Factory




* Class name: Factory
* Namespace: SwaggerValidator\Common
* Parent class: [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)





Properties
----------


### $instance

    private \SwaggerValidator\Common\Factory $instance





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

    mixed SwaggerValidator\Common\Factory::__construct()

Private construct for singleton



* Visibility: **private**




### getInstance

    \SwaggerValidator\Common\Factory SwaggerValidator\Common\Factory::getInstance()

get the singleton of this collection



* Visibility: **public**
* This method is **static**.




### setInstance

    mixed SwaggerValidator\Common\Factory::setInstance(\SwaggerValidator\Common\Factory $instance)

replace the singleton of this collection



* Visibility: **public**
* This method is **static**.


#### Arguments
* $instance **[SwaggerValidator\Common\Factory](SwaggerValidator-Common-Factory.md)**



### pruneInstance

    mixed SwaggerValidator\Common\Factory::pruneInstance()

prune the singleton of this collection



* Visibility: **public**
* This method is **static**.




### getClass

    mixed SwaggerValidator\Common\Factory::getClass(callable $type)

Check if the type is defined and return his callable string



* Visibility: **private**


#### Arguments
* $type **callable**



### __get

    mixed SwaggerValidator\Common\Collection::__get($key)





* Visibility: **public**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**



### invoke

    object SwaggerValidator\Common\Factory::invoke(string $type, \SwaggerValidator\Common\type $parameters)

Start new instance of the object type



* Visibility: **public**


#### Arguments
* $type **string** - &lt;p&gt;the name of the object type for the new instance&lt;/p&gt;
* $parameters **SwaggerValidator\Common\type** - &lt;p&gt;[optional] the parameters to the constructor&lt;/p&gt;



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

    object SwaggerValidator\Common\Factory::get(string $type)

return an instance of the given type



* Visibility: **public**


#### Arguments
* $type **string**



### set

    mixed SwaggerValidator\Common\Factory::set(string $type, object|\Closure $object)

Register the base instance to be clone when a new instance is call



* Visibility: **public**


#### Arguments
* $type **string**
* $object **object|Closure**



### normalizeType

    mixed SwaggerValidator\Common\Factory::normalizeType($type)





* Visibility: **public**


#### Arguments
* $type **mixed**



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


