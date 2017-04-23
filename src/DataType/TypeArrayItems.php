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

    protected $minItems = 1;
    protected $maxItems = null;

    public function __construct()
    {

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

    public function setMinMaxItems($min = null, $max = null)
    {
        if ($min !== null && is_integer($min) && $min > 0) {
            $this->minItems = (int) $min;
        }
        if ($max !== null && is_integer($max) && $max > 0) {
            $this->maxItems = (int) $max;
        }
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
        $this->checkJsonObjectOrArray($context, $jsonData);

        $keyType       = \SwaggerValidator\Common\FactorySwagger::KEY_TYPE;
        $keyProperties = \SwaggerValidator\Common\FactorySwagger::KEY_PROPERTIES;
        $keySchema     = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;
        $keyRef        = \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE;
        $keyAllOf      = \SwaggerValidator\Common\FactorySwagger::KEY_ALLOF;
        $keyAnyOf      = \SwaggerValidator\Common\FactorySwagger::KEY_ANYOF;
        $keyOneOf      = \SwaggerValidator\Common\FactorySwagger::KEY_ONEOF;

        if (property_exists($jsonData, $keyType)) {
            $this->$keySchema = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), $keySchema, $jsonData);
            return;
        }
        elseif (property_exists($jsonData, $keyProperties)) {
            $this->$keySchema = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), $keySchema, $jsonData);
            return;
        }

        if (property_exists($jsonData, $keyAllOf) || property_exists($jsonData, $keyAnyOf) || property_exists($jsonData, $keyOneOf)) {
            $this->$keySchema = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), $keySchema, $jsonData);
            return;
        }

        if (property_exists($jsonData, $keyRef)) {
            $this->registerRecursiveDefinitions($context, $jsonData);
            $this->$keySchema = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), null, $jsonData);
            return;
        }

        if (is_object($jsonData)) {
            $context->throwException('Mismatching type of JSON Data received', __METHOD__, __LINE__);
        }

        foreach ($jsonData as $key => $value) {
            $this->registerRecursiveDefinitions($context, $value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        $context->logDecode(get_class($this), __METHOD__, __LINE__);
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

        $context->logValidate(get_class($this), __METHOD__, __LINE__);
        return $result;
    }

    public function countItems(\SwaggerValidator\Common\Context $context, $additionItems = true, $valueParams = null)
    {
        $keySchema = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;

        if (isset($this->$keySchema)) {
            return true;
        }

        if ($additionItems && (count($this->items) <= count($valueParams))) {
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

        $min = 1;
        $max = 1;

        if ($this->minItems > 0) {
            $min = $this->minItems;
        }

        if ($this->maxItems > 0) {
            $max = $this->maxItems;
        }

        if ($max > $min) {
            $count = random_int($min, $max);
        }
        else {
            $count = $min;
        }

        if (isset($this->$keySchema) && is_object($this->$keySchema)) {
            for ($i = 0; $i < $count; $i++) {
                $result[] = $this->$keySchema->getModel($context);
            }
            if ($min > count($result) || $max < count($result)) {
                throw new \Exception('Generated model has not enought items : ' . json_encode(array(
                    'min' => $min,
                    'max' => $max,
                    'rnd' => $count,
                    'nbr' => count($result),
                    'cnt' => $i
                )));
            }
            $context->logModel(__METHOD__, __LINE__);
            return $result;
        }

        foreach ($this->keys() as $key) {
            $result[] = $this->getExampleTypeValue($context, $key);
        }

        if ($count > count($result)) {
            for ($i = count($result); $i < $count; $i++) {
                $result[] = $this->getExampleTypeValue($context, $key);
            }
        }

        $context->logModel(__METHOD__, __LINE__);
        return $result;
    }

    protected function getExampleTypeSchema(\SwaggerValidator\Common\Context $context)
    {
        return $this->$keySchema->getModel($context);
    }

    protected function getExampleTypeValue(\SwaggerValidator\Common\Context $context, $key)
    {
        if (is_object($this->$key) && method_exists($this->$key, 'getModel')) {
            return $this->$key->getModel($context);
        }
        else {
            return $this->$key;
        }
    }

}
