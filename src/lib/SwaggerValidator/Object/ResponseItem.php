<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Object;

/**
 * Description of ResponseItem
 *
 * @author Nabbar
 */
class ResponseItem extends \Swagger\Common\CollectionSwagger
{

    public function __construct()
    {
        parent::registerMandatoryKey('description');
    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        $schemaKey = \Swagger\Common\FactorySwagger::KEY_SCHEMA;
        if (property_exists($jsonData, $schemaKey)) {
            $jsonData->$schemaKey = $this->extractNonRecursiveReference($context, $jsonData->$schemaKey);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {

            if (substr($key, 0, strlen(\Swagger\Common\FactorySwagger::KEY_CUSTOM_PATTERN)) == \Swagger\Common\FactorySwagger::KEY_CUSTOM_PATTERN) {
                continue;
            }

            $value = $this->extractNonRecursiveReference($context, $value);

            $schemaKey = \Swagger\Common\FactorySwagger::KEY_SCHEMA;
            if (is_object($value) && property_exists($value, $schemaKey)) {
                $value->$schemaKey = $this->extractNonRecursiveReference($context->setDataPath($key), $value->$schemaKey);
            }

            $this->$key = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\Swagger\Common\Context $context)
    {
        $check = true;

        $keyHeaders = \Swagger\Common\FactorySwagger::KEY_HEADERS;

        if ($this->has($keyHeaders) && is_object($this->$keyHeaders) && $this->$keyHeaders instanceof \Swagger\Object\Headers) {
            $check = $check && $this->$keyHeaders->validate($context->setDataPath($keyHeaders)->setLocation(\Swagger\Common\FactorySwagger::LOCATION_HEADER));
        }

        $keySchema = \Swagger\Common\FactorySwagger::KEY_SCHEMA;

        if ($this->has($keySchema) && is_object($this->$keySchema) && $this->$keySchema instanceof \Swagger\Common\CollectionSwagger) {
            $ctx   = $context->setDataPath(\Swagger\Common\FactorySwagger::LOCATION_BODY)->setLocation(\Swagger\Common\FactorySwagger::LOCATION_BODY);
            $ctx->dataLoad();
            \Swagger\Common\Context::addCheckedDataName(\Swagger\Common\FactorySwagger::LOCATION_BODY, null);
            $check = $check && $this->$keySchema->validate($ctx);
        }

        return $check;
    }

    public function getModel(\Swagger\Common\Context $context, $globalResponse = array())
    {
        $headersKey = \Swagger\Common\FactorySwagger::KEY_HEADERS;
        $schemaKey  = \Swagger\Common\FactorySwagger::KEY_SCHEMA;
        $headers    = array();
        $schema     = null;

        if (!array_key_exists($headersKey, $globalResponse)) {
            $globalResponse[$headersKey] = array();
        }

        if (!array_key_exists($schemaKey, $globalResponse)) {
            $globalResponse[$schemaKey] = null;
        }

        if (isset($this->$headersKey) && is_object($this->$headersKey) && ($this->$headersKey instanceof \Swagger\Object\HeaderItem)) {
            $globalResponse[$headersKey] = $this->$headersKey->getModel($context->setDataPath($headersKey), $globalResponse[$headersKey]);
        }

        if (isset($this->$schemaKey) && is_object($this->$schemaKey) && method_exists($this->$schemaKey, 'getModel')) {
            $globalResponse[$schemaKey] = $this->$schemaKey->getModel($context->setDataPath($schemaKey)->setType(\Swagger\Common\Context::TYPE_RESPONSE));
        }

        if (empty($globalResponse[$headersKey])) {
            unset($globalResponse[$headersKey]);
        }

        if (empty($globalResponse[$schemaKey])) {
            unset($globalResponse[$schemaKey]);
        }

        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $globalResponse;
    }

}
