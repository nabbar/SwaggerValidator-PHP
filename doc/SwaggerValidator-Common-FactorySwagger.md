SwaggerValidator\Common\FactorySwagger
===============

Description of FactorySwagger




* Class name: FactorySwagger
* Namespace: SwaggerValidator\Common



Constants
----------


### TYPE_STRING

    const TYPE_STRING = 'string'





### TYPE_NUMBER

    const TYPE_NUMBER = 'number'





### TYPE_BOOLEAN

    const TYPE_BOOLEAN = 'boolean'





### TYPE_INTEGER

    const TYPE_INTEGER = 'integer'





### TYPE_ARRAY

    const TYPE_ARRAY = 'array'





### TYPE_FILE

    const TYPE_FILE = 'file'





### TYPE_OBJECT

    const TYPE_OBJECT = 'object'





### KEY_ADDPROPERTIES

    const KEY_ADDPROPERTIES = 'additionalProperties'





### KEY_ADDITEMS

    const KEY_ADDITEMS = 'additionalItems'





### KEY_ALLOF

    const KEY_ALLOF = 'allOf'





### KEY_ANYOF

    const KEY_ANYOF = 'anyOf'





### KEY_CONSUMES

    const KEY_CONSUMES = 'consumes'





### KEY_DEFAULT

    const KEY_DEFAULT = 'default'





### KEY_DEFINITIONS

    const KEY_DEFINITIONS = 'definitions'





### KEY_EXTERNALDOCS

    const KEY_EXTERNALDOCS = 'externalDocs'





### KEY_FLOW

    const KEY_FLOW = 'flow'





### KEY_HEADERS

    const KEY_HEADERS = 'headers'





### KEY_IN

    const KEY_IN = 'in'





### KEY_ITEMS

    const KEY_ITEMS = 'items'





### KEY_NAME

    const KEY_NAME = 'name'





### KEY_NOT

    const KEY_NOT = 'not'





### KEY_ONEOF

    const KEY_ONEOF = 'oneOf'





### KEY_PARAMETERS

    const KEY_PARAMETERS = 'parameters'





### KEY_PATHS

    const KEY_PATHS = 'paths'





### KEY_PRODUCES

    const KEY_PRODUCES = 'produces'





### KEY_PROPERTIES

    const KEY_PROPERTIES = 'properties'





### KEY_REQUIRED

    const KEY_REQUIRED = 'required'





### KEY_REFERENCE

    const KEY_REFERENCE = '$ref'





### KEY_RESPONSES

    const KEY_RESPONSES = 'responses'





### KEY_SCHEMA

    const KEY_SCHEMA = 'schema'





### KEY_SCOPE

    const KEY_SCOPE = 'scopes'





### KEY_TYPE

    const KEY_TYPE = 'type'





### KEY_TAGS

    const KEY_TAGS = 'tags'





### KEY_CUSTOM_PATTERN

    const KEY_CUSTOM_PATTERN = 'x-'





### LOCATION_HEADER

    const LOCATION_HEADER = 'header'





### LOCATION_PATH

    const LOCATION_PATH = 'path'





### LOCATION_QUERY

    const LOCATION_QUERY = 'query'





### LOCATION_BODY

    const LOCATION_BODY = 'body'





### LOCATION_FORM

    const LOCATION_FORM = 'formData'





Properties
----------


### $keyToObject

    private array $keyToObject = array('contact' => 'Contact', 'definitions' => 'Definitions', 'externalDocs' => 'ExternalDocs', 'headers' => 'Headers', 'info' => 'Info', 'license' => 'License', 'paths' => 'Paths', 'parameters' => 'Parameters', 'responses' => 'Responses', 'schema' => '', 'security' => 'Security', 'securityDefinitions' => 'SecurityDefinitions', 'oneOf' => 'TypeCombined', 'anyOf' => 'TypeCombined', 'allOf' => 'TypeCombined', 'not' => 'TypeCombined', 'properties' => 'TypeObject', 'scopes' => '')

The default list of matching key and type
Empty value must have a specific build part



* Visibility: **private**
* This property is **static**.


### $originObjectToChildObject

    private array $originObjectToChildObject = array('Headers' => '', 'PathItem' => 'Operation', 'Paths' => 'PathItem', 'Parameters' => '', 'Responses' => 'ResponseItem', 'SecurityDefinitions' => '', 'Security' => 'SecurityItem', 'TypeArray' => '')

