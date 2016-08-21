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
 * Description of Operation
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Operation extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {
        parent::registerMandatoryKey('responses');
    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        $this->checkJsonObject($context, $jsonData);

        foreach (get_object_vars($jsonData) as $key => $value) {

            $value      = $this->extractNonRecursiveReference($context, $value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        switch ($context->getType()) {
            case \SwaggerValidator\Common\Context::TYPE_RESPONSE:
                return $this->validateResponse($context);

            default:
                return $this->validateRequest($context);
        }
    }

    private function validateRequest(\SwaggerValidator\Common\Context $context)
    {
        $keyParameters = \SwaggerValidator\Common\FactorySwagger::KEY_PARAMETERS;

        if (isset($this->$keyParameters) && is_object($this->$keyParameters)) {
            \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
            return $this->$keyParameters->validate($context->setDataPath($keyParameters));
        }

        \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    private function validateResponse(\SwaggerValidator\Common\Context $context)
    {
        $keyResponses = \SwaggerValidator\Common\FactorySwagger::KEY_RESPONSES;

        if (isset($this->$keyResponses)) {
            \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
            return $this->$keyResponses->validate($context->setDataPath($keyResponses));
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, 'Responses key not found', __METHOD__, __LINE__);
    }

    public function getModel(\SwaggerValidator\Common\Context $context, $generalItems = array())
    {
        $parameters = \SwaggerValidator\Common\FactorySwagger::KEY_PARAMETERS;
        $responses  = \SwaggerValidator\Common\FactorySwagger::KEY_RESPONSES;
        $consumes   = \SwaggerValidator\Common\FactorySwagger::KEY_CONSUMES;
        $produces   = \SwaggerValidator\Common\FactorySwagger::KEY_PRODUCES;

        $this->getMethodGeneric($context, __FUNCTION__, $generalItems);
        $this->getModelConsumeProduce($generalItems);

        foreach (array_keys($generalItems) as $key) {
            if (empty($generalItems[$key])) {
                $generalItems[$key] = null;
            }
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $generalItems;
    }

}
