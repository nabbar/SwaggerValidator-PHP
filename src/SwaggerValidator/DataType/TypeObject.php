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
 * Description of TypeCombined
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class TypeObject extends \SwaggerValidator\Common\CollectionSwagger
{

    /**
     *
     * @var array
     */
    protected $required = array();

    /**
     *
     * @var array
     */
    protected $additionalProperties = array();

    /**
     *
     * @var array
     */
    protected $properties = array();

    public function __construct()
    {

    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (property_exists($jsonData, \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) && count(get_object_vars($jsonData)) > 1) {
            $this->buildException('Invalid object with an external reference ! ', $context);
        }

        $this->required             = array();
        $this->additionalProperties = array();
        $this->properties           = array();

        foreach (get_object_vars($jsonData) as $key => $value) {

            if (!is_object($value) && !is_array($value)) {
                $this->$key = $value;
                continue;
            }

            if ($key == \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA) {
                $value = $this->extractNonRecursiveReference($context, $value);
            }

            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REQUIRED) {
                $this->required = $value;
                continue;
            }

            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_ADDPROPERTIES) {
                if (is_object($value)) {
                    $this->additionalProperties = array_keys(get_object_vars($value));
                    $this->jsonUnSerializeProperties($context->setDataPath($key), $value);
                }

                continue;
            }

            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_PROPERTIES) {
                if (is_object($value)) {
                    $this->properties = array_keys(get_object_vars($value));
                    $this->jsonUnSerializeProperties($context->setDataPath($key), $value);
                }

                continue;
            }

            $this->registerRecursiveDefinitions($value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    protected function jsonUnSerializeProperties(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {
            $this->registerRecursiveDefinitions($value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }
    }

    public function jsonSerialize()
    {
        if (parent::__isset(\SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA)) {
            return parent::jsonSerialize();
        }

        $properties = \SwaggerValidator\Common\FactorySwagger::KEY_PROPERTIES;
        $additional = \SwaggerValidator\Common\FactorySwagger::KEY_ADDPROPERTIES;
        $required   = \SwaggerValidator\Common\FactorySwagger::KEY_REQUIRED;
        $type       = \SwaggerValidator\Common\FactorySwagger::KEY_TYPE;

        $result        = new \stdClass();
        $result->$type = \SwaggerValidator\Common\FactorySwagger::TYPE_OBJECT;

        if (!empty($this->required)) {
            $result->$required = $this->required;
        }

        if (!empty($this->additionalProperties)) {
            $result->$additional = $this->additionalProperties;
        }

        if (!empty($this->properties)) {
            $result->$properties = new \stdClass();
        }

        foreach ($this->keys() as $key) {

            if ($key == $type) {
                continue;
            }

            if (in_array($key, $this->properties, true)) {
                $result->$properties->$key = json_decode(\SwaggerValidator\Common\Collection::jsonEncode($this->$key), false);
            }
            elseif (in_array($key, $this->additionalProperties, true)) {
                $result->$additional->$key = json_decode(\SwaggerValidator\Common\Collection::jsonEncode($this->$key), false);
            }
            elseif (!in_array($key, array($properties, $additional, $required, $type))) {
                $result->$key = json_decode(\SwaggerValidator\Common\Collection::jsonEncode($this->$key), false);
            }
        }

        return $result;
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        $keyRequired   = \SwaggerValidator\Common\FactorySwagger::KEY_REQUIRED;
        $keyAdditional = \SwaggerValidator\Common\FactorySwagger::KEY_ADDPROPERTIES;

        $required             = array();
        $additionalProperties = true;

        if (isset($this->$keyRequired)) {
            $required = $this->$keyRequired;
        }

        if (is_array($this->additionalProperties) && count($this->additionalProperties) > 0) {
            $additionalProperties = $this->$keyAdditional;
        }
        elseif ($this->additionalProperties !== false) {
            $additionalProperties = true;
        }

        $valueProperties = $context->getDataValue();

        if (!is_object($valueProperties)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, 'Value is an object !!');
        }

        $propFound = array();

        foreach ($this->keys() as $key) {

            if ($key == $keyRequired || $key == $keyAdditional) {
                continue;
            }

            if (!is_object($this->$key) || !method_exists($this->$key, 'validate')) {
                continue;
            }

            if (in_array($key, $required) && !property_exists($valueProperties, $key)) {
                return $context->setDataPath($key)->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_NOTFOUND, 'Property "' . $key . '" Not found in the object value');
            }
            elseif (!property_exists($valueProperties, $key)) {
                continue;
            }

            $propFound[] = $key;

            if (!$this->$key->validate($context->setDataPath($key)->setDataCheck('validate')->setDataValue($valueProperties->$key))) {
                return false;
            }
        }

        if ($additionalProperties === true) {
            \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
            return true;
        }

        foreach (array_keys(get_object_vars($valueProperties)) as $key) {

            if (is_array($additionalProperties) && in_array($key, $additionalProperties)) {
                continue;
            }

            if (!in_array($key, $propFound)) {
                return $context->setDataPath($key)->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_TOOMANY, 'Property "' . $key . '" is not awaiting in the value object !');
            }
        }

        \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    public function getModel(\SwaggerValidator\Common\Context $context)
    {
        $result = new \stdClass();

        foreach ($this->properties as $key) {
            if (!$this->has($key)) {
                continue;
            }

            $object = $this->$key;

            if (is_object($object)) {
                $result->$key = $object->getModel($context->setDataPath($key));
            }
            else {
                $result->$key = $object;
            }
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $result;
    }

}
