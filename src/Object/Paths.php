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
 * Description of Paths
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Paths extends \SwaggerValidator\Common\CollectionSwagger
{

    public function __construct()
    {

    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData)
    {
        $this->checkJsonObject($context, $jsonData);

        foreach (get_object_vars($jsonData) as $key => $value) {

            $value      = $this->extractNonRecursiveReference($context, $value);
            $this->$key = \SwaggerValidator\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath($key), $this->getCleanClass(__CLASS__), $key, $value);
        }

        \SwaggerValidator\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        foreach ($this->keys() as $key) {
            if (is_object($this->$key) && ($this->$key instanceof \SwaggerValidator\Object\PathItem)) {
                continue;
            }

            if (is_object($this->$key) && method_exists($this->$key, 'validate')) {
                $this->$key->validate($context->setDataPath($key));
            }
        }

        $requestPath   = explode('/', $context->getRequestPath());
        $listFindRoute = array();

        foreach ($this->keys() as $key) {
            if (!is_object($this->$key) || !($this->$key instanceof \SwaggerValidator\Object\PathItem)) {
                continue;
            }

            if (substr($key, 0, 1) != '/') {
                continue;
            }

            $route = explode('/', $key);

            if (count($requestPath) != count($route)) {
                continue;
            }

            $findRoute = array(
                'base'   => $key,
                'params' => 0,
            );

            for ($i = 0; $i < count($route); $i++) {
                if (substr($route[$i], 0, 1) == '{' && substr($route[$i], -1, 1) == '}') {
                    $findRoute['params'] ++;
                    continue;
                }
                if ($route[$i] != $requestPath[$i]) {
                    $findRoute = null;
                    break;
                }
            }

            if ($findRoute !== null) {
                $listFindRoute[$findRoute['base']] = $findRoute['params'];
            }
        }

        $findRoute = null;
        $min       = null;

        foreach ($listFindRoute as $key => $value) {
            if ($findRoute === null || $value < $min) {
                $min       = $value;
                $findRoute = $key;
            }
        }

        if ($findRoute === null) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_ROUTE_ERROR, 'Route not found', __METHOD__, __LINE__);
        }

        $context->setRoutePath($findRoute);
        \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
        return $this->$findRoute->validate($context->setDataPath($findRoute));
    }

    public function getModel(\SwaggerValidator\Common\Context $context, $generalItems = array())
    {
        $result       = array();
        $generalItems = $this->getMethodGeneric($context, __FUNCTION__, $generalItems);

        foreach ($this->keys() as $key) {
            if (!is_object($this->$key) || !($this->$key instanceof \SwaggerValidator\Object\PathItem)) {
                continue;
            }

            if (substr($key, 0, 1) != '/') {
                continue;
            }

            $result[$key] = $this->$key->getModel($context->setDataPath($key), $generalItems);
        }

        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $result;
    }

}
