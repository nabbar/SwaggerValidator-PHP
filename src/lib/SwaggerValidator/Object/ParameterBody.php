<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\Object;

/**
 * Description of ParameterBody
 *
 * @author Nabbar
 */
class ParameterBody extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {
        parent::registerMandatoryKey('schema');
        $this->name = \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY;
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
