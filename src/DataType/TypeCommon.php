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
 * Abstract class used to check validation regardless JSON & Swagger validation schema
 * @see http://json-schema.org/latest/json-schema-validation.html
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
abstract class TypeCommon extends \SwaggerValidator\Common\CollectionSwagger
{

    abstract protected function type(\SwaggerValidator\Common\Context $context, $valueParams);

    abstract protected function format(\SwaggerValidator\Common\Context $context, $valueParams);

    abstract protected function getExampleType(\SwaggerValidator\Common\Context $context);

    abstract protected function getExampleFormat(\SwaggerValidator\Common\Context $context);

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

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $context->throwException('Mismatching type of JSON Data received', __METHOD__, __LINE__);
        }

        if (!($jsonData instanceof \stdClass)) {
            $context->throwException('Mismatching type of JSON Data received', __METHOD__, __LINE__);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {
            $this->$key = $value;
        }

        $context->logDecode(get_class($this), __METHOD__, __LINE__);
    }

    public function isRequired()
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_REQUIRED;

        if ($this->__isset($key)) {
            return (bool) ($this->$key);
        }

        return false;
    }

    public function pattern(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_PATTERN;

        if (!$this->__isset($key)) {
            return true;
        }

        if (empty($this->$key)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        $pattern = str_replace('~', '\~', $this->$key);

        return preg_match('~' . $pattern . '~', $valueParams);
    }

    public function allowEmptyValue(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_ALLOWEMPTYVALUE;

        if ($this->__isset($key) && $this->$key == true) {
            return empty($valueParams);
        }

        return false;
    }

    public function hasFormat()
    {
        return $this->__isset(\SwaggerValidator\Common\FactorySwagger::KEY_FORMAT);
    }

    public function hasDefault()
    {
        return $this->__isset(\SwaggerValidator\Common\FactorySwagger::KEY_DEFAULT);
    }

    public function getDefault(\SwaggerValidator\Common\Context $context)
    {
        $context->logModel(__METHOD__, __LINE__);
        return $this->__get(\SwaggerValidator\Common\FactorySwagger::KEY_DEFAULT);
    }

    public function hasExample()
    {
        return $this->__isset(\SwaggerValidator\Common\FactorySwagger::KEY_EXAMPLE);
    }

    public function getExample(\SwaggerValidator\Common\Context $context)
    {
        $context->logModel(__METHOD__, __LINE__);
        return $this->__get(\SwaggerValidator\Common\FactorySwagger::KEY_EXAMPLE);
    }

    public function hasEnum()
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_ENUM;

        if (!$this->__isset($key)) {
            return false;
        }

        if (!is_array($this->$key)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        return true;
    }

    public function getModel(\SwaggerValidator\Common\Context $context)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_ENUM;

        if ($this->hasExample()) {
            return $this->formatModel($context, $this->getExample($context));
        }
        elseif ($this->hasDefault()) {
            return $this->formatModel($context, $this->getDefault($context));
        }
        elseif ($this->hasEnum()) {
            $valEnum = $this->$key;
            return $this->formatModel($context, $valEnum[rand(0, count($valEnum) - 1)]);
        }
        elseif ($this->hasFormat()) {
            return $this->formatModel($context, $this->getExampleFormat($context));
        }
        else {
            return $this->formatModel($context, $this->getExampleType($context));
        }
    }

    protected function formatModel(\SwaggerValidator\Common\Context $context, $value)
    {
        $keyIn   = \SwaggerValidator\Common\FactorySwagger::KEY_IN;
        $keyType = \SwaggerValidator\Common\FactorySwagger::KEY_IN;

        if (!$this->has($keyIn)) {
            return $value;
        }

        if (!$this->has($keyType)) {
            return $value;
        }

        if ($this instanceof \SwaggerValidator\DataType\TypeArray) {
            return $value;
        }

        if ($this instanceof \SwaggerValidator\DataType\TypeArrayItems) {
            return $value;
        }

        if ($this instanceof \SwaggerValidator\DataType\TypeObject) {
            return $value;
        }

        $urlEncodeLocation = array(
            \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY,
            \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH
        );

        if (in_array($this->$keyIn, $urlEncodeLocation) && is_scalar($value)) {
            return urlencode($value);
        }
        elseif (in_array($this->$keyIn, $urlEncodeLocation) && !is_scalar($value)) {
            throw new \Exception('Result is not a scallar !! ' . print_r($this, true));
        }

        return $value;
    }

    public function enum(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_ENUM;

        if (!$this->hasEnum()) {
            return true;
        }

        return in_array($valueParams, $this->$key);
    }

    public function multipleOf(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_MULTIPLEOF;

        if (!$this->__isset($key)) {
            return true;
        }

        if (!is_numeric($this->$key) || $this->$key <= 0) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        return (($valueParams % $this->$key) == 0);
    }

    public function minimum(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key   = \SwaggerValidator\Common\FactorySwagger::KEY_MINIMUM;
        $keyEx = \SwaggerValidator\Common\FactorySwagger::KEY_EXCLUSIVEMINIMUM;

        if (!$this->__isset($key)) {
            return true;
        }

        if (!$this->__isset($keyEx) || $this->$keyEx == false) {
            return ($this->$key <= $valueParams);
        }

        return ($this->$key < $valueParams);
    }

    public function maximum(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key   = \SwaggerValidator\Common\FactorySwagger::KEY_MAXIMUM;
        $keyEx = \SwaggerValidator\Common\FactorySwagger::KEY_EXCLUSIVEMAXIMUM;

        if (!$this->__isset($key)) {
            return true;
        }

        if (!$this->__isset($keyEx) || $this->$keyEx == false) {
            return ($this->$key >= $valueParams);
        }

        return ($this->$key > $valueParams);
    }

    public function minLength(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_MINLENGTH;

        if (!$this->__isset($key)) {
            return true;
        }

        return ($this->$key <= strlen($valueParams));
    }

    public function maxLength(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_MAXLENGTH;

        if (!$this->__isset($key)) {
            return true;
        }

        return ($this->$key >= strlen($valueParams));
    }

    public function minItems(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_MINITEMS;

        if (!$this->__isset($key)) {
            return true;
        }

        return ($this->$key <= count($valueParams));
    }

    public function maxItems(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_MAXITEMS;

        if (!$this->__isset($key)) {
            return true;
        }

        return ($this->$key >= count($valueParams));
    }

    public function uniqueItems(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        $key = \SwaggerValidator\Common\FactorySwagger::KEY_UNIQUEITEMS;

        if (!$this->__isset($key) || $this->$key == false) {
            return true;
        }

        return (count(array_unique($valueParams)) == count($valueParams));
    }

    public function collectionFormat(\SwaggerValidator\Common\Context $context)
    {
        $key   = \SwaggerValidator\Common\FactorySwagger::KEY_COLLECTIONFORMAT;
        $keyIn = \SwaggerValidator\Common\FactorySwagger::KEY_IN;

        if (!$this->__isset($keyIn)) {
            return $context;
        }

        switch ($this->$key) {

            case 'ssv':
                // Space separated values foo bar.
                return $context->setDataValue(explode(' ', $context->getDataValue()));

            case 'tsv':
                // Tab separated values foo\tbar.
                return $context->setDataValue(explode("\t", $context->getDataValue()));

            case 'pipes':
                // Pipe separated values foo|bar.
                return $context->setDataValue(explode('|', $context->getDataValue()));

            case 'multi':
                // Corresponds to multiple parameter instances instead of multiple values for a single instance foo=bar&foo=baz.
                // This is valid only for parameters in "query" or "formData".
                if (!in_array($context->getLocation(), array(\SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY, \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM))) {
                    return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
                }

                if (!is_array($context->getDataValue())) {
                    return $context->setDataValue(array($context->getDataValue()));
                }

                return $context;

            default:
            case 'csv':
                // Comma separated values foo,bar.
                return $context->setDataValue(explode(',', $context->getDataValue()));
        }
    }

}
