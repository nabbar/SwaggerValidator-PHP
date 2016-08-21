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
 * Description of Responses
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Responses extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {

    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        $this->checkJsonObject($context, $jsonData);

        foreach (get_object_vars($jsonData) as $key => $value) {

            if (!preg_match('/^([0-9]{3})$|^(' . \SwaggerValidator\Common\FactorySwagger::KEY_DEFAULT . ')$/', $key)) {
                $this->throwException('Invalid Key "' . $key . '" for a response item', array('context' => $context, 'JSON Data' => $jsonData), __METHOD__, __LINE__);
            }

            $value      = $this->extractNonRecursiveReference($context, $value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        $status = $context->getResponseStatus();

        if ($this->has($status)) {
            return $this->$status->validate($context->setDataPath($status));
        }

        $keyDefault = \SwaggerValidator\Common\FactorySwagger::KEY_DEFAULT;

        if ($this->has($keyDefault)) {
            return $this->$keyDefault->validate($context->setDataPath($keyDefault));
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_RESPONSE_ERROR, 'Response Code not found to this route', __METHOD__, __LINE__);
    }

    public function getModel(\SwaggerValidator\Common\Context $context, &$listParameters)
    {
        foreach ($this->keys() as $key) {

            if (!preg_match('/^([0-9]{3})$|^(default)$/', $key) || !is_object($this->$key) || !($this->$key instanceof \SwaggerValidator\Object\ResponseItem)) {
                continue;
            }

            if (!array_key_exists($key, $listParameters)) {
                $listParameters[$key] = array();
            }

            $response = $this->$key->getModel($context->setDataPath($key), $listParameters[$key]);

            if (empty($response)) {
                $response = null;
            }

            $listParameters[$key] = $response;
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
    }

}
