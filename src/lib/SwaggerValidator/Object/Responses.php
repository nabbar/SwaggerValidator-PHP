<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\Object;

/**
 * Description of Responses
 *
 * @author Nabbar
 */
class Responses extends \SwaggerValidator\Common\CollectionSwagger
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

            if (substr($key, 0, strlen(\SwaggerValidator\Common\FactorySwagger::KEY_CUSTOM_PATTERN)) == \SwaggerValidator\Common\FactorySwagger::KEY_CUSTOM_PATTERN) {
                continue;
            }

            if (!preg_match('/^([0-9]{3})$|^(' . \SwaggerValidator\Common\FactorySwagger::KEY_DEFAULT . ')$/', $key)) {
                $this->buildException('Invalid Key "' . $key . '" for a response item', array('context' => $context, 'JSON Data' => $jsonData));
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
