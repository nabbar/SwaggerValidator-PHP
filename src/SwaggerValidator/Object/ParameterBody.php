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
 * Description of ParameterBody
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class ParameterBody extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {
        parent::registerMandatoryKey('schema');
        parent::__set('name', \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY);
    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        $this->checkJsonObject($context, $jsonData);

        $schemaKey = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;

        if (property_exists($jsonData, $schemaKey)) {
            $jsonData->$schemaKey = $this->extractNonRecursiveReference($context, $jsonData->$schemaKey);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        $keySchema = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;
        return $this->$keySchema->validate($context);
    }

    public function getModel(\SwaggerValidator\Common\Context $context)
    {
        $schemaKey = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;
        return $this->$schemaKey->getModel($context->setType(\SwaggerValidator\Common\Context::TYPE_REQUEST));
    }

    public function isRequired()
    {
        if (isset($this->required)) {
            return (bool) ($this->required);
        }

        return false;
    }

}
