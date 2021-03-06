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

namespace SwaggerValidator\DataType;

/**
 * Description of Integer
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class TypeInteger extends \SwaggerValidator\DataType\TypeCommon
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
    }

    /**
     * Var Export Method
     */
    protected function __storeData($key, $value = null)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
        else {
            parent::__storeData($key, $value);
        }
    }

    public static function __set_state(array $properties)
    {
        $obj = new static;

        foreach ($properties as $key => $value) {
            $obj->__storeData($key, $value);
        }

        return $obj;
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        if (!isset($this->type)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!isset($this->minimum) || $this->minimum < 1) {
            if ((!isset($this->exclusiveMinimum) || $this->exclusiveMinimum !== true) && $context->isDataEmpty()) {
                return true;
            }
        }

        if ($this->type != \SwaggerValidator\Common\FactorySwagger::TYPE_INTEGER) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!$this->minimum($context, $context->getDataValue())) {
            return $context->setDataCheck('minimum')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, null, __METHOD__, __LINE__);
        }

        if (!$this->maximum($context, $context->getDataValue())) {
            return $context->setDataCheck('maximum')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, null, __METHOD__, __LINE__);
        }

        if (preg_match('/^\d+\.\d+[eE][+-]?\d+$/', $context->getDataValue())) {
            $context->setDataValue(bcsub(bcadd($context->getDataValue(), 1), 1));
        }

        if (!$this->type($context, $context->getDataValue())) {
            return $context->setDataCheck('type')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
        }

        if (!$this->pattern($context, $context->getDataValue())) {
            return $context->setDataCheck('pattern')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_PATTERN, null, __METHOD__, __LINE__);
        }

        if (!$this->format($context, $context->getDataValue())) {
            return false;
        }

        if (!$this->enum($context, $context->getDataValue())) {
            return $context->setDataCheck('enum')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, null, __METHOD__, __LINE__);
        }

        // completer les test integer
        $context->logValidate(get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function type(\SwaggerValidator\Common\Context $context, $valueParams)
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

    protected function format(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!isset($this->format)) {
            return true;
        }

        $valueCheck = trim($valueParams);
        $valueInt32 = bcpow(2, 31);
        $valueInt64 = bcpow(2, 63);

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

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, 'The format does not match with registred patterns', __METHOD__, __LINE__);
    }

    protected function getExampleFormat(\SwaggerValidator\Common\Context $context)
    {
        $valueInt32 = bcsub(bcpow(2, 31), 1);
        $valueInt64 = bcsub(bcpow(2, 63), 1);
        $sign       = (random_int(0, 1) > 0.5) ? '' : '-';

        if ($this->format == 'int32') {
            $context->logModel(__METHOD__, __LINE__);
            return $sign . random_int(0, (int) $valueInt32);
        }

        if ($this->format == 'int64') {
            $context->logModel(__METHOD__, __LINE__);
            return $sign . bcadd(random_int(0, (int) $valueInt32), random_int(0, (int) $valueInt32));
        }

        return $this->getExampleType($context);
    }

    protected function getExampleType(\SwaggerValidator\Common\Context $context)
    {
        $sign = (random_int(0, 1) > 0.5) ? '' : '-';

        $context->logModel(__METHOD__, __LINE__);
        return $sign . random_int(0, (int) bcsub(bcpow(2, 31), 1));
    }

}
