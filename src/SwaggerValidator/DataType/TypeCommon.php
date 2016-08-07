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

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->throwException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->throwException('Mismatching type of JSON Data received', $context);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {
            $this->$key = $value;
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function isRequired()
    {
        if (isset($this->required)) {
            return (bool) ($this->required);
        }

        return false;
    }

    public function pattern(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('pattern')) {
            return true;
        }

        if (empty($this->pattern)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        $pattern = str_replace('~', '\~', $this->pattern);

        return preg_match('~' . $pattern . '~', $valueParams);
    }

    public function allowEmptyValue(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (isset($this->allowEmptyValue) && $this->allowEmptyValue == true) {
            return empty($valueParams);
        }

        return false;
    }

    public function hasFormat()
    {
        return $this->__isset('format');
    }

    public function hasDefault()
    {
        return $this->__isset('default');
    }

    public function getDefault(\SwaggerValidator\Common\Context $context)
    {
        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $this->__get('default');
    }

    public function hasExample()
    {
        return $this->__isset('example');
    }

    public function getExample(\SwaggerValidator\Common\Context $context)
    {
        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $this->__get('example');
    }

    public function hasEnum()
    {
        return $this->__isset('enum') && is_array($this->enum);
    }

    public function getModel(\SwaggerValidator\Common\Context $context)
    {
        if ($this->hasExample()) {
            return $this->getExample($context);
        }
        elseif ($this->hasDefault()) {
            return $this->getDefault($context);
        }
        elseif ($this->hasEnum()) {
            return $this->enum[0];
        }
        elseif ($this->hasFormat()) {
            return $this->getExampleFormat($context);
        }
        else {
            return $this->getExampleType($context);
        }
    }

    public function enum(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('enum')) {
            return true;
        }
        if (!is_array($this->enum)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        return in_array($valueParams, $this->enum);
    }

    public function multipleOf(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('multipleOf')) {
            return true;
        }

        if (!is_numeric($this->multipleOf) || $this->multipleOf <= 0) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        return (($valueParams % $this->multipleOf) == 0);
    }

    public function minimum(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('minimum')) {
            return true;
        }

        if (!$this->__isset('exclusiveMinimum') || $this->exclusiveMinimum == false) {
            return ($this->minimum <= $valueParams);
        }

        return ($this->minimum < $valueParams);
    }

    public function maximum(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('maximum')) {
            return true;
        }

        if (!$this->__isset('exclusiveMaximum') || $this->exclusiveMaximum == false) {
            return ($this->maximum >= $valueParams);
        }

        return ($this->maximum > $valueParams);
    }

    public function minLength(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('minLength')) {
            return true;
        }

        return ($this->minLength <= strlen($valueParams));
    }

    public function maxLength(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('maxLength')) {
            return true;
        }

        return ($this->maxLength >= strlen($valueParams));
    }

    public function minItems(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('minItems')) {
            return true;
        }

        return ($this->minItems <= count($valueParams));
    }

    public function maxItems(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('maxItems')) {
            return true;
        }

        return ($this->maxItems >= count($valueParams));
    }

    public function uniqueItems(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('uniqueItems') || $this->uniqueItems == false) {
            return true;
        }

        return (count(array_unique($valueParams)) == count($valueParams));
    }

    public function collectionFormat(\SwaggerValidator\Common\Context $context)
    {
        if (!$this->__isset('collectionFormat')) {
            return false;
        }

        switch ($this->collectionFormat) {

            case 'ssv':
                // Space separated values foo bar.
                $valueParams = explode(' ', $valueParams);
                break;

            case 'tsv':
                // Tab separated values foo\tbar.
                $valueParams = explode("\t", $valueParams);
                break;

            case 'pipes':
                // Pipe separated values foo|bar.
                $valueParams = explode('|', $valueParams);
                break;

            case 'multi':
                // Corresponds to multiple parameter instances instead of multiple values for a single instance foo=bar&foo=baz.
                // This is valid only for parameters in "query" or "formData".
                if (!in_array($context->getLocation(), array(\SwaggerValidator\Common\Context::LOCATION_QUERY, \SwaggerValidator\Common\Context::LOCATION_FORM))) {
                    return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
                }

                /**
                 * @todo Making parsing multi for collectionFormat
                 */
                break;

            default:
            case 'csv':
                // Comma separated values foo,bar.
                $valueParams = explode(',', $valueParams);
                break;
        }

        return true;
    }

}
