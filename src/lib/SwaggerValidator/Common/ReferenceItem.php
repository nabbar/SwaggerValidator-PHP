<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\Common;

/**
 * Description of ReferenceItem
 *
 * @author Nabbar
 */
class ReferenceItem
{

    private $contents;
    private $object;

    public function __construct($jsonData)
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

    public function extractAllReferences()
    {
        $refList = array();

        if (is_object($this->contents)) {
            $refList = $this->extractReferenceObject($this->contents);
        }
        elseif (is_array($this->contents)) {
            $refList = $this->extractReferenceArray($this->contents);
        }

        return array_unique($refList);
    }

    private function extractReferenceArray(array &$array)
    {
        $refList = array();

        foreach ($array as $key => $value) {

            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) {
                $oldRef    = $value;
                $value     = \SwaggerValidator\Common\CollectionReference::getIdFromRef($value);
                \SwaggerValidator\Common\Context::logReplaceRef($oldRef, $value, __METHOD__, __LINE__);
                $refList[] = $value;
            }
            elseif (is_array($value)) {
                $refList = $refList + $this->extractReferenceArray($value);
            }
            elseif (is_object($value)) {
                $refList = $refList + $this->extractReferenceObject($value);
            }
            else {
                continue;
            }

            $array[$key] = $value;
        }

        return $refList;
    }

    private function extractReferenceObject(\stdClass &$stdClass)
    {
        $refList = array();

        foreach (get_object_vars($stdClass) as $key => $value) {

            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) {
                $oldRef    = $value;
                $value     = \SwaggerValidator\Common\CollectionReference::getIdFromRef($value);
                \SwaggerValidator\Common\Context::logReplaceRef($oldRef, $value, __METHOD__, __LINE__);
                $refList[] = $value;
            }
            elseif (is_array($value)) {
                $refList = $refList + $this->extractReferenceArray($value);
            }
            elseif (is_object($value)) {
                $refList = $refList + $this->extractReferenceObject($value);
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
        }

        return $this->object;
    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $force = false)
    {
        $this->object = new \SwaggerValidator\DataType\TypeObject();
        $this->object->jsonUnSerialize($context, $this->contents);
    }

}
