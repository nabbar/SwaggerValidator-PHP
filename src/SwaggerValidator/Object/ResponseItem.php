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
 * Description of ResponseItem
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class ResponseItem extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {
        parent::registerMandatoryKey('description');
    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        $schemaKey = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;
        if (property_exists($jsonData, $schemaKey)) {
            $jsonData->$schemaKey = $this->extractNonRecursiveReference($context, $jsonData->$schemaKey);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {

            if (substr($key, 0, strlen(\SwaggerValidator\Common\FactorySwagger::KEY_CUSTOM_PATTERN)) == \SwaggerValidator\Common\FactorySwagger::KEY_CUSTOM_PATTERN) {
                continue;
            }

            $value = $this->extractNonRecursiveReference($context, $value);

            $schemaKey = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;
            if (is_object($value) && property_exists($value, $schemaKey)) {
                $value->$schemaKey = $this->extractNonRecursiveReference($context->setDataPath($key), $value->$schemaKey);
            }

            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        $check = true;

        $keyHeaders = \SwaggerValidator\Common\FactorySwagger::KEY_HEADERS;

        if ($this->has($keyHeaders) && is_object($this->$keyHeaders) && $this->$keyHeaders instanceof \SwaggerValidator\Object\Headers) {
            $check = $check && $this->$keyHeaders->validate($context->setDataPath($keyHeaders)->setLocation(\SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER));
        }

        $keySchema = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;

        if ($this->has($keySchema) && is_object($this->$keySchema) && $this->$keySchema instanceof \SwaggerValidator\Common\CollectionSwagger) {
            $ctx   = $context->setDataPath(\SwaggerValidator\Common\FactorySwagger::LOCATION_BODY)->setLocation(\SwaggerValidator\Common\FactorySwagger::LOCATION_BODY);
            $ctx->dataLoad();
            \SwaggerValidator\Common\Context::addCheckedDataName(\SwaggerValidator\Common\FactorySwagger::LOCATION_BODY, null);
            $check = $check && $this->$keySchema->validate($ctx);
        }

        return $check;
    }

    public function getModel(\SwaggerValidator\Common\Context $context, $globalResponse = array())
    {
        $headersKey = \SwaggerValidator\Common\FactorySwagger::KEY_HEADERS;
        $schemaKey  = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;
        $headers    = array();
        $schema     = null;

        if (!array_key_exists($headersKey, $globalResponse)) {
            $globalResponse[$headersKey] = array();
        }

        if (!array_key_exists($schemaKey, $globalResponse)) {
            $globalResponse[$schemaKey] = null;
        }

        if (isset($this->$headersKey) && is_object($this->$headersKey) && ($this->$headersKey instanceof \SwaggerValidator\Object\HeaderItem)) {
            $globalResponse[$headersKey] = $this->$headersKey->getModel($context->setDataPath($headersKey), $globalResponse[$headersKey]);
        }

        if (isset($this->$schemaKey) && is_object($this->$schemaKey) && method_exists($this->$schemaKey, 'getModel')) {
            $globalResponse[$schemaKey] = $this->$schemaKey->getModel($context->setDataPath($schemaKey)->setType(\SwaggerValidator\Common\Context::TYPE_RESPONSE));
        }

        if (empty($globalResponse[$headersKey])) {
            unset($globalResponse[$headersKey]);
        }

        if (empty($globalResponse[$schemaKey])) {
            unset($globalResponse[$schemaKey]);
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $globalResponse;
    }

}
