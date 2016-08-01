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
 * Description of TypeArrayItems
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class TypeArrayItems extends \SwaggerValidator\DataType\TypeCommon
{

    public function __construct()
    {

    }

    public function jsonSerialize()
    {
        $keySchema = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;

        if (isset($this->$keySchema) && is_object($this->$keySchema)) {
            return json_decode(self::jsonEncode($this->$keySchema));
        }

        // Check if each keys is matching the received params
        $result = array();

        foreach ($this->keys() as $key) {
            $result[$key] = json_decode(self::jsonEncode($this->$keySchema));
        }

        return $result;
    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        if (is_object($jsonData) && !($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }
        elseif (!is_object($jsonData) && !is_array($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        $keyType   = \SwaggerValidator\Common\FactorySwagger::KEY_TYPE;
        $keySchema = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;
        $keyRef    = \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE;
        $keyAllOf  = \SwaggerValidator\Common\FactorySwagger::KEY_ALLOF;
        $keyAnyOf  = \SwaggerValidator\Common\FactorySwagger::KEY_ANYOF;
        $keyOneOf  = \SwaggerValidator\Common\FactorySwagger::KEY_ONEOF;

        if (is_object($jsonData) && property_exists($jsonData, $keyType)) {
            $this->$keySchema = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), $keySchema, $jsonData);
            return;
        }

        if (is_object($jsonData) && (property_exists($jsonData, $keyAllOf) || property_exists($jsonData, $keyAnyOf) || property_exists($jsonData, $keyOneOf))) {
            $this->$keySchema = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), $keySchema, $jsonData);
            return;
        }

        if (is_object($jsonData) && property_exists($jsonData, $keyRef)) {
            $this->registerRecursiveDefinitions($jsonData);
            $this->$keySchema = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), null, $jsonData);
            return;
        }

        if (is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        foreach ($jsonData as $key => $value) {
            $this->registerRecursiveDefinitions($value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context, $valueParams = null)
    {
        $result    = true;
        $lastKey   = null;
        $keySchema = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;

        if (isset($this->$keySchema) && is_object($this->$keySchema)) {
            $lastKey = $keySchema;
        }
        else {
            // Check if each keys is matching the received params

            $myArrayValue = $context->getDataValue();

            foreach ($this->keys() as $key) {
                $lastKey = $key;

                if (!array_key_exists($key, $context->getDataValue())) {
                    $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_NOTFOUND, 'Item "' . $key . '" not found in an array', __METHOD__, __LINE__);
                }

                $value = $myArrayValue[$key];

                if (is_object($this->$key) && method_exists($this->$key, 'validate')) {
                    $result = $result && $this->$key->validate($context->setDataPath($key)->setDataValue($value));
                }
                elseif ($this->$key != $value) {
                    $result = $result && $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Item "' . $key . '" does not matching the awaiting value', __METHOD__, __LINE__);
                }
            }
        }

        // Check if each more keys in the received params matching the last registred keys
        foreach ($context->getDataValue() as $key => $value) {
            if ($lastKey !== $keySchema && $this->has($key)) {
                continue;
            }

            if (is_object($this->$lastKey) && method_exists($this->$lastKey, 'validate')) {
                $result = $result && $this->$lastKey->validate($context->setDataPath($key)->setDataValue($value));
            }
            elseif ($this->$lastKey != $value) {
                $result = $result && $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Item "' . $key . '" does not matching the awaiting value', __METHOD__, __LINE__);
            }
        }

        \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return $result;
    }

    public function countItems(\SwaggerValidator\Common\Context $context, $additionItems = true, $valueParams = null)
    {
        $keySchema = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;

        if (isset($this->$keySchema)) {
            return true;
        }

        if ($additionItems && (count($this->items) >= count($valueParams))) {
            return true;
        }
        elseif (count($this->items) == count($valueParams)) {
            return true;
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, 'The items number does not match the awaiting', __METHOD__, __LINE__);
    }

    protected function type(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function format(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function getExampleFormat(\SwaggerValidator\Common\Context $context)
    {
        return $this->getExampleType($context);
    }

    protected function getExampleType(\SwaggerValidator\Common\Context $context)
    {
        $keySchema = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;
        $result    = array();

        if (isset($this->$keySchema) && is_object($this->$keySchema)) {
            return array($this->$keySchema->getModel($context));
        }

        foreach ($this->keys() as $key) {
            if (is_object($this->$key) && method_exists($this->$key, 'getModel')) {
                $result[$key] = $this->$key->getModel($context);
            }
            else {
                $result[$key] = $this->$key;
            }
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $result;
    }

}
