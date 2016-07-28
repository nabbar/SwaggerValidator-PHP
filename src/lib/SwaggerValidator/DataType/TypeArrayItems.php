<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\DataType;

/**
 * Description of TypeArrayItems
 *
 * @author Nabbar
 */
class TypeArrayItems extends \Swagger\DataType\TypeCommon
{

    public function __construct()
    {

    }

    public function jsonSerialize()
    {
        $keySchema = \Swagger\Common\FactorySwagger::KEY_SCHEMA;

        if (isset($this->$keySchema) && is_object($this->$keySchema)) {
            return json_decode(self::jsonEncode($this->$keySchema));
        }

        // Check if each keys is matching the received params
        $result = array();

        foreach ($this->keys() as $key) {
            $result[$key] = json_decode(self::jsonEncode($this->$keySchema));
        }

        return $result;
    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        if (is_object($jsonData) && !($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }
        elseif (!is_object($jsonData) && !is_array($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        $keyType   = \Swagger\Common\FactorySwagger::KEY_TYPE;
        $keySchema = \Swagger\Common\FactorySwagger::KEY_SCHEMA;
        $keyRef    = \Swagger\Common\FactorySwagger::KEY_REFERENCE;
        $keyAllOf  = \Swagger\Common\FactorySwagger::KEY_ALLOF;
        $keyAnyOf  = \Swagger\Common\FactorySwagger::KEY_ANYOF;
        $keyOneOf  = \Swagger\Common\FactorySwagger::KEY_ONEOF;

        if (is_object($jsonData) && property_exists($jsonData, $keyType)) {
            $this->$keySchema = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), $keySchema, $jsonData);
            return;
        }

        if (is_object($jsonData) && (property_exists($jsonData, $keyAllOf) || property_exists($jsonData, $keyAnyOf) || property_exists($jsonData, $keyOneOf))) {
            $this->$keySchema = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), $keySchema, $jsonData);
            return;
        }

        if (is_object($jsonData) && property_exists($jsonData, $keyRef)) {
            $this->registerRecursiveDefinitions($jsonData);
            $this->$keySchema = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), null, $jsonData);
            return;
        }

        if (is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        foreach ($jsonData as $key => $value) {
            $this->registerRecursiveDefinitions($value);
            $this->$key = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\Swagger\Common\Context $context, $valueParams = null)
    {
        $result    = true;
        $lastKey   = null;
        $keySchema = \Swagger\Common\FactorySwagger::KEY_SCHEMA;

        if (isset($this->$keySchema) && is_object($this->$keySchema)) {
            $lastKey = $keySchema;
        }
        else {
            // Check if each keys is matching the received params

            $myArrayValue = $context->getDataValue();

            foreach ($this->keys() as $key) {
                $lastKey = $key;

                if (!array_key_exists($key, $context->getDataValue())) {
                    $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_NOTFOUND, 'Item "' . $key . '" not found in an array', __METHOD__, __LINE__);
                }

                $value = $myArrayValue[$key];

                if (is_object($this->$key) && method_exists($this->$key, 'validate')) {
                    $result = $result && $this->$key->validate($context->setDataPath($key)->setDataValue($value));
                }
                elseif ($this->$key != $value) {
                    $result = $result && $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Item "' . $key . '" does not matching the awaiting value', __METHOD__, __LINE__);
                }
            }
        }

        // Check if each more keys in the received params matching the last registred keys
        foreach ($context->getDataValue() as $key => $value) {
            if ($lastKey !== $keySchema && $this->has($key)) {
                continue;
            }

            if (is_object($this->$lastKey) && method_exists($this->$lastKey, 'validate')) {
                $result = $result && $this->$lastKey->validate($context->setDataPath($key)->setDataValue($value));
            }
            elseif ($this->$lastKey != $value) {
                $result = $result && $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Item "' . $key . '" does not matching the awaiting value', __METHOD__, __LINE__);
            }
        }

        \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return $result;
    }

    public function countItems(\Swagger\Common\Context $context, $additionItems = true, $valueParams = null)
    {
        $keySchema = \Swagger\Common\FactorySwagger::KEY_SCHEMA;

        if (isset($this->$keySchema)) {
            return true;
        }

        if ($additionItems && (count($this->items) >= count($valueParams))) {
            return true;
        }
        elseif (count($this->items) == count($valueParams)) {
            return true;
        }

        print "Calling with args : " . print_r(func_get_args(), true) . "\n\n";
        return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATASIZE, 'The items number does not match the awaiting', __METHOD__, __LINE__);
    }

    protected function type(\Swagger\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function format(\Swagger\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function getExampleFormat(\Swagger\Common\Context $context)
    {
        return $this->getExampleType($context);
    }

    protected function getExampleType(\Swagger\Common\Context $context)
    {
        $keySchema = \Swagger\Common\FactorySwagger::KEY_SCHEMA;
        $result    = array();

        if (isset($this->$keySchema) && is_object($this->$keySchema)) {
            return array($this->$keySchema->getModel($context));
        }

        foreach ($this->keys() as $key) {
            if (is_object($this->$key) && method_exists($this->$key, 'getModel')) {
                $result[$key] = $this->$key->getModel($context);
            }
            else {
                $result[$key] = $this->$key;
            }
        }

        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $result;
    }

}
