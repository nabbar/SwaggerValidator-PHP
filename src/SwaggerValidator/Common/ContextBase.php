<?php

/*
 * Copyright 2016 Nicolas JUHEL<swaggervalidator@nabbar.com>.
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
 * Description of ContextAbstract
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 */
class ContextBase implements \SwaggerValidator\Interfaces\ContextBase
{

    /**
     *
     * @var string
     */
    protected $contextMode;

    /**
     *
     * @var string
     */
    protected $contextType;

    /**
     *
     * @var string
     */
    protected $contextLocation;

    /**
     *
     * @var string
     */
    protected $contextScheme;

    /**
     *
     * @var string
     */
    protected $contextHost;

    /**
     *
     * @var string
     */
    protected $contextBasePath;

    /**
     *
     * @var string
     */
    protected $contextRequestPath;

    /**
     *
     * @var string
     */
    protected $contextRoutePath;

    /**
     *
     * @var string
     */
    protected $contextMethod;

    /**
     *
     * @var array
     */
    protected $contextDataPath;

    /**
     *
     * @var array
     */
    protected $contextDataCheck;

    /**
     *
     * @var mixed
     */
    protected $contextDataValue;

    /**
     *
     * @var boolean
     */
    protected $contextDataValueExists;

    /**
     *
     * @var boolean
     */
    protected $contextDataValueEmpty;

    /**
     *
     * @var array
     */
    protected $contextDataDecodeError;

    /**
     *
     * @var string
     */
    protected $contextDataType;

    /**
     *
     * @var array
     */
    protected $contextOther;

    /**
     *
     * @var array
     */
    protected $contextExternalRef;

    /**
     *
     * @var boolean
     */
    protected $contextIsCombined;

    /**
     *
     * @var array
     */
    protected static $contextValidatedParams = array();

    /**
     *
     * @var array
     */
    protected $mockedData = array();

    /**
     *
     * @param string|null $mode
     * @param string|null $type
     */
    public function __construct($mode = null, $type = null)
    {
        if (!is_array($this->contextDataCheck)) {
            $this->contextDataCheck = array();
        }

        if (!is_array($this->contextDataValue)) {
            $this->contextDataValue = array();
        }

        if (!is_array($this->contextDataPath)) {
            $this->contextDataPath = array();
        }

        if (!is_array($this->contextExternalRef)) {
            $this->contextExternalRef = array();
        }

        if (!is_array($this->contextOther)) {
            $this->contextOther = array();
        }

        if (empty($this->contextDataPath)) {
            $this->contextDataPath[] = '#';
        }

        if (!empty($mode)) {
            $this->setMode($mode);
        }

        if (!empty($type)) {
            $this->setType($type);
        }
    }

