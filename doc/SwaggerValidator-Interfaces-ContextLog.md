SwaggerValidator\Interfaces\ContextLog
===============






* Interface name: ContextLog
* Namespace: SwaggerValidator\Interfaces
* This is an **interface**






Methods
-------


### logLoadFile

    mixed SwaggerValidator\Interfaces\ContextLog::logLoadFile($file, $method, $line)





* Visibility: **public**


#### Arguments
* $file **mixed**
* $method **mixed**
* $line **mixed**



### logDecode

    mixed SwaggerValidator\Interfaces\ContextLog::logDecode($className, $method, $line)





* Visibility: **public**


#### Arguments
* $className **mixed**
* $method **mixed**
* $line **mixed**



### logValidate

    mixed SwaggerValidator\Interfaces\ContextLog::logValidate($className, $method, $line)





* Visibility: **public**


#### Arguments
* $className **mixed**
* $method **mixed**
* $line **mixed**



### logModel

    mixed SwaggerValidator\Interfaces\ContextLog::logModel($method, $line)





* Visibility: **public**


#### Arguments
* $method **mixed**
* $line **mixed**



### logReference

    mixed SwaggerValidator\Interfaces\ContextLog::logReference($type, $ref, $oldRef, $method, $line)





* Visibility: **public**


#### Arguments
* $type **mixed**
* $ref **mixed**
* $oldRef **mixed**
* $method **mixed**
* $line **mixed**



### logMessage

    mixed SwaggerValidator\Interfaces\ContextLog::logMessage($type, $message, $method, $line)





* Visibility: **public**


#### Arguments
* $type **mixed**
* $message **mixed**
* $method **mixed**
* $line **mixed**



### logValidationError

    mixed SwaggerValidator\Interfaces\ContextLog::logValidationError($validationType, $messageException, $method, $line)





* Visibility: **public**


#### Arguments
* $validationType **mixed**
* $messageException **mixed**
* $method **mixed**
* $line **mixed**



### logException

    mixed SwaggerValidator\Interfaces\ContextLog::logException($messageException, $method, $line)





* Visibility: **public**


#### Arguments
* $messageException **mixed**
* $method **mixed**
* $line **mixed**



### throwException

    mixed SwaggerValidator\Interfaces\ContextLog::throwException($message, $method, $line)





* Visibility: **public**


#### Arguments
* $message **mixed**
* $method **mixed**
* $line **mixed**



### setValidationError

    mixed SwaggerValidator\Interfaces\ContextLog::setValidationError($valitionType, $messageException, $method, $line)





* Visibility: **public**


#### Arguments
* $valitionType **mixed**
* $messageException **mixed**
* $method **mixed**
* $line **mixed**


