<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Object;

/**
 * Description of Parameters
 *
 * @author Nabbar
 */
class Parameters extends \Swagger\Common\CollectionSwagger
{

    public function __construct()
    {

    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData) && !is_array($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (is_object($jsonData) && !($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }
        elseif (is_object($jsonData)) {
            $jsonData = get_object_vars($jsonData);
        }
        elseif (is_array($jsonData)) {
            parent::setJSONIsArray();
        }

        $keyIn = \Swagger\Common\FactorySwagger::KEY_IN;

        foreach ($jsonData as $key => $value) {
            $value = $this->extractNonRecursiveReference($context, $value);

            if (!property_exists($value, $keyIn)) {
                $this->buildException('Parameters "' . $key . '" is not well defined !', $context);
            }

            $this->$key = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\Swagger\Common\Context $context)
    {
        if ($context->getType() !== \Swagger\Common\Context::TYPE_REQUEST) {
            return true;
        }

        $check = true;

        foreach ($this->keys() as $key) {
            $in   = null;
            $name = null;

            if (is_object($this->$key) && ($this->$key instanceof \Swagger\Object\ParameterBody)) {
                \Swagger\Common\Context::addCheckedDataName(\Swagger\Common\FactorySwagger::LOCATION_BODY, null);
                $check = $check && $this->checkExistsEmptyValidate($context->setDataPath(\Swagger\Common\FactorySwagger::LOCATION_BODY)->setLocation(\Swagger\Common\FactorySwagger::LOCATION_BODY), $key);
            }
            elseif (is_object($this->$key) && ($this->$key instanceof \Swagger\DataType\TypeCommon)) {
                \Swagger\Common\Context::addCheckedDataName($this->$key->in, $this->$key->name);
                $check = $check && $this->checkExistsEmptyValidate($context->setDataPath($this->$key->name)->setLocation($this->$key->in), $key);
            }
        }

        \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function checkExistsEmptyValidate(\Swagger\Common\Context $context, $key)
    {
        $context->dataLoad();
        $keyRequired = \Swagger\Common\FactorySwagger::KEY_REQUIRED;

        if ($this->$key->isRequired() == true && !$context->isDataExists()) {
            $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_NOTFOUND, $context->getDataPath() . ' is not found', __METHOD__, __LINE__);
        }
        elseif (!$context->isDataExists()) {
            return true;
        }

        return $this->$key->validate($context);
    }

    function getModel(\Swagger\Common\Context $context, &$listParameters)
    {
        foreach ($this->keys() as $key) {
            $model = null;
            $in    = null;
            $name  = null;

            if (is_object($this->$key) && ($this->$key instanceof \Swagger\Object\ParameterBody)) {
                $name  = \Swagger\Common\FactorySwagger::LOCATION_BODY;
                $in    = \Swagger\Common\FactorySwagger::LOCATION_BODY;
                $model = $this->$key->getModel($context->setDataPath($key));
            }
            elseif (is_object($this->$key) && ($this->$key instanceof \Swagger\DataType\TypeCommon)) {
                $name  = $this->$key->name;
                $in    = $this->$key->in;
                $model = $this->$key->getModel($context->setDataPath($key));
            }

            if (!array_key_exists($in, $listParameters) || !is_array($listParameters[$in])) {
                $listParameters[$in] = array();
            }

            $listParameters[$in][$name] = $model;
        }

        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
    }

}
