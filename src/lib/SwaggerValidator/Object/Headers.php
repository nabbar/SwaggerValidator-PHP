<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\Object;

/**
 * Description of Headers
 *
 * @author Nabbar
 */
class Headers extends \SwaggerValidator\Common\CollectionSwagger
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
            $value      = $this->extractNonRecursiveReference($context, $value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        $check = true;

        foreach ($this->keys() as $key) {
            if (is_object($this->$key) && ($this->$key instanceof \SwaggerValidator\Object\HeaderItem)) {
                \SwaggerValidator\Common\Context::addCheckedDataName(\SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER, $key);
                $check = $check && $this->$key->validate($context->setDataPath($key));
            }
        }

        return $check;
    }

    public function getModel(\SwaggerValidator\Common\Context $context, $globalResponse = array())
    {
        foreach ($this->keys() as $key) {

            if (!is_object($this->$key) || !($this->$key instanceof \SwaggerValidator\Object\HeaderItem)) {
                continue;
            }

            $globalResponse[$key] = $this->$key->getModel($context->setDataPath($key));
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $globalResponse;
    }

}
