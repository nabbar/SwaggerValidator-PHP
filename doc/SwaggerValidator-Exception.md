SwaggerValidator\Exception
===============

Description of Exception




* Class name: Exception
* Namespace: SwaggerValidator
* Parent class: Exception





Properties
----------


### $contextError

    private \SwaggerValidator\Common\Context $contextError





* Visibility: **private**


Methods
-------


### init

    mixed SwaggerValidator\Exception::init($message, $context, $file, $line)





* Visibility: **public**


#### Arguments
* $message **mixed**
* $context **mixed**
* $file **mixed**
* $line **mixed**



### newException

    mixed SwaggerValidator\Exception::newException($message, $context, $file, $line)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $message **mixed**
* $context **mixed**
* $file **mixed**
* $line **mixed**



### throwNewException

    mixed SwaggerValidator\Exception::throwNewException($message, $context, $file, $line)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $message **mixed**
* $context **mixed**
* $file **mixed**
* $line **mixed**



### setFile

    mixed SwaggerValidator\Exception::setFile($file)





* Visibility: **public**


#### Arguments
* $file **mixed**



### setLine

    mixed SwaggerValidator\Exception::setLine($line)





* Visibility: **public**


#### Arguments
* $line **mixed**



### setContext

    mixed SwaggerValidator\Exception::setContext($context)





* Visibility: **public**


#### Arguments
* $context **mixed**



### getContext

    mixed SwaggerValidator\Exception::getContext()





* Visibility: **public**



