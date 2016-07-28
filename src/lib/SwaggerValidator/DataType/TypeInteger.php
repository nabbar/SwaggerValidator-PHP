<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\DataType;

/**
 * Description of Integer
 *
 * @author Nabbar
 */
class TypeInteger extends \Swagger\DataType\TypeCommon
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

        if ($this->type != \Swagger\Common\FactorySwagger::TYPE_INTEGER) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (preg_match('/^\d+\.\d+[eE][+-]?\d+$/', $context->getDataValue())) {
            $context->setDataValue(bcsub(bcadd($context->getDataValue(), 1), 1));
        }

        if (!$this->type($context, $context->getDataValue())) {
            return $context->setDataCheck('type')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
        }

        if (!$this->pattern($context, $context->getDataValue())) {
            return $context->setDataCheck('pattern')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_PATTERN, null, __METHOD__, __LINE__);
        }

        if (!$this->format($context, $context->getDataValue())) {
            return false;
        }

        if (!$this->enum($context, $context->getDataValue())) {
            return $context->setDataCheck('enum')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATAVALUE, null, __METHOD__, __LINE__);
        }

        // completer les test integer
        \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function type(\Swagger\Common\Context $context, $valueParams)
    {
        if (is_int($valueParams)) {
            return true;
        }

        $valueCheck = trim($valueParams);

        if (substr($valueCheck, 0, 1) == '-') {
            $valueCheck = substr($valueCheck, 1);
        }

        if (ctype_digit($valueCheck)) {
            return true;
        }
        else
            return false;
    }

    protected function format(\Swagger\Common\Context $context, $valueParams)
    {
        if (!isset($this->format)) {
            return true;
        }

        $valueCheck = trim($valueParams);
        $valueInt32 = bcpow(2, 32);
        $valueInt64 = bcpow(2, 64);

        if (substr($valueCheck, 0, 1) == '-') {
            $valueCheck = substr($valueCheck, 1);
        }

        $valueFloat = floatval($valueCheck);

        if ($this->format == 'int32' && ctype_digit($valueCheck) && $valueFloat < $valueInt32) {
            return true;
        }

        if ($this->format == 'int32' && ctype_digit($valueCheck) && $valueCheck < $valueInt32) {
            return true;
        }

        if ($this->format == 'int64' && ctype_digit($valueCheck) && $valueFloat < $valueInt64) {
            return true;
        }

        if ($this->format == 'int64' && ctype_digit($valueCheck) && $valueCheck < $valueInt64) {
            return true;
        }

        return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATATYPE, 'The format does not match with registred patterns', __METHOD__, __LINE__);
    }

    protected function getExampleFormat(\Swagger\Common\Context $context)
    {
        $valueInt32 = bcsub(bcpow(2, 32), 1);
        $valueInt64 = bcsub(bcpow(2, 64), 1);

        if ($this->format == 'int32') {
            \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
            return $valueInt32;
        }

        if ($this->format == 'int64') {
            \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
            return $valueInt64;
        }

        return $this->getExampleType($context);
    }

    protected function getExampleType(\Swagger\Common\Context $context)
    {
        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return '123';
    }

}
