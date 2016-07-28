<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Object;

/**
 * Description of PathItem
 *
 * @author Nabbar
 */
class PathItem extends \Swagger\Common\CollectionSwagger
{

    public function __construct()
    {

    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {

            if (substr($key, 0, strlen(\Swagger\Common\FactorySwagger::KEY_CUSTOM_PATTERN)) == \Swagger\Common\FactorySwagger::KEY_CUSTOM_PATTERN) {
                continue;
            }

            $value      = $this->extractNonRecursiveReference($context, $value);
            $this->$key = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\Swagger\Common\Context $context)
    {
        foreach ($this->keys() as $key) {
            if (is_object($this->$key) && ($this->$key instanceof \Swagger\Object\Operation)) {
                continue;
            }

            if (is_object($this->$key) && method_exists($this->$key, 'validate')) {
                $this->$key->validate($context->setDataPath($key));
            }
        }

        $currentMethod = $context->getMethod();

        if (isset($this->$currentMethod) && is_object($this->$currentMethod) && ($this->$key instanceof \Swagger\Object\Operation)) {
            \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
            return $this->$currentMethod->validate($context->setDataPath($currentMethod));
        }

        return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_METHOD_ERROR, 'Method not found to this route', __METHOD__, __LINE__);
    }

    public function getModel(\Swagger\Common\Context $context, $paramsResponses = array())
    {
        $parameters = \Swagger\Common\FactorySwagger::KEY_PARAMETERS;
        $responses  = \Swagger\Common\FactorySwagger::KEY_RESPONSES;
        $consumes   = \Swagger\Common\FactorySwagger::KEY_CONSUMES;
        $produces   = \Swagger\Common\FactorySwagger::KEY_PRODUCES;
        $result     = array();

        if (!array_key_exists($parameters, $paramsResponses)) {
            $paramsResponses[$parameters] = array();
        }

        if (isset($this->$parameters) && is_object($this->$parameters) && ($this->$parameters instanceof \Swagger\Object\Parameters)) {
            $this->$parameters->getModel($context->setDataPath($parameters), $paramsResponses[$parameters]);
        }

        if (!array_key_exists($responses, $paramsResponses)) {
            $paramsResponses[$responses] = array();
        }

        if (isset($this->$responses) && is_object($this->$responses) && ($this->$responses instanceof \Swagger\Object\Responses)) {
            $this->$responses->getModel($context->setDataPath($responses), $paramsResponses[$responses]);
        }

        if (isset($this->$consumes) && is_array($this->$consumes)) {
            $paramsResponses[$consumes] = $this->$consumes;
        }

        if (isset($this->$produces) && is_array($this->$produces)) {
            $paramsResponses[$produces] = $this->$produces;
        }

        foreach ($this->keys() as $key) {
            if (!is_object($this->$key) || !($this->$key instanceof \Swagger\Object\Operation)) {
                continue;
            }

            $result[$key] = $this->$key->getModel($context->setDataPath($key), $paramsResponses);
        }

        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $result;
    }

}
