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
 * Description of Array
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class TypeArray extends \SwaggerValidator\DataType\TypeCommon
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
        parent::registerMandatoryKey('items');
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

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $context->throwException('Mismatching type of JSON Data received', __METHOD__, __LINE__);
        }

        if (!($jsonData instanceof \stdClass)) {
            $context->throwException('Mismatching type of JSON Data received', __METHOD__, __LINE__);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        $keyMinItems = \SwaggerValidator\Common\FactorySwagger::KEY_MINITEMS;
        $keyMaxItems = \SwaggerValidator\Common\FactorySwagger::KEY_MAXITEMS;
        $keyItems    = \SwaggerValidator\Common\FactorySwagger::KEY_ITEMS;
        $valMinItems = null;
        $valMaxItems = null;

        if ($this->__isset($keyMinItems)) {
            $valMinItems = $this->$keyMinItems;
        }

        if ($this->__isset($keyMaxItems)) {
            $valMaxItems = $this->$keyMaxItems;
        }

        if ($this->__isset($keyItems) && is_object($this->$keyItems) && $this->$keyItems instanceof \SwaggerValidator\DataType\TypeArrayItems) {
            $this->$keyItems->setMinMaxItems($valMinItems, $valMaxItems);
        }

        $context->logDecode(get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        $keyType        = \SwaggerValidator\Common\FactorySwagger::KEY_TYPE;
        $keyItems       = \SwaggerValidator\Common\FactorySwagger::KEY_ITEMS;
        $keyAdditional  = \SwaggerValidator\Common\FactorySwagger::KEY_ADDITEMS;
        $keyMinItems    = \SwaggerValidator\Common\FactorySwagger::KEY_MINITEMS;
        $keyMaxItems    = \SwaggerValidator\Common\FactorySwagger::KEY_MAXITEMS;
        $keyUniqueItems = \SwaggerValidator\Common\FactorySwagger::KEY_UNIQUEITEMS;

        if (!isset($this->$keyType)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!isset($this->$keyAdditional)) {
            $additionnal = true;
        }
        else {
            $additionnal = (bool) $this->$keyAdditional;
        }

        if ($this->$keyType != \SwaggerValidator\Common\FactorySwagger::TYPE_ARRAY) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        $context = $this->collectionFormat($context);
        if (!is_object($context) || !($context instanceof \SwaggerValidator\Common\Context)) {
            return false;
        }

        if ((!$this->__isset($keyMinItems) || $this->$keyMinItems < 1) && $context->isDataEmpty()) {
            return true;
        }

        if (!$this->type($context, $context->getDataValue())) {
            return $context->setDataCheck($keyType)->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
        }

        if (!$this->minItems($context, $context->getDataValue())) {
            return $context->setDataCheck($keyMinItems)->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, 'Value has not enough items', __METHOD__, __LINE__);
        }

        if (!$this->maxItems($context, $context->getDataValue())) {
            return $context->setDataCheck($keyMaxItems)->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, 'Value has too many items', __METHOD__, __LINE__);
        }

        if (isset($this->uniqueItems) && $this->uniqueItems === true) {
            $uniqValue = array_unique($context->getDataValue());

            if ($uniqValue != $context->getDataValue()) {
                return $context->setDataCheck($keyUniqueItems)->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Value has not only uniq items', __METHOD__, __LINE__);
            }
        }

        if (!isset($this->$keyItems) || !is_object($this->$keyItems) || !method_exists($this->$keyItems, __FUNCTION__)) {
            return $context->setDataCheck($keyItems)->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!$this->$keyItems->countItems($context, $additionnal, $context->getDataValue())) {
            return false;
        }

        $context->logValidate(get_class($this), __METHOD__, __LINE__);
        return $this->$keyItems->validate($context, $context->getDataValue());
    }

    protected function type(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (is_array($valueParams)) {
            return true;
        }

        return false;
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
        $keyItems = \SwaggerValidator\Common\FactorySwagger::KEY_ITEMS;

        if (is_object($this->$keyItems) && method_exists($this->$keyItems, 'getModel')) {
            $result = $this->$keyItems->getModel($context);
        }
        else {
            $result = $this->$keyItems;
        }

        $keyColl = \SwaggerValidator\Common\FactorySwagger::KEY_COLLECTIONFORMAT;
        $keyIn   = \SwaggerValidator\Common\FactorySwagger::KEY_IN;

        if (!$this->__isset($keyIn) || $context->getType() == \SwaggerValidator\Common\Context::TYPE_RESPONSE) {
            $context->logModel(__METHOD__, __LINE__);
            return $result;
        }

        $validLocation = array(
            \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY,
            \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM
        );

        switch ($this->$keyColl) {

            case 'ssv':
                // Space separated values foo bar.
                $context->logModel(__METHOD__, __LINE__);
                $result = implode(' ', $result);
                break;

            case 'tsv':
                // Tab separated values foo\tbar.
                $context->logModel(__METHOD__, __LINE__);
                $result = implode("\t", $result);
                break;

            case 'pipes':
                // Pipe separated values foo|bar.
                $context->logModel(__METHOD__, __LINE__);
                $result = implode('|', $result);
                break;

            case 'multi':
                // Corresponds to multiple parameter instances instead of multiple values for a single instance foo=bar&foo=baz.
                // This is valid only for parameters in "query" or "formData".
                if (!in_array($this->$keyIn, $validLocation)) {
                    return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
                }

                $context->logModel(__METHOD__, __LINE__);
                break;

            default:
            case 'csv':
                // Comma separated values foo,bar.
                $context->logModel(__METHOD__, __LINE__);
                $result = implode(',', $result);
                break;
        }

        $urlEncodeLocation = array(
            \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY,
            \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH,
        );

        if (is_array($result) && in_array($this->$keyIn, $urlEncodeLocation)) {
            return array_map('urlencode', $result);
        }
        elseif (in_array($this->$keyIn, $urlEncodeLocation)) {
            return urlencode($result);
        }
    }

}
