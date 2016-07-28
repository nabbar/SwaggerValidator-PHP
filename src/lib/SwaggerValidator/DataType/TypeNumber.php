<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\DataType;

/**
 * Description of Number
 *
 * @author Nabbar
 */
class TypeNumber extends \Swagger\DataType\TypeCommon
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

        if ($this->type != \Swagger\Common\FactorySwagger::TYPE_NUMBER) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
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
        if (is_numeric($valueParams)) {
            return true;
        }
        elseif (preg_match('/^[\d.e+-]$/i', $valueParams)) {
            return true;
        }

        return false;
    }

    protected function format(\Swagger\Common\Context $context, $valueParams)
    {
        if (!isset($this->format)) {
            return true;
        }

        $exposant = explode('.', $valueParams);

        if (count($exposant) > 2) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATATYPE, 'Valueparams is not a normal numeric pattern', __METHOD__, __LINE__);
        }
        elseif (count($exposant) == 2) {
            $exposant = $exposant[1];
        }
        else {
            $exposant = null;
        }


        if ($this->format == 'float' && is_float($valueParams) && strlen($exposant) <= 7) {
            # Float val = 7 signs after .
            return true;
        }

        if ($this->format == 'double' && is_float($valueParams) && strlen($exposant) <= 15) {
            # Float val = 15 signs after .
            return true;
        }

        return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATATYPE, 'The format does not match with registred patterns', __METHOD__, __LINE__);
    }

    protected function getExampleFormat(\Swagger\Common\Context $context)
    {
        $pi = '3.141592653589793238462643383279';

        if ($this->format == 'float' && is_float($valueParams)) {
            # Float val = 7 signs after .
            \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
            return floatval(substr($pi, 0, 9));
        }

        if ($this->format == 'double' && is_double($valueParams)) {
            # Float val = 15 signs after .
            \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
            return floatval(substr($pi, 0, 17));
        }

        return $this->getExampleType($context);
    }

    protected function getExampleType(\Swagger\Common\Context $context)
    {
        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return floatval('0.1234567890123456789');
    }

}