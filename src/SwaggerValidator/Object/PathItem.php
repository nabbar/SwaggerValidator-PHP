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
 * Description of PathItem
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class PathItem extends \SwaggerValidator\Common\CollectionSwagger
{

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

        foreach (get_object_vars($jsonData) as $key => $value) {

            if (substr($key, 0, strlen(\SwaggerValidator\Common\FactorySwagger::KEY_CUSTOM_PATTERN)) == \SwaggerValidator\Common\FactorySwagger::KEY_CUSTOM_PATTERN) {
                continue;
            }

            $value      = $this->extractNonRecursiveReference($context, $value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        foreach ($this->keys() as $key) {
            if (is_object($this->$key) && ($this->$key instanceof \SwaggerValidator\Object\Operation)) {
                continue;
            }

            if (is_object($this->$key) && method_exists($this->$key, 'validate')) {
                $this->$key->validate($context->setDataPath($key));
            }
        }

        $currentMethod = $context->getMethod();

        if (isset($this->$currentMethod) && is_object($this->$currentMethod) && ($this->$key instanceof \SwaggerValidator\Object\Operation)) {
            \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
            return $this->$currentMethod->validate($context->setDataPath($currentMethod));
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_METHOD_ERROR, 'Method not found to this route', __METHOD__, __LINE__);
    }

    public function getModel(\SwaggerValidator\Common\Context $context, $paramsResponses = array())
    {
        $parameters = \SwaggerValidator\Common\FactorySwagger::KEY_PARAMETERS;
        $responses  = \SwaggerValidator\Common\FactorySwagger::KEY_RESPONSES;
        $consumes   = \SwaggerValidator\Common\FactorySwagger::KEY_CONSUMES;
        $produces   = \SwaggerValidator\Common\FactorySwagger::KEY_PRODUCES;
        $result     = array();

        if (!array_key_exists($parameters, $paramsResponses)) {
            $paramsResponses[$parameters] = array();
        }

        if (isset($this->$parameters) && is_object($this->$parameters) && ($this->$parameters instanceof \SwaggerValidator\Object\Parameters)) {
            $this->$parameters->getModel($context->setDataPath($parameters), $paramsResponses[$parameters]);
        }

        if (!array_key_exists($responses, $paramsResponses)) {
            $paramsResponses[$responses] = array();
        }

        if (isset($this->$responses) && is_object($this->$responses) && ($this->$responses instanceof \SwaggerValidator\Object\Responses)) {
            $this->$responses->getModel($context->setDataPath($responses), $paramsResponses[$responses]);
        }

        if (isset($this->$consumes) && is_array($this->$consumes)) {
            $paramsResponses[$consumes] = $this->$consumes;
        }

        if (isset($this->$produces) && is_array($this->$produces)) {
            $paramsResponses[$produces] = $this->$produces;
        }

        foreach ($this->keys() as $key) {
            if (!is_object($this->$key) || !($this->$key instanceof \SwaggerValidator\Object\Operation)) {
                continue;
            }

            $result[$key] = $this->$key->getModel($context->setDataPath($key), $paramsResponses);
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $result;
    }

}
