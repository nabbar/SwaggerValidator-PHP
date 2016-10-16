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

namespace SwaggerValidator\Common;

/**
 * Description of ReferenceItem
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class ReferenceItem
{

    private $contents;
    private $object;

    public function __construct()
    {

    }

    public function setJsonData($jsonData)
    {
        $this->contents = $jsonData;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    /**
     * Var Export Method
     */
    protected function __storeData($key, $value = null)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
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

    public function extractAllReferences(\SwaggerValidator\Common\Context $context)
    {
        $refList = array();

        if (is_object($this->contents)) {
            $refList = $this->extractReferenceObject($context, $this->contents);
        }
        elseif (is_array($this->contents)) {
            $refList = $this->extractReferenceArray($context, $this->contents);
        }

        return array_unique($refList);
    }

    private function extractReferenceArray(\SwaggerValidator\Common\Context $context, array &$array)
    {
        $refList = array();

        foreach ($array as $key => $value) {

            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) {
                $oldRef    = $value;
                $value     = \SwaggerValidator\Common\CollectionReference::getIdFromRef($context, $value);
                $context->logReference('replace', $value, $oldRef, __METHOD__, __LINE__);
                $refList[] = $value;
            }
            elseif (is_array($value)) {
                $refList = $refList + $this->extractReferenceArray($context->setDataPath($key), $value);
            }
            elseif (is_object($value)) {
                $refList = $refList + $this->extractReferenceObject($context->setDataPath($key), $value);
            }
            else {
                continue;
            }

            $array[$key] = $value;
        }

        return $refList;
    }

    private function extractReferenceObject(\SwaggerValidator\Common\Context $context, \stdClass &$stdClass)
    {
        $refList = array();

        foreach (get_object_vars($stdClass) as $key => $value) {

            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) {
                $oldRef    = $value;
                $value     = \SwaggerValidator\Common\CollectionReference::getIdFromRef($context, $value);
                $context->logReference('replace', $value, $oldRef, __METHOD__, __LINE__);
                $refList[] = $value;
            }
            elseif (is_array($value)) {
                $refList = $refList + $this->extractReferenceArray($context->setDataPath($key), $value);
            }
            elseif (is_object($value)) {
                $refList = $refList + $this->extractReferenceObject($context->setDataPath($key), $value);
            }
            else {
                continue;
            }

            $stdClass->$key = $value;
        }

        return $refList;
    }

    public function getJson(\SwaggerValidator\Common\Context $context)
    {
        return $this->contents;
    }

    public function getObject(\SwaggerValidator\Common\Context $context)
    {
        if (!is_object($this->object)) {
            $this->jsonUnSerialize($context, true);
            $this->contents = null;
        }

        return $this->object;
    }

    protected function getCleanClass($class)
    {
        $classPart = explode('\\', $class);
        return array_pop($classPart);
    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context)
    {
        if (is_object($this->contents) && ($this->contents instanceof \stdClass) && property_exists($this->contents, \SwaggerValidator\Common\FactorySwagger::KEY_TYPE)) {
            $this->object = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, $this->getCleanClass(__CLASS__), \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA, $this->contents);
        }
        else {
            $this->object = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context, null, null, $this->contents);
        }
    }

}
