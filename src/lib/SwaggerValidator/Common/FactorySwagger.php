<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Common;

/**
 * Description of FactorySwagger
 *
 * @author Nabbar
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
     * @var \Swagger\Common\FactorySwagger
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
     * @return \Swagger\Common\FactorySwagger
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
    public static function setInstance(\Swagger\Common\FactorySwagger $instance)
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

    public function jsonUnSerialize(\Swagger\Common\Context $context, $originType, $originKey, &$jsonData)
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
            return $this->returnBuildObject($context, \Swagger\Common\Factory::getInstance()->Reference, $originType, $originKey, $jsonData);
        }

        if (is_object($jsonData) && $originType !== 'Swagger' && $originType !== 'TypeObject') {
            \Swagger\Exception::throwNewException('Cannot identify the object builder for the given JSON Data', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }
        elseif (is_object($jsonData) && $originType === 'TypeObject') {
            return $this->returnBuildObject($context, \Swagger\Common\Factory::getInstance()->TypeObject, $originType, $originKey, $jsonData);
        }

        return $jsonData;
    }

    protected function returnBuildObject(\Swagger\Common\Context $context, \Swagger\Common\CollectionSwagger $object, $originType, $originKey, &$jsonData)
    {
        $object->jsonUnSerialize($context, $jsonData);
        $missingKey = $object->checkMandatoryKey();

        if ($missingKey !== true) {
            \Swagger\Exception::throwNewException('Missing Key "' . $missingKey . '" from this original type "' . $originType . '" and key "' . $originKey . '"', array('context' => $context, 'SwaggerObject' => $object), __FILE__, __LINE__);
        }

        return $object;
    }

    protected function buildObjectFromOriginObject(\Swagger\Common\Context $context, $originType, $originKey, &$jsonData)
    {
        $keyIn   = self::KEY_IN;
        $keyName = self::KEY_NAME;
        $object  = null;

        if (!empty(self::$originObjectToChildObject[$originType])) {
            $type   = self::$originObjectToChildObject[$originType];
            $object = \Swagger\Common\Factory::getInstance()->$type;
        }

        switch ($originType) {
            case 'Parameters':
                if (!is_object($jsonData) || !property_exists($jsonData, $keyIn)) {
                    \Swagger\Exception::throwNewException('Parameters Item have no "in" keys', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
                }

                if ($jsonData->$keyIn == self::LOCATION_BODY) {
                    $object = \Swagger\Common\Factory::getInstance()->ParameterBody;
                }
                else {
                    $objectType       = $this->getPrimitiveType($context, $jsonData);
                    $object           = \Swagger\Common\Factory::getInstance()->$objectType;
                    $object->$keyName = $originKey;
                }
                break;

            case 'Headers':
                $object           = \Swagger\Common\Factory::getInstance()->HeaderItem;
                $object->$keyName = $originKey;
                break;

            case 'SecurityDefinitions':
                $object = $this->SecurityDefinition($context, $jsonData);
                break;

            case 'TypeArray':
                if ($originKey === 'items') {
                    $object = \Swagger\Common\Factory::getInstance()->TypeArrayItems;
                }
                else {
                    return $jsonData;
                }
                break;
        }

        if (empty($object)) {
            \Swagger\Exception::throwNewException('Cannot build an empty object from this original type "' . $originType . '" and key "' . $originKey . '"', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        return $this->returnBuildObject($context, $object, $originType, $originKey, $jsonData);
    }

    protected function buildObjectFromOriginKey(\Swagger\Common\Context $context, $originType, $originKey, &$jsonData)
    {
        $object = null;

        if (!empty(self::$keyToObject[$originKey])) {
            $type   = self::$keyToObject[$originKey];
            $object = \Swagger\Common\Factory::getInstance()->$type;
        }

        switch ($originKey) {
            case self::KEY_SCHEMA:
                if (!is_object($jsonData)) {
                    \Swagger\Exception::throwNewException('Cannot build an object schema with an non object JSON Data from this original type "' . $originType . '" and key "' . $originKey . '"', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
                }
                if (property_exists($jsonData, self::KEY_ALLOF) || property_exists($jsonData, self::KEY_ANYOF) || property_exists($jsonData, self::KEY_ONEOF) || property_exists($jsonData, self::KEY_NOT)) {
                    $object = \Swagger\Common\Factory::getInstance()->TypeCombined;
                }
                elseif (is_object($jsonData) && property_exists($jsonData, self::KEY_TYPE)) {
                    return $this->buildPrimitive($context, $originType, $originKey, $jsonData);
                }
                else {
                    $object = \Swagger\Common\Factory::getInstance()->TypeObject;
                }
                break;

            case self::KEY_SCOPE:
                if (in_array($originType, self::$securityObjectHasScope)) {
                    $object = \Swagger\Common\Factory::getInstance()->OAuth2PasswordSecurityScopes;
                }
                else {
                    return $this->jsonUnSerialize($context, $originType, null, $jsonData);
                }
                break;
        }

        if (empty($object)) {
            \Swagger\Exception::throwNewException('Cannot build an empty object from this original type "' . $originType . '" and key "' . $originKey . '"', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        return $this->returnBuildObject($context, $object, $originType, $originKey, $jsonData);
    }

    protected function buildPrimitive(\Swagger\Common\Context $context, $originType, $originKey, &$jsonData)
    {
        $typeObj = $this->getPrimitiveType($context, $jsonData);

        if (empty($typeObj)) {
            \Swagger\Exception::throwNewException('Cannot build an empty primitive object', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        return $this->returnBuildObject($context, \Swagger\Common\Factory::getInstance()->$typeObj, $originType, $originKey, $jsonData);
    }

    protected function getPrimitiveType(\Swagger\Common\Context $context, &$jsonData)
    {
        $keyType = self::KEY_TYPE;

        if (!is_object($jsonData) || !property_exists($jsonData, $keyType)) {
            \Swagger\Exception::throwNewException('Primitive type must have a "type" key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
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
                \Swagger\Exception::throwNewException('Cannot build an empty primitive object', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }
    }

    protected function extractReference(\Swagger\Common\Context $context, &$jsonData)
    {
        if (!is_object($jsonData) || !property_exists($jsonData, self::KEY_REFERENCE)) {
            return $jsonData;
        }

        if (count(get_object_vars($jsonData)) > 1) {
            \Swagger\Exception::throwNewException('External Object Reference cannot have more keys than the $ref key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        $key = self::KEY_REFERENCE;
        $ref = $jsonData->$key;

        return \Swagger\Common\CollectionReference::getInstance()->get($ref);
    }

    protected function SecurityDefinition(\Swagger\Common\Context $context, &$jsonData)
    {
        $typeKey = self::KEY_TYPE;
        $flowKey = self::KEY_FLOW;

        if (!is_object($jsonData) || !property_exists($jsonData, $typeKey)) {
            \Swagger\Exception::throwNewException('Security Definitions Items must having a "' . $typeKey . '" key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        switch ($jsonData->$typeKey) {
            case 'basic':
                return \Swagger\Common\Factory::getInstance()->BasicAuthenticationSecurity;

            case 'apiKey':
                return \Swagger\Common\Factory::getInstance()->ApiKeySecurity;

            case 'oauth2':
                if (!property_exists($jsonData, $flowKey)) {
                    \Swagger\Exception::throwNewException('Security Definitions Items as type "' . $jsonData->$typeKey . '" must having a "' . $flowKey . '" key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
                }

                switch ($jsonData->$flowKey) {
                    case 'implicit' :
                        return \Swagger\Common\Factory::getInstance()->OAuth2ImplicitSecurity;

                    case 'password' :
                        return \Swagger\Common\Factory::getInstance()->OAuth2PasswordSecurity;

                    case 'application' :
                        return \Swagger\Common\Factory::getInstance()->OAuth2ApplicationSecurity;

                    case 'accessCode' :
                        return \Swagger\Common\Factory::getInstance()->OAuth2AccessCodeSecurity;
                }
        }

        \Swagger\Exception::throwNewException('Cannot build a non unknown security definition', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
    }

}
