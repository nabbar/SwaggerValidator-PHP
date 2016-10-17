SwaggerValidator\Common\CollectionFile
===============

Description of ReferenceCollection




* Class name: CollectionFile
* Namespace: SwaggerValidator\Common
* Parent class: [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)



Constants
----------


### ID_PREFIX

    const ID_PREFIX = 'file:'





Properties
----------


### $instance

    private \SwaggerValidator\Common\CollectionFile $instance





* Visibility: **private**
* This property is **static**.


### $fileIdList

    private array $fileIdList = array()





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

    mixed SwaggerValidator\Common\CollectionFile::__construct()

Private construct for singleton



* Visibility: **private**




### getInstance

    \SwaggerValidator\Common\CollectionFile SwaggerValidator\Common\CollectionFile::getInstance()





* Visibility: **public**
* This method is **static**.




### setInstance

    mixed SwaggerValidator\Common\CollectionFile::setInstance(\SwaggerValidator\Common\CollectionFile $instance)

replace the singleton of this collection



* Visibility: **public**
* This method is **static**.


#### Arguments
* $instance **[SwaggerValidator\Common\CollectionFile](SwaggerValidator-Common-CollectionFile.md)**



### pruneInstance

    mixed SwaggerValidator\Common\CollectionFile::pruneInstance()





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



### __storeData

    mixed SwaggerValidator\Common\Collection::__storeData($key, $value)

Var Export Method



* Visibility: **protected**
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $key **mixed**
* $value **mixed**



### __set_state

    mixed SwaggerValidator\Common\Collection::__set_state(array $properties)





* Visibility: **public**
* This method is **static**.
* This method is defined by [SwaggerValidator\Common\Collection](SwaggerValidator-Common-Collection.md)


#### Arguments
* $properties **array**



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

    \SwaggerValidator\Common\ReferenceFile SwaggerValidator\Common\CollectionFile::get(\SwaggerValidator\Common\Context $context, string $fileLink)

Return the content of the reference as object or mixed data



* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $fileLink **string**



### set

    mixed SwaggerValidator\Common\CollectionFile::set(\SwaggerValidator\Common\Context $context, $ref, $value)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $ref **mixed**
* $value **mixed**



### getReferenceFileLink

    mixed SwaggerValidator\Common\CollectionFile::getReferenceFileLink($ref)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $ref **mixed**



### getReferenceInnerPath

    mixed SwaggerValidator\Common\CollectionFile::getReferenceInnerPath($ref)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $ref **mixed**



### getIdFromRef

    mixed SwaggerValidator\Common\CollectionFile::getIdFromRef($fullRef)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $fullRef **mixed**



### getRefFromId

    mixed SwaggerValidator\Common\CollectionFile::getRefFromId($id)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $id **mixed**



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


