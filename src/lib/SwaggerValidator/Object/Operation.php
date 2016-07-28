<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\Object;

/**
 * Description of Operation
 *
 * @author Nabbar
 */
class Operation extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {
        parent::registerMandatoryKey('responses');
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

            if (substr($key, 0, strlen(\SwaggerValidator\Common\FactorySwagger::KEY_CUSTOM_PATTERN)) == \SwaggerValidator\Common\FactorySwagger::KEY_CUSTOM_PATTERN) {
                continue;
            }

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
        $check         = true;
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

    public function getModel(\SwaggerValidator\Common\Context $context, $paramsResponses = array())
    {
        $parameters = \SwaggerValidator\Common\FactorySwagger::KEY_PARAMETERS;
        $responses  = \SwaggerValidator\Common\FactorySwagger::KEY_RESPONSES;
        $consumes   = \SwaggerValidator\Common\FactorySwagger::KEY_CONSUMES;
        $produces   = \SwaggerValidator\Common\FactorySwagger::KEY_PRODUCES;

        if (!array_key_exists($parameters, $paramsResponses)) {
            $paramsResponses[$parameters] = array();
        }

        if (isset($this->$parameters) && is_object($this->$parameters) && ($this->$parameters instanceof \SwaggerValidator\Object\Parameters)) {
            $this->$parameters->getModel($context->setDataPath($parameters), $paramsResponses[$parameters]);
        }

        if (!array_key_exists($responses, $paramsResponses)) {
            $paramsResponses[$responses] = array();
        }

        if (isset($this->$responses) && is_object($this->$responses) && ($this->$responses instanceof \SwaggerValidator\Object\Responses)) {
            $this->$responses->getModel($context->setDataPath($responses), $paramsResponses[$responses]);
        }

        if (isset($this->$consumes) && is_array($this->$consumes)) {
            $paramsResponses[$consumes] = $this->$consumes;
        }

        if (isset($this->$produces) && is_array($this->$produces)) {
            $paramsResponses[$produces] = $this->$produces;
        }

        foreach (array_keys($paramsResponses) as $key) {
            if (empty($paramsResponses[$key])) {
                $paramsResponses[$key] = null;
            }
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $paramsResponses;
    }

}
