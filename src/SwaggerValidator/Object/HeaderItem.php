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
 * Description of HeaderItem
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class HeaderItem extends \SwaggerValidator\Common\CollectionSwagger
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

        $header     = $this->extractNonRecursiveReference($context, $jsonData);
        $this->item = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath('header'), $this->getCleanClass(__CLASS__), $this->name, $header);

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        if (isset($this->item)) {

            $context->setLocation(\SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER);
            $context->dataLoad();

            return $this->item->validate($context);
        }

        $this->buildException('Cannot find a well formed item in the headeritem object', $context);
    }

    public function getModel(\SwaggerValidator\Common\Context $context)
    {
        if (isset($this->item)) {

            $context->setLocation(\SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER);
            $context->dataLoad();

            return $this->item->getModel($context);
        }

        $this->buildException('Cannot find a well formed item in the headeritem object', $context);
    }

}
