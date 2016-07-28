<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Security;

/**
 * Description of oauth2AccessCodeSecurity
 *
 * @author Nabbar
 */
class OAuth2AccessCodeSecurity extends \Swagger\Common\CollectionSwagger
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
        parent::registerMandatoryKey('flow');
        parent::registerMandatoryKey('authorizationUrl');
        parent::registerMandatoryKey('tokenUrl');
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
            $value      = $this->extractNonRecursiveReference($context, $value);
            $this->$key = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

}
