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

namespace SwaggerValidator\Common;

/**
 * Description of CollectionSwagger
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
abstract class CollectionSwagger extends \SwaggerValidator\Common\Collection
{

    /**
     *
     * @var array
     */
    private $mandatoryKeys = array();

    abstract public function __construct();

    /**
     * Return the content of the reference as object or mixed data
     * @param string $key
     * @return mixed
     * @throws \SwaggerValidator\Exception
     */
    public function get($key)
    {
        return $this->__get($key);
    }

    public function set($key, $value = null)
    {
        return $this->__set($key, $value);
    }

    /**
     * @param string $jsonData The Json Data to be unserialized
     */
    abstract public function jsonUnSerialize(\SwaggerValidator\Common\Context $context, $jsonData);

    protected function callException($message, $context = null)
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 11);
        array_shift($trace);

        $file = null;
        $line = null;

        for ($i = 0; $i < 10; $i++) {
            $oneTrace = array_shift($trace);

            if (!empty($oneTrace['file']) && $oneTrace['file'] != __FILE__) {
                $file = $oneTrace['file'];
                break;
            }
        }

        if (!empty($file) && !empty($oneTrace['line'])) {
            $line = $oneTrace['line'];
        }

        \SwaggerValidator\Common\Factory::getInstance()->call('Exception', 'throwNewException', true, $message, array('context' => $context, 'trace' => $trace), $file, $line);
    }

    protected function buildException($message, $context = null)
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 11);
        array_shift($trace);

        $file = null;
        $line = null;

        for ($i = 0; $i < 10; $i++) {
            $oneTrace = array_shift($trace);

            if (!empty($oneTrace['file']) && $oneTrace['file'] != __FILE__) {
                $file = $oneTrace['file'];
                break;
            }
        }

        if (!empty($file) && !empty($oneTrace['line'])) {
            $line = $oneTrace['line'];
        }

        \SwaggerValidator\Exception::throwNewException($message, array('context' => $context, 'trace' => $trace), $file, $line);
    }

    /**
     * List of keys mandatory for the current object type
     * @param string $key
     */
    protected function registerMandatoryKey($key)
    {
        if (in_array($key, $this->mandatoryKeys)) {
            $this->mandatoryKeys[] = $key;
        }
    }

    /**
     * Return true if all mandatory keys are defined or the missing key name
     * @return boolean|string
     */
    public function checkMandatoryKey()
    {
        foreach ($this->mandatoryKeys as $key) {
            if (!array_key_exists($key, $this)) {
                return $key;
            }
        }

        return true;
    }

    protected function getCleanClass($class)
    {
        $classPart = explode('\\', $class);
        return array_pop($classPart);
    }

    protected function extractNonRecursiveReference(\SwaggerValidator\Common\Context $context, &$jsonData)
    {
        if (!is_object($jsonData) || !property_exists($jsonData, \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE)) {
            return $jsonData;
        }

        if (count(get_object_vars($jsonData)) > 1) {
            \SwaggerValidator\Exception::throwNewException('External Object Reference cannot have more keys than the $ref key', array('context' => $context, 'JsonData' => $jsonData), __FILE__, __LINE__);
        }

        $key = \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE;
        $ref = $jsonData->$key;

        return \SwaggerValidator\Common\CollectionReference::getInstance()->get($ref)->getJson($context->setExternalRef($ref));
    }

    protected function registerRecursiveDefinitions(&$jsonData)
    {
        if (is_object($jsonData) && ($jsonData instanceof \stdClass)) {
            return $this->registerRecursiveDefinitionsFromObject($jsonData);
        }
        elseif (is_array($jsonData) && !empty($jsonData)) {
            return $this->registerRecursiveDefinitionsFromArray($jsonData);
        }
    }

    protected function registerRecursiveDefinitionsFromObject(\stdClass &$jsonData)
    {
        if (!is_object($jsonData) || !($jsonData instanceof \stdClass)) {
            return;
        }

        foreach (array_keys(get_object_vars($jsonData)) as $key) {
            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) {
                \SwaggerValidator\Common\CollectionReference::registerDefinition($jsonData->$key);
            }
            elseif (is_array($jsonData->$key)) {
                return $this->registerRecursiveDefinitionsFromArray($jsonData->$key);
            }
            elseif (is_object($jsonData->$key)) {
                return $this->registerRecursiveDefinitionsFromObject($jsonData->$key);
            }
        }
    }

    protected function registerRecursiveDefinitionsFromArray(&$jsonData)
    {
        if (!is_array($jsonData) || empty($jsonData)) {
            return;
        }

        foreach (array_keys($jsonData) as $key) {
            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) {
                \SwaggerValidator\Common\CollectionReference::registerDefinition($jsonData[$key]);
            }
            elseif (is_array($jsonData[$key])) {
                return $this->registerRecursiveDefinitionsFromArray($jsonData[$key]);
            }
            elseif (is_object($jsonData[$key])) {
                return $this->registerRecursiveDefinitionsFromObject($jsonData[$key]);
            }
        }
    }

    protected function getModelParameters(\SwaggerValidator\Common\Context $context, &$generalItems)
    {
        $parameters = \SwaggerValidator\Common\FactorySwagger::KEY_PARAMETERS;

        if (!is_array($generalItems)) {
            $generalItems = array();
        }

        if (!array_key_exists($parameters, $generalItems)) {
            $generalItems[$parameters] = array();
        }

        if (!isset($this->$parameters) || !is_object($this->$parameters)) {
            return;
        }

        if ($this->$parameters instanceof \SwaggerValidator\Object\Parameters) {
            $this->$parameters->getModel($context->setDataPath($parameters), $generalItems[$parameters]);
        }

        return;
    }

    protected function getModelResponse(\SwaggerValidator\Common\Context $context, &$generalItems)
    {
        $responses = \SwaggerValidator\Common\FactorySwagger::KEY_RESPONSES;

        if (!is_array($generalItems)) {
            $generalItems = array();
        }

        if (!array_key_exists($responses, $generalItems)) {
            $generalItems[$responses] = array();
        }

        if (!isset($this->$responses) || !is_object($this->$responses)) {
            return;
        }

        if ($this->$responses instanceof \SwaggerValidator\Object\Responses) {
            $this->$responses->getModel($context->setDataPath($responses), $generalItems[$responses]);
        }

        return;
    }

    protected function getModelConsumeProduce(\SwaggerValidator\Common\Context $context, &$generalItems)
    {
        $consumes = \SwaggerValidator\Common\FactorySwagger::KEY_CONSUMES;
        $produces = \SwaggerValidator\Common\FactorySwagger::KEY_PRODUCES;

        if (!is_array($generalItems)) {
            $generalItems = array();
        }

        if (!array_key_exists($consumes, $generalItems)) {
            $generalItems[$consumes] = array();
        }

        if (!array_key_exists($produces, $generalItems)) {
            $generalItems[$produces] = array();
        }

        if (isset($this->$consumes) && is_array($this->$consumes)) {
            $generalItems[$consumes] = $this->$consumes;
        }

        if (isset($this->$produces) && is_array($this->$produces)) {
            $generalItems[$produces] = $this->$produces;
        }

        return;
    }

    /**
     * Check that entry JsonData is an object of stdClass
     * @param \stdClass $jsonData
     * @return boolean
     */
    protected function checkJsonObject(\SwaggerValidator\Common\Context $context, &$jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        return true;
    }

    /**
     * Check that entry JsonData is an object of stdClass or an array
     * @param \stdClass $jsonData
     * @return boolean
     */
    protected function checkJsonObjectOrArray(\SwaggerValidator\Common\Context $context, &$jsonData)
    {
        if (is_object($jsonData) && !($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }
        elseif (!is_object($jsonData) && !is_array($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (is_array($jsonData)) {
            parent::setJSONIsArray();
        }

        return true;
    }

}
