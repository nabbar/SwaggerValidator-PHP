<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\DataType;

/**
 * Description of Array
 *
 * @author Nabbar
 */
class TypeArray extends \Swagger\DataType\TypeCommon
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
        parent::registerMandatoryKey('items');
    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {
            $this->$key = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\Swagger\Common\Context $context)
    {
        $keyType       = \Swagger\Common\FactorySwagger::KEY_TYPE;
        $keyItems      = \Swagger\Common\FactorySwagger::KEY_ITEMS;
        $keyAdditional = \Swagger\Common\FactorySwagger::KEY_ADDITEMS;

        if (!isset($this->$keyType)) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!isset($this->$keyAdditional)) {
            $additionnal = true;
        }
        else {
            $additionnal = (bool) $this->$keyAdditional;
        }

        if ($this->$keyType != \Swagger\Common\FactorySwagger::TYPE_ARRAY) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        $this->collectionFormat($context, $context->getDataValue());

        if (!$this->type($context, $context->getDataValue())) {
            return $context->setDataCheck($keyType)->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
        }

        if (!$this->minItems($context, $context->getDataValue())) {
            return $context->setDataCheck('minItems')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATASIZE, 'Value has not enough items', __METHOD__, __LINE__);
        }

        if (!$this->maxItems($context, $context->getDataValue())) {
            return $context->setDataCheck('maxItems')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATASIZE, 'Value has too many items', __METHOD__, __LINE__);
        }

        if (isset($this->uniqueItems) && $this->uniqueItems === true) {
            $uniqValue = array_unique($context->getDataValue());

            if ($uniqValue != $context->getDataValue()) {
                return $context->setDataCheck('uniqueItems')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Value has not only uniq items', __METHOD__, __LINE__);
            }
        }

        if (!isset($this->$keyItems) || !is_object($this->$keyItems) || !method_exists($this->$keyItems, 'validate')) {
            return $context->setDataCheck($keyItems)->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!$this->$keyItems->countItems($context, $additionnal, $context->getDataValue())) {
            return false;
        }

        \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return $this->$keyItems->validate($context, $context->getDataValue());
    }

    protected function type(\Swagger\Common\Context $context, $valueParams)
    {
        if (is_array($valueParams)) {
            return true;
        }

        return false;
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
        $keyItems = \Swagger\Common\FactorySwagger::KEY_ITEMS;

        if (is_object($this->$keyItems) && method_exists($this->$keyItems, 'getModel')) {
            return $this->$keyItems->getModel($context);
        }

        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $this->$keyItems;
    }

}
