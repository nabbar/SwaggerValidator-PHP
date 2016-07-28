<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\DataType;

/**
 * Description of TypeCombined
 *
 * @author Nabbar
 */
class TypeCombined extends \Swagger\Common\CollectionSwagger
{

    public function __construct()
    {

    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData) || !($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (count(get_object_vars($jsonData)) > 1) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        $keyAnyOf = \Swagger\Common\FactorySwagger::KEY_ANYOF;
        $keyAllOf = \Swagger\Common\FactorySwagger::KEY_ALLOF;
        $keyOneOf = \Swagger\Common\FactorySwagger::KEY_ONEOF;
        $keyNot   = \Swagger\Common\FactorySwagger::KEY_NOT;

        if (property_exists($jsonData, $keyAnyOf)) {
            $key = $keyAnyOf;
        }
        if (property_exists($jsonData, $keyAllOf)) {
            $key = $keyAllOf;
        }
        if (property_exists($jsonData, $keyOneOf)) {
            $key = $keyOneOf;
        }
        if (property_exists($jsonData, $keyNot)) {
            $key = $keyNot;
        }

        if (empty($key)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        $result = array();

        foreach ($jsonData->$key as $index => $value) {
            $value          = $this->extractNonRecursiveReference($context, $value);
            $result[$index] = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), \Swagger\Common\FactorySwagger::KEY_SCHEMA, $value);
        }

        $this->$key = $result;

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\Swagger\Common\Context $context, $valueParams = null)
    {
        $keyAnyOf = \Swagger\Common\FactorySwagger::KEY_ANYOF;
        $keyAllOf = \Swagger\Common\FactorySwagger::KEY_ALLOF;
        $keyOneOf = \Swagger\Common\FactorySwagger::KEY_ONEOF;
        $keyNot   = \Swagger\Common\FactorySwagger::KEY_NOT;

        if (isset($this->$keyNot)) {
            if (empty($this->$keyNot)) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, $keyNot . ' Combined Object Type cannot be empty !');
            }

            return !($this->$keyNot->validate($context, $valueParams));
        }

        if (isset($this->$keyAnyOf)) {
            if (empty($this->$keyAnyOf) || !is_array($this->$keyAnyOf)) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, $keyAnyOf . ' Combined Object Type cannot be empty !');
            }

            return $this->validateAnyOf($context, $valueParams);
        }

        if (isset($this->$keyAllOf)) {
            if (empty($this->$keyAllOf) || !is_array($this->$keyAllOf)) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, $keyAllOf . ' Combined Object Type cannot be empty !');
            }

            return $this->validateAllOf($context, $valueParams);
        }

        if (isset($this->$keyOneOf)) {
            if (empty($this->$keyOneOf) || !is_array($this->$keyOneOf)) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, $keyOneOf . ' Combined Object Type cannot be empty !');
            }

            return $this->validateOneOf($context, $valueParams);
        }

        return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, 'Combined Object Type is not well defined !');
    }

    protected function validateAnyOf(\Swagger\Common\Context $context, $valueParams = null)
    {
        $keyAnyOf = \Swagger\Common\FactorySwagger::KEY_ANYOF;

        foreach ($this->$keyAnyOf as $key => $object) {

            if (!is_object($object) || !method_exists($object, 'validate')) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, 'Object not well formed in ' . $keyAnyOf . ' object !');
            }

            if ($object->validate($context->setDataPath($key)->setCombined(true), $valueParams)) {
                \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
                return true;
            }
        }

        return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_PATTERN, 'Value is not matching any ' . $keyAnyOf . ' defnied type !');
    }

    protected function validateAllOf(\Swagger\Common\Context $context, $valueParams = null)
    {
        $keyAllOf = \Swagger\Common\FactorySwagger::KEY_ALLOF;

        foreach ($this->$keyAllOf as $key => $object) {

            if (!is_object($object) || !method_exists($object, 'validate')) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, 'Object not well formed in ' . $keyAllOf . ' object !');
            }

            if (!$object->validate($context->setDataPath($key), $valueParams)) {
                return false;
            }
        }

        \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function validateOneOf(\Swagger\Common\Context $context, $valueParams = null)
    {
        $keyOneOf = \Swagger\Common\FactorySwagger::KEY_ONEOF;
        $check    = false;
        $result   = false;

        foreach ($this->$keyAllOf as $key => $object) {

            if (!is_object($object) || !method_exists($object, 'validate')) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, 'Object not well formed in ' . $keyOneOf . ' object !');
            }

            $result = $object->validate($context->setDataPath($key)->setCombined(true), $valueParams);

            if ($result === true && $check === true) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_PATTERN, 'Value is matching at least 2 of the ' . $keyOneOf . ' defnied type !');
            }
            elseif ($result === true) {
                $check = true;
            }
        }

        \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return $result || $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_PATTERN, 'Value is not matching one of the ' . $keyOneOf . ' defnied type !');
    }

    public function getModel(\Swagger\Common\Context $context)
    {
        $result   = new \stdClass();
        $keyAnyOf = \Swagger\Common\FactorySwagger::KEY_ANYOF;
        $keyAllOf = \Swagger\Common\FactorySwagger::KEY_ALLOF;
        $keyOneOf = \Swagger\Common\FactorySwagger::KEY_ONEOF;
        $keyNot   = \Swagger\Common\FactorySwagger::KEY_NOT;


        if (isset($this->$keyNot)) {
            return '';
        }

        if (isset($this->$keyAnyOf)) {
            if (empty($this->$keyAnyOf) || !is_array($this->$keyAnyOf)) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, $keyAnyOf . ' Combined Object Type cannot be empty !');
            }

            $object = $this->$keyAnyOf;
            $object = array(array_shift($object));
        }

        if (isset($this->$keyAllOf)) {
            if (empty($this->$keyAllOf) || !is_array($this->$keyAllOf)) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, $keyAllOf . ' Combined Object Type cannot be empty !');
            }

            $object = $this->$keyAllOf;
        }

        if (isset($this->$keyOneOf)) {
            if (empty($this->$keyOneOf) || !is_array($this->$keyOneOf)) {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, $keyOneOf . ' Combined Object Type cannot be empty !');
            }

            $object = $this->$keyOneOf;
            $object = array(array_shift($object));
        }

        foreach ($object as $key => $value) {

            $part = $value->getModel($context->setDataPath($key));

            if (is_object($part) && !is_object($result)) {
                $result = $part;
            }
            elseif (is_object($part) && is_object($result)) {
                foreach (get_object_vars($part) as $partKey => $partValue) {
                    $result->$partKey = $partValue;
                }
            }
            elseif (is_array($part) && !is_array($result)) {
                $result = $part;
            }
            elseif (is_array($part) && is_array($result)) {
                $result = $result + $part;
            }
            else {
                return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, 'Cannot build model for key "' . $key . '" in Combined Object !');
            }
        }

        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $result;
    }

}
