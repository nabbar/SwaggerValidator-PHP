<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\DataType;

/**
 * Description of Boolean
 *
 * @author Nabbar
 */
class TypeBoolean extends \Swagger\DataType\TypeCommon
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
    }

    public function validate(\Swagger\Common\Context $context)
    {
        if (!isset($this->type)) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if ($this->type != \Swagger\Common\FactorySwagger::TYPE_BOOLEAN) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!$this->type($context, $context->getDataValue())) {
            return $context->setDataCheck('type')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
        }

        if (!$this->pattern($context, $context->getDataValue())) {
            return $context->setDataCheck('pattern')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_PATTERN, null, __METHOD__, __LINE__);
        }

        // completer les test integer
        \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function format(\Swagger\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function type(\Swagger\Common\Context $context, $valueParams)
    {
        if (is_string($valueParams)) {

            switch (strtolower($valueParams)) {
                case '1':
                case 'true':
                case 'on':
                case 'yes':
                case 'y':
                    return true;
                default:
                    return false;
            }
        }

        return is_bool($valueParams);
    }

    protected function getExampleFormat(\Swagger\Common\Context $context)
    {
        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return true;
    }

    protected function getExampleType(\Swagger\Common\Context $context)
    {
        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return true;
    }

}
