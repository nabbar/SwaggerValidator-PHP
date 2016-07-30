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
 * Description of Swagger
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Swagger extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {
        parent::registerMandatoryKey('swagger');
        parent::registerMandatoryKey('info');
        parent::registerMandatoryKey('paths');
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

            if ($key == \SwaggerValidator\Common\FactorySwagger::KEY_DEFINITIONS) {
                continue;
            }

            $value      = $this->extractNonRecursiveReference($context, $value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\CollectionReference::getInstance()->unserializeReferenceDefinitions($context);
        \SwaggerValidator\Common\CollectionReference::getInstance()->unserializeReferenceDefinitions($context);
        \SwaggerValidator\Common\CollectionReference::getInstance()->cleanReferenceDefinitions();
        \SwaggerValidator\Common\CollectionReference::getInstance()->jsonUnSerialize($context);

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function serialize()
    {
        return serialize(array(
            parent::serialize(),
            serialize(\SwaggerValidator\Common\CollectionReference::getInstance())
        ));
    }

    public function unserialize($data)
    {
        list($wagger, $reference) = unserialize($data);

        unserialize($reference);
        parent::unserialize($wagger);
    }

    public function jsonSerialize()
    {
        $keyDefinition = \SwaggerValidator\Common\FactorySwagger::KEY_DEFINITIONS;

        $doc                 = json_decode(\SwaggerValidator\Common\Collection::jsonEncode(parent::jsonSerialize()));
        $doc->$keyDefinition = json_decode(\SwaggerValidator\Common\Collection::jsonEncode(\SwaggerValidator\Common\CollectionReference::getInstance()));

        if (count(get_object_vars($doc->$keyDefinition)) < 2) {
            unset($doc->$keyDefinition);
        }

        return $doc;
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        \SwaggerValidator\Common\Context::cleanCheckedDataName();

        $this->checkSwaggerVersion($context->setDataPath('swagger')->setDataValue($this->swagger));
        $this->checkSchemes($context->setDataPath('schemes')->setDataValue($context->getBasePath()));
        $this->checkHost($context->setDataPath('host')->setDataValue($context->getHost()));

        $ctxPath = $this->checkBasePath($context->setDataPath('basePath')->setDataValue($context->getBasePath()));

        $context->setBasePath($ctxPath->getBasePath());
        $context->setRequestPath($ctxPath->getRequestPath());

        if ($context->getType() === \SwaggerValidator\Common\Context::TYPE_REQUEST) {
            $this->checkConsume($context->setDataPath('consumes')->setDataValue(null));
        }
        elseif ($context->getType() === \SwaggerValidator\Common\Context::TYPE_RESPONSE) {
            $this->checkProduce($context->setDataPath('produces')->setDataValue(null));
        }

        $keyPath = \SwaggerValidator\Common\FactorySwagger::KEY_PATHS;

        \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        $result = $this->$keyPath->validate($context->setDataPath($keyPath));

        if (!$result) {
            return false;
        }

        if ($context->getMode() === \SwaggerValidator\Common\Context::MODE_PASS) {
            $context->cleanParams();
            \SwaggerValidator\Common\Context::logValidate($context->setDataPath('CheckTooMany')->getDataPath(), get_class($this), __METHOD__, __LINE__);
            return true;
        }

        foreach (\SwaggerValidator\Common\Context::getCheckedDataName() as $location => $list) {

            if ($location == \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY && $list !== true) {
                $ctx = $context->setLocation($location)->setDataPath($location)->setDataCheck('exist');
                $ctx->loadRequestBody();

                if ($ctx->isDataExists()) {
                    $ctx->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_TOOMANY, 'Body is given and not expected', __METHOD__, __LINE__);
                }
            }
            else {
                $ctx = $context->setLocation($location)->setDataCheck('exist');
                $mtd = \SwaggerValidator\Common\Context::getCheckedMethodFormLocation($context->getType(), $location);

                if (empty($mtd)) {
                    continue;
                }

                foreach ($ctx->$mtd() as $paramName) {

                    if (in_array($paramName, $list)) {
                        continue;
                    }

                    $ctx->setDataPath($paramName)->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_TOOMANY, $paramName . ' is given and not expected', __METHOD__, __LINE__);
                }
            }
        }

        \SwaggerValidator\Common\Context::logValidate($context->setDataPath('CheckTooMany')->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function checkSwaggerVersion(\SwaggerValidator\Common\Context $context)
    {
        if ($context->getDataValue() != '2.0') {
            return $context->setValidationError(\SwaggerValidator\CustomIOHelper::VALIDATION_TYPE_SWAGGER_ERROR, 'Bad swagger version', __METHOD__, __LINE__);
        }

        return true;
    }

    protected function checkSchemes(\SwaggerValidator\Common\Context $context)
    {
        if (!isset($this->schemes)) {
            return true;
        }

        foreach ($this->schemes as $oneScheme) {
            if (strtolower($context->getDataValue()) && strtolower($oneScheme)) {
                return true;
            }
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Scheme requested is not allowed', __METHOD__, __LINE__);
    }

    protected function checkHost(\SwaggerValidator\Common\Context $context)
    {
        if (!isset($this->host)) {
            return true;
        }

        if ($context->getDataValue() === null) {
            return true;
        }

        if (strtolower($context->getDataValue()) && strtolower($this->host)) {
            return true;
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, 'HostName requested is not allowed', __METHOD__, __LINE__);
    }

    protected function checkBasePath(\SwaggerValidator\Common\Context $context)
    {
        if (!isset($this->basePath)) {
            return true;
        }

        if (substr($context->getDataValue(), 0, strlen($this->basePath)) != $this->basePath) {
            return $context->setValidationError(\SwaggerValidator\CustomIOHelper::VALIDATION_TYPE_DATAVALUE, 'BasePath requested is not allowed', __METHOD__, __LINE__);
        }

        $context->setBasePath($this->basePath);
        $context->setRequestPath(substr($context->getDataValue(), strlen($this->basePath)));

        return $context;
    }

    protected function checkConsume(\SwaggerValidator\Common\Context $context)
    {
        if (!isset($this->consume)) {
            return true;
        }

        $headers       = apache_request_headers();
        $contentType   = null;
        $contentLength = null;

        if (array_key_exists('Content-Type', $headers)) {
            $contentType = explode(';', $headers['Content-Type']);
            $contentType = str_replace(array('application/', 'text/', 'x-'), '', array_shift($contentType));
        }

        if (empty($contentType)) {
            return true;
        }

        foreach ($this->consume as $oneContentType) {
            if (strtolower($context->getDataValue()) && strtolower($oneContentType)) {
                return true;
            }
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Content-Type requested is not allowed', __METHOD__, __LINE__);
    }

    protected function checkProduce(\SwaggerValidator\Common\Context $context)
    {
        if (!isset($this->produces)) {
            return true;
        }

        $headers       = apache_response_headers();
        $contentType   = null;
        $contentLength = null;

        if (array_key_exists('Content-Type', $headers)) {
            $contentType = explode(';', $headers['Content-Type']);
            $contentType = str_replace(array('application/', 'text/', 'x-'), '', array_shift($contentType));
        }

        if (empty($contentType)) {
            return true;
        }

        foreach ($this->produces as $oneContentType) {
            if (strtolower($context->getDataValue()) && strtolower($oneContentType)) {
                return true;
            }
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, 'Content-Type responded is not allowed', __METHOD__, __LINE__);
    }

    public function getApiVersion()
    {
        return $this->info->getApiVersion();
    }

    public function getApiVersionMajor()
    {
        $version = explode('.', $this->getApiVersion(), 4);

        return $version[0];
    }

    public function getApiVersionMinor()
    {
        $version = explode('.', $this->getApiVersion(), 4);

        return $version[1];
    }

    public function getApiVersionBuild()
    {
        $version = explode('.', $this->getApiVersion(), 4);

        return $version[2];
    }

    public function getApiVersionPatch()
    {
        $version = explode('.', $this->getApiVersion(), 4);

        return $version[3];
    }

    public function getModel(\SwaggerValidator\Common\Context $context)
    {
        $parameters   = \SwaggerValidator\Common\FactorySwagger::KEY_PARAMETERS;
        $responses    = \SwaggerValidator\Common\FactorySwagger::KEY_RESPONSES;
        $consumes     = \SwaggerValidator\Common\FactorySwagger::KEY_CONSUMES;
        $produces     = \SwaggerValidator\Common\FactorySwagger::KEY_PRODUCES;
        $paths        = \SwaggerValidator\Common\FactorySwagger::KEY_PATHS;
        $generalItems = array(
            $parameters => array(),
            $responses  => array(),
        );

        if (isset($this->$parameters) && is_object($this->$parameters) && ($this->$parameters instanceof \SwaggerValidator\Object\Parameters)) {
            $this->$parameters->getModel($context->setDataPath($parameters), $generalItems[$parameters]);
        }

        if (isset($this->$responses) && is_object($this->$responses) && ($this->$responses instanceof \SwaggerValidator\Object\Responses)) {
            $this->$responses->getModel($context->setDataPath($responses), $generalItems[$responses]);
        }

        if (isset($this->$consumes) && is_array($this->$consumes)) {
            $paramsResponses[$consumes] = $this->$consumes;
        }

        if (isset($this->$produces) && is_array($this->$produces)) {
            $paramsResponses[$produces] = $this->$produces;
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $this->$paths->getModel($context->setDataPath($paths), $generalItems);
    }

}
