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
 * Description of Number
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class TypeNumber extends \SwaggerValidator\DataType\TypeCommon
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

        if ($this->type != \SwaggerValidator\Common\FactorySwagger::TYPE_NUMBER) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!$this->type($context, $context->getDataValue())) {
            return $context->setDataCheck('type')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
        }

        if (!$this->minimum($context, $context->getDataValue())) {
            return $context->setDataCheck('minimum')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, null, __METHOD__, __LINE__);
        }

        if (!$this->maximum($context, $context->getDataValue())) {
            return $context->setDataCheck('maximum')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, null, __METHOD__, __LINE__);
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
        if (is_numeric($valueParams)) {
            return true;
        }
        elseif (preg_match('/^[\d.e+-]$/i', $valueParams)) {
            return true;
        }

        return false;
    }

    protected function format(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!isset($this->format)) {
            return true;
        }

        if (substr($valueParams, 0, 1) == '-') {
            $sign        = -1;
            $valueParams = substr($valueParams, 1);
        }
        else {
            $sign = 1;
        }

        $mantisse = explode('.', $valueParams);
        $exposant = 0;

        if (count($mantisse) > 2) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, 'Valueparams is not a normal numeric pattern', __METHOD__, __LINE__);
        }

        if (strlen($mantisse[0]) > 0) {
            $exposant = strlen($mantisse[0]);
            $mantisse = implode('', $mantisse);
        }

        if (stripos($valueParams, 'E') !== false) {
            $exposant += substr($valueParams, stripos($valueParams, 'E'));
        }

        $mantisseFloat = bcpow(2, 23);
        $exposantFloat = bcpow(2, 8);

        $mantisseDouble = bcpow(2, 52);
        $exposantDouble = bcpow(2, 11);

        if ($this->format == 'float' && $mantisse < $mantisseFloat && $exposant < $exposantFloat) {
            # Float val = 7 signs after .
            return true;
        }

        if ($this->format == 'double' && $mantisse < $mantisseDouble && $exposant < $exposantDouble) {
            # Float val = 15 signs after .
            return true;
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, 'The format does not match with registred patterns', __METHOD__, __LINE__);
    }

    protected function getExampleFormat(\SwaggerValidator\Common\Context $context)
    {
        $sign = (rand(0, 1) > 0.5) ? '0' : '-0';
        $sige = (rand(0, 1) > 0.5) ? '0' : '-0';
        $min  = (isset($this->minimum)) ? $this->minimum : 0;
        $max  = (isset($this->maximum)) ? $this->maximum : 0;

        if ($max > 0) {
            return (float) rand($min, $max);
        }

        if ($this->format == 'double') {
            # Float val = 15 signs after . // limit the bcpow to 31 bit for miitation of rand function
            $context->logModel(__METHOD__, __LINE__);
            return (float) bcsub(1, bcadd(1, $sign . '.' . rand($min, pow(2, 31)) . 'e' . $sige . rand(0, pow(2, 11))));
        }

        if ($this->format == 'float') {
            # Float val = 7 signs after .
            $context->logModel(__METHOD__, __LINE__);
            return (float) bcsub(1, bcadd(1, $sign . '.' . rand($min, pow(2, 23)) . 'e' . $sige . rand(0, pow(2, 8))));
        }

        return $this->getExampleType($context);
    }

    protected function getExampleType(\SwaggerValidator\Common\Context $context)
    {
        $sign = (rand(0, 1) > 0.5) ? '0' : '-0';
        $sige = (rand(0, 1) > 0.5) ? '' : '-';
        $min  = (isset($this->minimum)) ? $this->minimum : 0;
        $max  = (isset($this->maximum)) ? $this->maximum : 0;

        if ($max > 0) {
            return (float) rand($min, $max);
        }

        $mantisse = $sign . '.' . rand($min, pow(2, 23));
        $exposant = $sige . rand(0, pow(2, 8));

        $context->logModel(__METHOD__, __LINE__);
        return (float) ($mantisse . 'E' . $exposant);
    }

}