The default list of matching origin Type and child type
Empty value must have a specific build part



* Visibility: **private**
* This property is **static**.


### $securityObjectHasScope

    private array $securityObjectHasScope = array('OAuth2AccessCodeSecurity', 'OAuth2ApplicationSecurity', 'OAuth2ImplicitSecurity', 'OAuth2PasswordSecurity')

The list of origin object type that need matching scope key



* Visibility: **private**
* This property is **static**.


### $instance

    private \SwaggerValidator\Common\FactorySwagger $instance





* Visibility: **private**
* This property is **static**.


Methods
-------


### __construct

    mixed SwaggerValidator\Common\FactorySwagger::__construct()

Private construct for singleton



* Visibility: **private**




### getInstance

    \SwaggerValidator\Common\FactorySwagger SwaggerValidator\Common\FactorySwagger::getInstance()

get the singleton of this collection



* Visibility: **public**
* This method is **static**.




### setInstance

    mixed SwaggerValidator\Common\FactorySwagger::setInstance(\SwaggerValidator\Common\FactorySwagger $instance)

replace the singleton of this collection



* Visibility: **public**
* This method is **static**.


#### Arguments
* $instance **[SwaggerValidator\Common\FactorySwagger](SwaggerValidator-Common-FactorySwagger.md)**



### pruneInstance

    mixed SwaggerValidator\Common\FactorySwagger::pruneInstance()

prune the singleton of this collection



* Visibility: **public**
* This method is **static**.




### throwException

    mixed SwaggerValidator\Common\FactorySwagger::throwException(string $message, mixed $context, $file, $line)

Throw a new \SwaggerValidator\Exception with automatic find method, line, .

..

* Visibility: **protected**


#### Arguments
* $message **string**
* $context **mixed**
* $file **mixed**
* $line **mixed**



### jsonUnSerialize

    mixed SwaggerValidator\Common\FactorySwagger::jsonUnSerialize(\SwaggerValidator\Common\Context $context, $originType, $originKey, $jsonData)





* Visibility: **public**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $originType **mixed**
* $originKey **mixed**
* $jsonData **mixed**



### returnBuildObject

    mixed SwaggerValidator\Common\FactorySwagger::returnBuildObject(\SwaggerValidator\Common\Context $context, \SwaggerValidator\Common\CollectionSwagger $object, $originType, $originKey, $jsonData)





* Visibility: **protected**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $object **[SwaggerValidator\Common\CollectionSwagger](SwaggerValidator-Common-CollectionSwagger.md)**
* $originType **mixed**
* $originKey **mixed**
* $jsonData **mixed**



### buildObjectFromOriginObject

    mixed SwaggerValidator\Common\FactorySwagger::buildObjectFromOriginObject(\SwaggerValidator\Common\Context $context, $originType, $originKey, $jsonData)





* Visibility: **protected**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $originType **mixed**
* $originKey **mixed**
* $jsonData **mixed**



### buildObjectFromOriginKey

    mixed SwaggerValidator\Common\FactorySwagger::buildObjectFromOriginKey(\SwaggerValidator\Common\Context $context, $originType, $originKey, $jsonData)





* Visibility: **protected**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $originType **mixed**
* $originKey **mixed**
* $jsonData **mixed**



### buildPrimitive

    mixed SwaggerValidator\Common\FactorySwagger::buildPrimitive(\SwaggerValidator\Common\Context $context, $originType, $originKey, $jsonData)





* Visibility: **protected**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $originType **mixed**
* $originKey **mixed**
* $jsonData **mixed**



### getPrimitiveType

    mixed SwaggerValidator\Common\FactorySwagger::getPrimitiveType(\SwaggerValidator\Common\Context $context, $jsonData)





* Visibility: **protected**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $jsonData **mixed**



### extractReference

    mixed SwaggerValidator\Common\FactorySwagger::extractReference(\SwaggerValidator\Common\Context $context, $jsonData)





* Visibility: **protected**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $jsonData **mixed**



### SecurityDefinition

    mixed SwaggerValidator\Common\FactorySwagger::SecurityDefinition(\SwaggerValidator\Common\Context $context, $jsonData)





* Visibility: **protected**


#### Arguments
* $context **[SwaggerValidator\Common\Context](SwaggerValidator-Common-Context.md)**
* $jsonData **mixed**


