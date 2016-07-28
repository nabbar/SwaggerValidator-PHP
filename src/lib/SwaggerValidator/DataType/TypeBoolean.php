<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\DataType;

/**
 * Description of Boolean
 *
 * @author Nabbar
 */
class TypeBoolean extends \SwaggerValidator\DataType\TypeCommon
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        if (!isset($this->type)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if ($this->type != \SwaggerValidator\Common\FactorySwagger::TYPE_BOOLEAN) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!$this->type($context, $context->getDataValue())) {
            return $context->setDataCheck('type')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
        }

        if (!$this->pattern($context, $context->getDataValue())) {
            return $context->setDataCheck('pattern')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_PATTERN, null, __METHOD__, __LINE__);
        }

        // completer les test integer
        \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function format(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function type(\SwaggerValidator\Common\Context $context, $valueParams)
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

    protected function getExampleFormat(\SwaggerValidator\Common\Context $context)
    {
        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return true;
    }

    protected function getExampleType(\SwaggerValidator\Common\Context $context)
    {
        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return true;
    }

}
