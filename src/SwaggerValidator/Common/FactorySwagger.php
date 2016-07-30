<?php

/*
 * Copyright 2016 Nicolas JUHEL <swaggervalidator@nabbar.com>.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace SwaggerValidator\Common;

/**
 * Description of FactorySwagger
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class FactorySwagger
{

    /**
     * Primitive Type
     */
    const TYPE_STRING  = 'string';
    const TYPE_NUMBER  = 'number';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_INTEGER = 'integer';
    const TYPE_ARRAY   = 'array';
    const TYPE_FILE    = 'file';
    const TYPE_OBJECT  = 'object';

    /**
     * Specific Key
     */
    const KEY_ADDPROPERTIES = 'additionalProperties';
    const KEY_ADDITEMS      = 'additionalItems';
    const KEY_ALLOF         = 'allOf';
    const KEY_ANYOF         = 'anyOf';
    const KEY_CONSUMES      = 'consumes';
    const KEY_DEFAULT       = 'default';
    const KEY_DEFINITIONS   = 'definitions';
    const KEY_FLOW          = 'flow';
    const KEY_HEADERS       = 'headers';
    const KEY_IN            = 'in';
    const KEY_ITEMS         = 'items';
    const KEY_NAME          = 'name';
    const KEY_NOT           = 'not';
    const KEY_ONEOF         = 'oneOf';
    const KEY_PARAMETERS    = 'parameters';
    const KEY_PATHS         = 'paths';
    const KEY_PRODUCES      = 'produces';
    const KEY_PROPERTIES    = 'properties';
    const KEY_REQUIRED      = 'required';
    const KEY_REFERENCE     = '$ref';
    const KEY_RESPONSES     = 'responses';
    const KEY_SCHEMA        = 'schema';
    const KEY_SCOPE         = 'scopes';
    const KEY_TYPE          = 'type';

    /**
     * Constant for identify custom properties
     */
    const KEY_CUSTOM_PATTERN = 'x-';

    /**
     * location parameters
     */
    const LOCATION_HEADER = 'header';
    const LOCATION_PATH   = 'path';
    const LOCATION_QUERY  = 'query';
    const LOCATION_BODY   = 'body';
    const LOCATION_FORM   = 'formData';

    /**
     * The default list of matching key and type
     * Empty value must have a specific build part
     * @var array
     */
    private static $keyToObject = array(
        'contact'             => 'Contact',
        'definitions'         => 'Definitions',
        'externalDocs'        => 'ExternalDocs',
        'info'                => 'Info',
        'license'             => 'License',
        'paths'               => 'Paths',
        'parameters'          => 'Parameters',
        'responses'           => 'Responses',
        'schema'              => '',
        'security'            => 'Security',
        'securityDefinitions' => 'SecurityDefinitions',
        'oneOf'               => 'TypeCombined',
        'anyOf'               => 'TypeCombined',
        'allOf'               => 'TypeCombined',
        'not'                 => 'TypeCombined',
        'properties'          => 'TypeObject',
        'scopes'              => '',
    );

    /**
     * The default list of matching origin Type and child type
     * Empty value must have a specific build part
     * @var array
     */
    private static $originObjectToChildObject = array(
        'Headers'             => '',
        'PathItem'            => 'Operation',
        'Paths'               => 'PathItem',
        'Parameters'          => '',
        'Responses'           => 'ResponseItem',
        'SecurityDefinitions' => '',
        'Security'            => 'SecurityItem',
        'TypeArray'           => '',
    );

    /**
     * The list of origin object type that need matching scope key
     * @var array
     */
    private static $securityObjectHasScope = array(
        'OAuth2AccessCodeSecurity', 'OAuth2ApplicationSecurity', 'OAuth2ImplicitSecurity', 'OAuth2PasswordSecurity'
    );

    /**
     *
     * @var \SwaggerValidator\Common\FactorySwagger
     */
    private static $instance;

    /**
     * Private construct for singleton
     */
    private function __construct()
    {

    }

    /**
     * get the singleton of this collection
     * @return \SwaggerValidator\Common\FactorySwagger
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * replace the singleton of this collection
     */
    public static function setInstance(\SwaggerValidator\Common\FactorySwagger $instance)
    {
        self::$instance = $instance;
    }

    /**
     * prune the singleton of this collection
     */
    public static function pruneInstance()
    {
        self::$instance = null;
    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $originType, $originKey, &$jsonData)
    {
        $keyType = self::KEY_TYPE;

        if (array_key_exists($originKey, self::$keyToObject)) {
            return $this->buildObjectFromOriginKey($context, $originType, $originKey, $jsonData);
        }

        if (array_key_exists($originType, self::$originObjectToChildObject)) {
            return $this->buildObjectFromOriginObject($context, $originType, $originKey, $jsonData);
        }

        if (is_object($jsonData) && property_exists($jsonData, $keyType)) {
            return $this->buildPrimitive($context, $originType, $originKey, $jsonData);
        }

        if (is_object($jsonData) && property_exists($jsonData, self::KEY_REFERENCE)) {
            return $this->returnBuildObject($context, \SwaggerValidator\Common\Factory::getInstance()->Reference, $originType, $originKey, $jsonData);
        }

        if (is_object($jsonData) && $originType !== 'Swagger' && $originType !== 'TypeObject') {
            \SwaggerValidator\Exception::throwNewException('Cannot identify the object builder for the given JSON Data', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }
        elseif (is_object($jsonData) && $originType === 'TypeObject') {
            return $this->returnBuildObject($context, \SwaggerValidator\Common\Factory::getInstance()->TypeObject, $originType, $originKey, $jsonData);
        }

        return $jsonData;
    }

    protected function returnBuildObject(\SwaggerValidator\Common\Context $context, \SwaggerValidator\Common\CollectionSwagger $object, $originType, $originKey, &$jsonData)
    {
        $object->jsonUnSerialize($context, $jsonData);
        $missingKey = $object->checkMandatoryKey();

        if ($missingKey !== true) {
            \SwaggerValidator\Exception::throwNewException('Missing Key "' . $missingKey . '" from this original type "' . $originType . '" and key "' . $originKey . '"', array('context' => $context, 'SwaggerObject' => $object), __FILE__, __LINE__);
        }

        return $object;
    }

    protected function buildObjectFromOriginObject(\SwaggerValidator\Common\Context $context, $originType, $originKey, &$jsonData)
    {
        $keyIn   = self::KEY_IN;
        $keyName = self::KEY_NAME;
        $object  = null;

        if (!empty(self::$originObjectToChildObject[$originType])) {
            $type   = self::$originObjectToChildObject[$originType];
            $object = \SwaggerValidator\Common\Factory::getInstance()->$type;
        }

        switch ($originType) {
            case 'Parameters':
                if (!is_object($jsonData) || !property_exists($jsonData, $keyIn)) {
                    \SwaggerValidator\Exception::throwNewException('Parameters Item have no "in" keys', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
                }

                if ($jsonData->$keyIn == self::LOCATION_BODY) {
                    $object = \SwaggerValidator\Common\Factory::getInstance()->ParameterBody;
                }
                else {
                    $objectType       = $this->getPrimitiveType($context, $jsonData);
                    $object           = \SwaggerValidator\Common\Factory::getInstance()->$objectType;
                    $object->$keyName = $originKey;
                }
                break;

            case 'Headers':
                $object           = \SwaggerValidator\Common\Factory::getInstance()->HeaderItem;
                $object->$keyName = $originKey;
                break;

            case 'SecurityDefinitions':
                $object = $this->SecurityDefinition($context, $jsonData);
                break;

            case 'TypeArray':
                if ($originKey === 'items') {
                    $object = \SwaggerValidator\Common\Factory::getInstance()->TypeArrayItems;
                }
                else {
                    return $jsonData;
                }
                break;
        }

        if (empty($object)) {
            \SwaggerValidator\Exception::throwNewException('Cannot build an empty object from this original type "' . $originType . '" and key "' . $originKey . '"', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        return $this->returnBuildObject($context, $object, $originType, $originKey, $jsonData);
    }

    protected function buildObjectFromOriginKey(\SwaggerValidator\Common\Context $context, $originType, $originKey, &$jsonData)
    {
        $object = null;

        if (!empty(self::$keyToObject[$originKey])) {
            $type   = self::$keyToObject[$originKey];
            $object = \SwaggerValidator\Common\Factory::getInstance()->$type;
        }

        switch ($originKey) {
            case self::KEY_SCHEMA:
                if (!is_object($jsonData)) {
                    \SwaggerValidator\Exception::throwNewException('Cannot build an object schema with an non object JSON Data from this original type "' . $originType . '" and key "' . $originKey . '"', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
                }
                if (property_exists($jsonData, self::KEY_ALLOF) || property_exists($jsonData, self::KEY_ANYOF) || property_exists($jsonData, self::KEY_ONEOF) || property_exists($jsonData, self::KEY_NOT)) {
                    $object = \SwaggerValidator\Common\Factory::getInstance()->TypeCombined;
                }
                elseif (is_object($jsonData) && property_exists($jsonData, self::KEY_TYPE)) {
                    return $this->buildPrimitive($context, $originType, $originKey, $jsonData);
                }
                else {
                    $object = \SwaggerValidator\Common\Factory::getInstance()->TypeObject;
                }
                break;

            case self::KEY_SCOPE:
                if (in_array($originType, self::$securityObjectHasScope)) {
                    $object = \SwaggerValidator\Common\Factory::getInstance()->OAuth2PasswordSecurityScopes;
                }
                else {
                    return $this->jsonUnSerialize($context, $originType, null, $jsonData);
                }
                break;
        }

        if (empty($object)) {
            \SwaggerValidator\Exception::throwNewException('Cannot build an empty object from this original type "' . $originType . '" and key "' . $originKey . '"', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        return $this->returnBuildObject($context, $object, $originType, $originKey, $jsonData);
    }

    protected function buildPrimitive(\SwaggerValidator\Common\Context $context, $originType, $originKey, &$jsonData)
    {
        $typeObj = $this->getPrimitiveType($context, $jsonData);

        if (empty($typeObj)) {
            \SwaggerValidator\Exception::throwNewException('Cannot build an empty primitive object', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        return $this->returnBuildObject($context, \SwaggerValidator\Common\Factory::getInstance()->$typeObj, $originType, $originKey, $jsonData);
    }

    protected function getPrimitiveType(\SwaggerValidator\Common\Context $context, &$jsonData)
    {
        $keyType = self::KEY_TYPE;

        if (!is_object($jsonData) || !property_exists($jsonData, $keyType)) {
            \SwaggerValidator\Exception::throwNewException('Primitive type must have a "type" key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        $keyType = self::KEY_TYPE;

        switch ($jsonData->$keyType) {
            case self::TYPE_ARRAY:
                return 'TypeArray';

            case self::TYPE_BOOLEAN:
                return 'TypeBoolean';

            case self::TYPE_FILE:
                return 'TypeFile';

            case self::TYPE_INTEGER:
                return 'TypeInteger';

            case self::TYPE_NUMBER:
                return 'TypeNumber';

            case self::TYPE_OBJECT:
                return 'TypeObject';

            case self::TYPE_STRING:
                return 'TypeString';

            default:
                \SwaggerValidator\Exception::throwNewException('Cannot build an empty primitive object', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }
    }

    protected function extractReference(\SwaggerValidator\Common\Context $context, &$jsonData)
    {
        if (!is_object($jsonData) || !property_exists($jsonData, self::KEY_REFERENCE)) {
            return $jsonData;
        }

        if (count(get_object_vars($jsonData)) > 1) {
            \SwaggerValidator\Exception::throwNewException('External Object Reference cannot have more keys than the $ref key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        $key = self::KEY_REFERENCE;
        $ref = $jsonData->$key;

        return \SwaggerValidator\Common\CollectionReference::getInstance()->get($ref);
    }

    protected function SecurityDefinition(\SwaggerValidator\Common\Context $context, &$jsonData)
    {
        $typeKey = self::KEY_TYPE;
        $flowKey = self::KEY_FLOW;

        if (!is_object($jsonData) || !property_exists($jsonData, $typeKey)) {
            \SwaggerValidator\Exception::throwNewException('Security Definitions Items must having a "' . $typeKey . '" key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        switch ($jsonData->$typeKey) {
            case 'basic':
                return \SwaggerValidator\Common\Factory::getInstance()->BasicAuthenticationSecurity;

            case 'apiKey':
                return \SwaggerValidator\Common\Factory::getInstance()->ApiKeySecurity;

            case 'oauth2':
                if (!property_exists($jsonData, $flowKey)) {
                    \SwaggerValidator\Exception::throwNewException('Security Definitions Items as type "' . $jsonData->$typeKey . '" must having a "' . $flowKey . '" key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
                }

                switch ($jsonData->$flowKey) {
                    case 'implicit' :
                        return \SwaggerValidator\Common\Factory::getInstance()->OAuth2ImplicitSecurity;

                    case 'password' :
                        return \SwaggerValidator\Common\Factory::getInstance()->OAuth2PasswordSecurity;

                    case 'application' :
                        return \SwaggerValidator\Common\Factory::getInstance()->OAuth2ApplicationSecurity;

                    case 'accessCode' :
                        return \SwaggerValidator\Common\Factory::getInstance()->OAuth2AccessCodeSecurity;
                }
        }

        \SwaggerValidator\Exception::throwNewException('Cannot build a non unknown security definition', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
    }

}