    private function formatVarName($name)
    {
        if (substr($name, 0, 7) == 'context') {
            return $name;
        }

        return 'context' . strtoupper(substr($name, 0, 1)) . substr($name, 1);
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->mockedData)) {
            return $this->mockedData[$name];
        }

        if ($this->__isset($name) && $name !== 'mockedData') {
            $property = $this->formatVarName($name);
            return $this->$property;
        }
    }

    public function __set($name, $value)
    {
        if ($this->__isset($name) && $name !== 'mockedData') {
            $method_name = 'set' . substr($this->formatVarName($name), 7);

            if (method_exists($this, $method_name)) {
                $this->$method_name($value);
            }
            else {
                throw new Exception('Cannot find this Method : ' . $method_name);
            }
        }
    }

    public function __isset($name)
    {
        $property = $this->formatVarName($name);
        return $name !== 'mockedData' && property_exists(get_class($this), $property);
    }

    public function __unset($name)
    {
        if (!$this->__isset($name) && $name !== 'mockedData') {
            return;
        }

        $property = $this->formatVarName($name);
        $exclude  = array(
            'contextMode',
            'contextType',
        );

        if (in_array($property, $exclude)) {
            return;
        }

        $this->$property = null;
    }

    public function __toString()
    {
        return \SwaggerValidator\Common\Collection::jsonEncode($this->__debugInfo());
    }

    public function __debugInfo()
    {
        $properties = get_object_vars($this);

        foreach (array_keys($properties) as $key) {
            if (substr($key, 0, 7) != 'context' && $key != 'mockedData') {
                unset($properties[$key]);
            }
        }

        return $properties;
    }

    public function setMode($value = null)
    {
        switch ($value) {
            case \SwaggerValidator\Common\Context::MODE_DENY:
            case \SwaggerValidator\Common\Context::MODE_PASS:
                $this->contextMode = $value;
                break;

            default:
                $this->contextMode = \SwaggerValidator\Common\Context::MODE_DENY;
                break;
        }
        return $this;
    }

    public function getMode()
    {
        return $this->__get('Mode');
    }

    /**
     *
     * @param const $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setType($value = null)
    {
        switch ($value) {
            case \SwaggerValidator\Common\Context::TYPE_RESPONSE:
            case \SwaggerValidator\Common\Context::TYPE_REQUEST:
                $this->contextType = $value;
                break;

            default:
                $this->contextType = \SwaggerValidator\Common\Context::TYPE_REQUEST;
                break;
        }

        return $this;
    }

    public function getType()
    {
        return $this->__get('Type');
    }

    /**
     *
     * @param const $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setLocation($value = null)
    {
        switch (strtolower($value)) {
            case \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY:
            case 'body':
                $this->contextLocation = \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY;
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM:
            case 'formdata':
                $this->contextLocation = \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM;
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER:
            case 'header':
                $this->contextLocation = \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER;
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH:
            case 'path':
                $this->contextLocation = \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH;
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY:
            case 'query':
                $this->contextLocation = \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY;
                break;

            default:
                $this->contextLocation = \SwaggerValidator\Common\Context::LOCATION_BODY;
                break;
        }

        return $this;
    }

    public function getLocation()
    {
        return $this->__get('Location');
    }

    /**
     *
     * @param const $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setMethod($value = null)
    {
        switch (strtolower($value)) {
            case \SwaggerValidator\Common\Context::METHOD_DELETE:
            case \SwaggerValidator\Common\Context::METHOD_GET:
            case \SwaggerValidator\Common\Context::METHOD_HEAD:
            case \SwaggerValidator\Common\Context::METHOD_OPTIONS:
            case \SwaggerValidator\Common\Context::METHOD_PATCH:
            case \SwaggerValidator\Common\Context::METHOD_POST:
            case \SwaggerValidator\Common\Context::METHOD_PUT:
                $this->contextMethod = $value;
                break;

            default:
                $this->contextMethod = \SwaggerValidator\Common\Context::METHOD_GET;
                break;
        }

        return $this;
    }

    public function getMethod()
    {
        return $this->__get('Method');
    }

    public function loadMethod()
    {
        return $this->setMethod($this->getEnv('REQUEST_METHOD'));
    }

    /**
     *
     * @param string $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setBasePath($value = null)
    {
        $this->contextBasePath = $value;
        return $this;
    }

    public function getBasePath()
    {
        return $this->__get('BasePath');
    }

    /**
     *
     * @param string $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setRoutePath($value = null)
    {
        $this->contextRoutePath = $value;
        return $this;
    }

    public function getRoutePath()
    {
        return $this->__get('RoutePath');
    }

    /**
     *
     * @param string $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setRequestPath($value = null)
    {
        $this->contextRequestPath = $value;
        return $this;
    }

    public function getRequestPath()
    {
        return $this->__get('RequestPath');
    }

    /**
     *
     * @param string $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setScheme($value = null)
    {
        $this->contextScheme = $value;
        return $this;
    }

    public function getScheme()
    {
        return $this->__get('Scheme');
    }

    /**
     *
     * @param string $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setHost($value = null)
    {
        $this->contextHost = $value;
        return $this;
    }

    public function getHost()
    {
        return $this->__get('Host');
    }

    /**
     *
     * @param string $key
     * @param \SwaggerValidator\Common\Context $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function addContext($key = null, $value = null)
    {
        $this->contextOther[$key] = $value;
        return $this;
    }

    public function getContext()
    {
        return $this->__get('Other');
    }

    /**
     *
     * @param boolean $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setCombined($value = false)
    {
        $this->contextIsCombined = (bool) $value;
        return $this;
    }

    public function getCombined()
    {
        return $this->__get('IsCombined');
    }

    /**
     *
     * @param string $value
     * @return \SwaggerValidator\Common\Context
     */
    public function setDataPath($value = null)
    {
        $new = clone $this;

        $new->contextDataPath[] = $value;

        return $new;
    }

    public function getDataPath()
    {
        return implode('/', $this->__get('DataPath'));
    }

    public function getLastDataPath()
    {
        $ref = $this->__get('DataPath');
        return array_pop($ref);
    }

    /**
     *
     * @param string $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setExternalRef($value = null)
    {
        $new = clone $this;

        if (!empty($value)) {
            $new->contextExternalRef[] = $value;
        }

        return $new;
    }

    public function getExternalRef()
    {
        return implode(',', $this->__get('ExternalRef'));
    }

    public function getLastExternalRef()
    {
        $ref = $this->__get('ExternalRef');
        return array_pop($ref);
    }

    public function checkExternalRef($value = NULL)
    {
        if (!empty($value)) {
            return in_array($value, $this->__get('ExternalRef'));
        }

        return false;
    }

    /**
     *
     * @param string $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setDataCheck($value = null)
    {
        $this->contextDataCheck[] = $value;
        return $this;
    }

    public function getDataCheck()
    {
        return implode('/', $this->__get('DataCheck'));
    }

    /**
     *
     * @param mixed $value
     * @param null|boolean $isExisting
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setDataValue($value = null, $isExisting = true)
    {
        if ($isExisting === true) {
            $this->contextDataValueExists = true;
        }
        elseif ($isExisting === false) {
            $this->contextDataValueExists = true;
        }
        elseif ($isExisting === null) {
            $this->contextDataValueExists = (bool) (!empty($value));
        }

        $this->contextDataValue = $value;
        $this->checkDataIsEmpty();

        return $this;
    }

    /**
     *
     * @param boolean $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setDataValueExists($value = null)
    {
        $this->contextDataValueExists = $value;
        return $this;
    }

    /**
     *
     * @param Boolean $value
     * @return \SwaggerValidator\Common\ContextBase
     */
    public function setDataValueEmpty($value = null)
    {
        $this->contextDataValueEmpty = $value;
        return $this;
    }

    public function getDataValue()
    {
        return $this->__get('DataValue');
    }

    public function isDataExists()
    {
        return $this->__get('DataValueExists');
    }

    public function isDataEmpty()
    {
        return $this->__get('DataValueEmpty');
    }

}
