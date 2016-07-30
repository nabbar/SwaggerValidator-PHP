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

namespace SwaggerValidator\Object;

/**
 * Description of Parameters
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Parameters extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {

    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData) && !is_array($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (is_object($jsonData) && !($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }
        elseif (is_object($jsonData)) {
            $jsonData = get_object_vars($jsonData);
        }
        elseif (is_array($jsonData)) {
            parent::setJSONIsArray();
        }

        $keyIn = \SwaggerValidator\Common\FactorySwagger::KEY_IN;

        foreach ($jsonData as $key => $value) {
            $value = $this->extractNonRecursiveReference($context, $value);

            if (!property_exists($value, $keyIn)) {
                $this->buildException('Parameters "' . $key . '" is not well defined !', $context);
            }

            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        if ($context->getType() !== \SwaggerValidator\Common\Context::TYPE_REQUEST) {
            return true;
        }

        $check = true;

        foreach ($this->keys() as $key) {
            if (is_object($this->$key) && ($this->$key instanceof \SwaggerValidator\Object\ParameterBody)) {
                \SwaggerValidator\Common\Context::addCheckedDataName(\SwaggerValidator\Common\FactorySwagger::LOCATION_BODY, null);
                $check = $check && $this->checkExistsEmptyValidate($context->setDataPath(\SwaggerValidator\Common\FactorySwagger::LOCATION_BODY)->setLocation(\SwaggerValidator\Common\FactorySwagger::LOCATION_BODY), $key);
            }
            elseif (is_object($this->$key) && ($this->$key instanceof \SwaggerValidator\DataType\TypeCommon)) {
                \SwaggerValidator\Common\Context::addCheckedDataName($this->$key->in, $this->$key->name);
                $check = $check && $this->checkExistsEmptyValidate($context->setDataPath($this->$key->name)->setLocation($this->$key->in), $key);
            }
        }

        \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function checkExistsEmptyValidate(\SwaggerValidator\Common\Context $context, $key)
    {
        $context->dataLoad();
        $keyRequired = \SwaggerValidator\Common\FactorySwagger::KEY_REQUIRED;

        if ($this->$key->isRequired() == true && !$context->isDataExists()) {
            $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_NOTFOUND, $context->getDataPath() . ' is not found', __METHOD__, __LINE__);
        }
        elseif (!$context->isDataExists()) {
            return true;
        }

        return $this->$key->validate($context);
    }

    function getModel(\SwaggerValidator\Common\Context $context, &$listParameters)
    {
        foreach ($this->keys() as $key) {
            $model = null;
            $in    = null;
            $name  = null;

            if (is_object($this->$key) && ($this->$key instanceof \SwaggerValidator\Object\ParameterBody)) {
                $name  = \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY;
                $in    = \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY;
                $model = $this->$key->getModel($context->setDataPath($key));
            }
            elseif (is_object($this->$key) && ($this->$key instanceof \SwaggerValidator\DataType\TypeCommon)) {
                $name  = $this->$key->name;
                $in    = $this->$key->in;
                $model = $this->$key->getModel($context->setDataPath($key));
            }

            if (!array_key_exists($in, $listParameters) || !is_array($listParameters[$in])) {
                $listParameters[$in] = array();
            }

            $listParameters[$in][$name] = $model;
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
    }

}
