<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\Common;

/**
 * Description of SwaggerCommonContext
 *
 * @author Nabbar
 */
class Context
{
    /*
     * Mode Constants
     */

    const MODE_PASS                      = 'PASS';
    const MODE_DENY                      = 'DENY';
    /*
     * Type Constants
     */
    const TYPE_REQUEST                   = 'REQUEST';
    const TYPE_RESPONSE                  = 'RESPONSE';
    /*
     * Methods Constants
     */
    const METHOD_GET                     = 'get';
    const METHOD_POST                    = 'post';
    const METHOD_PUT                     = 'put';
    const METHOD_PATCH                   = 'patch';
    const METHOD_DELETE                  = 'delete';
    const METHOD_HEAD                    = 'head';
    const METHOD_OPTIONS                 = 'options';
    /*
     * Content Type Constants
     */
    const CONTENT_TYPE_JSON              = 'json';
    const CONTENT_TYPE_XML               = 'xml';
    const CONTENT_TYPE_OTHER             = 'other';
    /*
     * Calidation Error Constants
     */
    const VALIDATION_TYPE_BASEPATH_ERROR = 'BASEPATH';
    const VALIDATION_TYPE_DATASIZE       = 'DATASIZE';
    const VALIDATION_TYPE_DATATYPE       = 'DATATYPE';
    const VALIDATION_TYPE_DATAVALUE      = 'DATAVALUE';
    const VALIDATION_TYPE_METHOD_ERROR   = 'METHOD';
    const VALIDATION_TYPE_NOTFOUND       = 'NOTFOUND';
    const VALIDATION_TYPE_PATTERN        = 'PATTERN';
    const VALIDATION_TYPE_RESPONSE_ERROR = 'RESPONSE';
    const VALIDATION_TYPE_ROUTE_ERROR    = 'ROUTE';
    const VALIDATION_TYPE_SWAGGER_ERROR  = 'SWAGGER';
    const VALIDATION_TYPE_TOOMANY        = 'TOOMANY';

    /**
     * @var array
     */
    private static $config = array(
        'mode' => array(
            self::TYPE_REQUEST  => self::MODE_DENY,
            self::TYPE_RESPONSE => self::MODE_PASS,
        ),
        'log'  => array(
            'loadFile'   => true,
            'loadRef'    => true,
            'replaceRef' => true,
            'decode'     => true,
            'validate'   => true,
            'model'      => true,
        ),
    );

    /**
     *
     * @var string
     */
    private $contextMode;

    /**
     *
     * @var string
     */
    private $contextType;

    /**
     *
     * @var string
     */
    private $contextLocation;

    /**
     *
     * @var string
     */
    private $contextScheme;

    /**
     *
     * @var string
     */
    private $contextHost;

    /**
     *
     * @var string
     */
    private $contextBasePath;

    /**
     *
     * @var string
     */
    private $contextRequestPath;

    /**
     *
     * @var string
     */
    private $contextRoutePath;

    /**
     *
     * @var string
     */
    private $contextMethod;

    /**
     *
     * @var array
     */
    private $contextDataPath;

    /**
     *
     * @var array
     */
    private $contextDataCheck;

    /**
     *
     * @var mixed
     */
    private $contextDataValue;

    /**
     *
     * @var boolean
     */
    private $contextDataValueExists;

    /**
     *
     * @var boolean
     */
    private $contextDataValueEmpty;

    /**
     *
     * @var array
     */
    private $contextDataDecodeError;

    /**
     *
     * @var string
     */
    private $contextDataType;

    /**
     *
     * @var array
     */
    private $contextOther;

    /**
     *
     * @var array
     */
    private $contextExternalRef;

    /**
     *
     * @var boolean
     */
    private $contextIsCombined;

    /**
     *
     * @var array
     */
    private static $contextValidatedParams = array();

    /**
     *
     * @var array
     */
    private $mockedData = array();

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

    public static function setConfig($optionGroup, $optionName, $value)
    {
        if (!array_key_exists($optionGroup, self::$config) || !is_array(self::$config[$optionGroup])) {
            return;
        }

        if (!array_key_exists($optionName, self::$config[$optionGroup])) {
            return;
        }

        self::$config[$optionGroup][$optionName] = $value;
    }

    protected static function getConfig($optionGroup, $optionName)
    {
        if (!array_key_exists($optionGroup, self::$config) || !is_array(self::$config[$optionGroup])) {
            return;
        }

        if (!array_key_exists($optionName, self::$config[$optionGroup])) {
            return;
        }

        return self::$config[$optionGroup][$optionName];
    }

    private function formatVarName($name)
    {
        if (substr($name, 0, 7) == 'context') {
            return $name;
        }

        return $property = 'context' . strtoupper(substr($name, 0, 1)) . substr($name, 1);
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
                $this->$method($value);
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

        foreach ($properties as $key => $value) {
            if (substr($key, 0, 7) != 'context' && $key != 'mockedData') {
                unset($properties[$key]);
            }
        }

        return $properties;
    }

    public function setMode($value = null)
    {
        switch ($value) {
            case self::MODE_DENY:
            case self::MODE_PASS:
                $this->contextMode = $value;
                break;

            default:
                $this->contextMode = self::MODE_DENY;
                break;
        }
        return $this;
    }

    public function getMode()
    {
        return $this->__get('Mode');
    }

    public function setType($value = null)
    {
        switch ($value) {
            case self::TYPE_RESPONSE:
            case self::TYPE_REQUEST:
                $this->contextType = $value;
                break;

            default:
                $this->contextType = self::TYPE_REQUEST;
                break;
        }
        return $this;
    }

    public function getType()
    {
        return $this->__get('Type');
    }

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
                $this->contextLocation = self::LOCATION_BODY;
                break;
        }
        return $this;
    }

    public function getLocation()
    {
        return $this->__get('Location');
    }

    public function setMethod($value = null)
    {
        switch (strtolower($value)) {
            case self::METHOD_DELETE:
            case self::METHOD_GET:
            case self::METHOD_HEAD:
            case self::METHOD_OPTIONS:
            case self::METHOD_PATCH:
            case self::METHOD_POST:
            case self::METHOD_PUT:
                $this->contextMethod = $value;
                break;

            default:
                $this->contextMethod = self::METHOD_GET;
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

    public function setBasePath($value = null)
    {
        $this->contextBasePath = $value;
        return $this;
    }

    public function getBasePath()
    {
        return $this->__get('BasePath');
    }

    public function setRoutePath($value = null)
    {
        $this->contextRoutePath = $value;
        return $this;
    }

    public function getRoutePath()
    {
        return $this->__get('RoutePath');
    }

    public function setRequestPath($value = null)
    {
        $this->contextRequestPath = $value;
        return $this;
    }

    public function getRequestPath()
    {
        return $this->__get('RequestPath');
    }

    public function setScheme($value = null)
    {
        $this->contextScheme = $value;
        return $this;
    }

    public function getScheme()
    {
        return $this->__get('Scheme');
    }

    public function setHost($value = null)
    {
        $this->contextHost = $value;
        return $this;
    }

    public function getHost()
    {
        return $this->__get('Host');
    }

    public function loadUri()
    {
        $this->contextScheme = $this->getEnv('REQUEST_SCHEME');
        $this->contextHost   = $this->getEnv('SERVER_NAME');

        $uri = explode('?', $this->getEnv('REQUEST_URI'));

        $this->contextBasePath = array_shift($uri);
    }

    public function addContext($key = null, $value = null)
    {
        $this->contextOther[$key] = $value;
        return $this;
    }

    public function getContext()
    {
        return $this->__get('Other');
    }

    public function setCombined($value = false)
    {
        $this->contextIsCombined = boolval($value);
        return $this;
    }

    public function getCombined()
    {
        return $this->__get('IsCombined');
    }

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

    public function setDataCheck($value = null)
    {
        $this->contextDataCheck[] = $value;
        return $this;
    }

    public function getDataCheck()
    {
        return implode('/', $this->__get('DataCheck'));
    }

    public function setDataValue($value = null)
    {
        $this->contextDataValueExists = true;
        $this->contextDataValue       = $value;
        $this->checkDataIsEmpty();

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

    public function checkDataIsEmpty()
    {
        if ($this->__get('DataValueExists') === false) {
            $this->contextDataValueEmpty = true;
        }
        elseif (is_object($this->__get('DataValue'))) {
            $this->contextDataValueEmpty = false;
        }
        elseif (is_array($this->__get('DataValue'))) {
            $this->contextDataValueEmpty = false;
        }
        elseif (is_string($this->__get('DataValue'))) {
            $this->contextDataValueEmpty = (bool) (strlen($this->__get('DataValue')) == 0);
        }
        elseif (is_numeric($this->__get('DataValue'))) {
            $this->contextDataValueEmpty = false;
        }
        else {
            $this->contextDataValueEmpty = (bool) $this->checkIsEmpty($this->__get('DataValue'));
        }
    }

    public function getResponseStatus()
    {
        if (array_key_exists('http_response_code', $this->mockedData)) {
            return $this->mockedData['http_response_code'];
        }

        if (function_exists('http_response_code')) {
            return http_response_code();
        }

        return;
    }

    public function dataLoad()
    {
        $method    = $this->__get('Method');
        $location  = $this->__get('Location');
        $paramName = $this->__get('DataPath');
        $paramName = array_pop($paramName);

        $this->contextDataValueExists = false;
        $this->contextDataValue       = null;

        if ($paramName === \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY && $this->__get('Type') === self::TYPE_REQUEST) {
            return $this->loadRequestBody();
        }
        elseif ($paramName === \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY && $this->__get('Type') === self::TYPE_RESPONSE) {
            return $this->loadResponseBody();
        }
        elseif ($this->__get('Type') === self::TYPE_REQUEST && $this->__get('Location') === \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER) {
            return $this->loadRequestHeader($paramName);
        }
        elseif ($this->__get('Type') === self::TYPE_RESPONSE && $this->__get('Location') === \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER) {
            return $this->loadResponseHeader($paramName);
        }
        elseif ($this->__get('Type') === self::TYPE_REQUEST && $this->__get('Location') === \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM) {
            return $this->loadRequestFormData($paramName);
        }
        elseif ($this->__get('Type') === self::TYPE_REQUEST && $this->__get('Location') === \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH) {
            return $this->loadRequestPath($paramName);
        }
        elseif ($this->__get('Type') === self::TYPE_REQUEST && $this->__get('Location') === \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY) {
            return $this->loadRequestQuery($paramName);
        }
        elseif ($this->__get('Location') === \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY && !$this->checkIsEmpty($this->__get('DataValue'))) {
            if (is_array($this->__get('DataValue')) && array_key_exists($paramName, $this->__get('DataValue'))) {
                $this->contextDataValueExists = true;
                $value                        = $this->__get('DataValue');
                $this->contextDataValue       = $value[$paramName];
            }
            elseif (is_object($this->__get('DataValue')) && property_exists($this->__get('DataValue'), $paramName)) {
                $this->contextDataValueExists = true;
                $this->contextDataValue       = $this->__get('DataValue')->$paramName;
            }
        }

        return $this->checkDataIsEmpty();
    }

    public function getRequestFormDataKey()
    {
        $post = array_keys($_POST);
        $file = array_keys($_FILES);

        if (!is_array($post)) {
            $post = array();
        }

        if (!is_array($file)) {
            $file = array();
        }

        return $post + $file;
    }

    public function loadRequestFormData($paramName)
    {
        if (array_key_exists($paramName, $_POST)) {
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $_POST[$paramName];
        }
        elseif (array_key_exists($paramName, $_FILES)) {
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $_FILES[$paramName];
        }

        return $this->checkDataIsEmpty();
    }

    public function loadRequestPath($paramName)
    {
        // parse from the end to the top
        $path = array_reverse(explode('/', $this->contextRequestPath));

        /**
         * -1 => current params
         * -2 => method
         * -3 => route
         */
        $datapath     = $this->__get('DataPath');
        $partDataPath = null;

        while (true) {
            if (!is_array($datapath) || empty($datapath)) {
                $partDataPath = null;
                break;
            }

            $partDataPath = array_pop($datapath);

            if (substr($partDataPath, 0, 1) == '/') {
                break;
            }
        }

        // parse from the end to the top
        $route = array_reverse(explode('/', $partDataPath));

        foreach ($route as $key => $partRoute) {

            if ($partRoute != '{' . $paramName . '}') {
                continue;
            }

            if (!array_key_exists($key, $path)) {
                $this->contextDataValueExists = false;
                $this->contextDataValue       = null;
                break;
            }

            $this->contextDataValueExists = true;
            $this->contextDataValue       = urldecode($path[$key]);
        }

        return $this->checkDataIsEmpty();
    }

    public function getRequestQueryKey()
    {
        $uri = explode('?', $this->getEnv('REQUEST_URI'));

        array_shift($uri);
        parse_str(implode('?', $uri), $qrs);

        return array_keys($qrs);
    }

    public function loadRequestQuery($paramName)
    {
        $uri = explode('?', $this->getEnv('REQUEST_URI'));

        array_shift($uri);
        parse_str(implode('?', $uri), $qrs);

        if (array_key_exists($paramName, $qrs)) {
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $qrs[$paramName];
        }

        return $this->checkDataIsEmpty();
    }

    public function loadRequestHeader($paramName)
    {
        $headers = $this->getRequestHeader();

        if (array_key_exists($paramName, $headers)) {
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $headers[$paramName];
        }

        return $this->checkDataIsEmpty();
    }

    public function loadResponseHeader($paramName)
    {
        $headers = $this->getResponseHeader();

        if (array_key_exists($paramName, $headers)) {
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $headers[$paramName];
        }

        return $this->checkDataIsEmpty();
    }

    public function loadRequestBody()
    {
        $headers       = $this->getRequestHeader();
        $contentType   = null;
        $contentLength = null;

        if (array_key_exists('Content-Type', $headers)) {
            $contentType = explode(';', $headers['Content-Type']);
            $contentType = str_replace(array('application/', 'text/', 'x-'), '', array_shift($contentType));
        }

        if (array_key_exists('Content-Length', $headers)) {
            $contentLength = (int) $headers['Content-Length'];
        }

        if ($contentLength < 1) {
            $this->contextDataValueExists = false;
            $this->contextDataValueEmpty  = true;
            $this->contextDataValue       = null;
            return;
        }

        switch (strtolower($contentType)) {
            case 'json' :
                $this->contextDataType        = self::CONTENT_TYPE_JSON;
                $contents                     = $this->getRequestBodyRawData();
                $this->contextDataValueExists = (bool) (strlen($contents) > 0);
                $this->contextDataValue       = json_decode($contents, false);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->contextDataValueEmpty = true;
                    $this->contextDataValue      = null;
                    if (function_exists('json_last_error_msg')) {
                        $this->contextDataDecodeError = array(array('code' => json_last_error(), 'message' => json_last_error_msg()));
                    }
                    else {
                        $this->contextDataDecodeError = array(array('code' => json_last_error(), 'message' => null));
                    }
                }
                else {
                    $this->checkDataIsEmpty();
                }
                break;

            case 'xml' :
                $this->contextDataType        = self::CONTENT_TYPE_XML;
                $contents                     = $this->getRequestBodyRawData();
                $this->contextDataValueExists = (bool) (strlen($contents) > 0);
                $this->contextDataValue       = simplexml_load_string($contents);

                if ($this->contextDataValue === false) {
                    $this->contextDataValueEmpty  = true;
                    $this->contextDataValue       = null;
                    $this->contextDataDecodeError = array();

                    foreach (libxml_get_errors() as $error) {
                        $this->contextDataDecodeError[] = array('code' => $error->$code, 'message' => $error->message);
                    }
                }
                else {
                    $this->contextDataValue = \SwaggerValidator\Common\Collection::jsonEncode($this->__get('DataValue'));

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $this->contextDataValueEmpty = true;
                        $this->contextDataValue      = null;
                        if (function_exists('json_last_error_msg')) {
                            $this->contextDataDecodeError[] = array('code' => json_last_error(), 'message' => json_last_error_msg());
                        }
                        else {
                            $this->contextDataDecodeError[] = array('code' => json_last_error(), 'message' => null);
                        }
                    }
                    else {
                        $this->contextDataValue = json_decode($this->__get('DataValue'), false);

                        if (json_last_error() !== JSON_ERROR_NONE) {
                            $this->contextDataValueEmpty = true;
                            $this->contextDataValue      = null;
                            if (function_exists('json_last_error_msg')) {
                                $this->contextDataDecodeError[] = array('code' => json_last_error(), 'message' => json_last_error_msg());
                            }
                            else {
                                $this->contextDataDecodeError[] = array('code' => json_last_error(), 'message' => null);
                            }
                        }
                        else {
                            $this->checkDataIsEmpty();
                        }
                    }
                }
                break;

            default:
                $this->contextDataType        = self::CONTENT_TYPE_OTHER;
                $this->contextDataValueExists = false;
                $this->contextDataValueEmpty  = true;
                $this->contextDataValue       = null;
                break;
        }
    }

    public function getRequestBodyRawData()
    {
        if (array_key_exists('php://input', $this->mockedData)) {
            return $this->mockedData['php://input'];
        }

        return file_get_contents("php://input");
    }

    public function loadResponseBody()
    {
        $headers       = $this->getResponseHeader();
        $contentType   = null;
        $contentLength = null;

        if (array_key_exists('Content-Type', $headers)) {
            $contentType = explode(';', $headers['Content-Type']);
            $contentType = str_replace(array('application/', 'text/', 'x-'), '', array_shift($contentType));
        }

        if (array_key_exists('Content-Length', $headers)) {
            $contentLength = (int) $headers['Content-Length'];
        }

        if ($contentLength < 1) {
            $this->contextDataValueExists = false;
            $this->contextDataValueEmpty  = true;
            $this->contextDataValue       = null;
            return;
        }

        switch (strtolower($contentType)) {
            case 'json' :
                $this->contextDataType        = self::CONTENT_TYPE_JSON;
                $contents                     = $this->getResponseBodyRawData();
                $this->contextDataValueExists = (bool) (strlen($contents) > 0);
                $this->contextDataValue       = json_decode($contents, false);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->contextDataValueEmpty = true;
                    $this->contextDataValue      = null;
                    if (function_exists('json_last_error_msg')) {
                        $this->contextDataDecodeError = array(array('code' => json_last_error(), 'message' => json_last_error_msg()));
                    }
                    else {
                        $this->contextDataDecodeError = array(array('code' => json_last_error(), 'message' => null));
                    }
                }
                else {
                    $this->checkDataIsEmpty();
                }
                break;

            case 'xml' :
                $this->contextDataType        = self::CONTENT_TYPE_XML;
                $contents                     = $this->getResponseBodyRawData();
                $this->contextDataValueExists = (bool) (strlen($contents) > 0);
                $this->contextDataValue       = simplexml_load_string($contents);

                if ($this->contextDataValue === false) {
                    $this->contextDataValueEmpty  = true;
                    $this->contextDataValue       = null;
                    $this->contextDataDecodeError = array();

                    foreach (libxml_get_errors() as $error) {
                        $this->contextDataDecodeError[] = array('code' => $error->$code, 'message' => $error->message);
                    }
                }
                else {
                    $this->contextDataValue = \SwaggerValidator\Common\Collection::jsonEncode($this->__get('DataValue'));

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $this->contextDataValueEmpty = true;
                        $this->contextDataValue      = null;
                        if (function_exists('json_last_error_msg')) {
                            $this->contextDataDecodeError[] = array('code' => json_last_error(), 'message' => json_last_error_msg());
                        }
                        else {
                            $this->contextDataDecodeError[] = array('code' => json_last_error(), 'message' => null);
                        }
                    }
                    else {
                        $this->contextDataValue = json_decode($this->__get('DataValue'), false);

                        if (json_last_error() !== JSON_ERROR_NONE) {
                            $this->contextDataValueEmpty = true;
                            $this->contextDataValue      = null;
                            if (function_exists('json_last_error_msg')) {
                                $this->contextDataDecodeError[] = array('code' => json_last_error(), 'message' => json_last_error_msg());
                            }
                            else {
                                $this->contextDataDecodeError[] = array('code' => json_last_error(), 'message' => null);
                            }
                        }
                        else {
                            $this->checkDataIsEmpty();
                        }
                    }
                }
                break;

            default:
                $this->contextDataType        = self::CONTENT_TYPE_OTHER;
                $this->contextDataValueExists = false;
                $this->contextDataValueEmpty  = true;
                $this->contextDataValue       = null;
                break;
        }
        return null;
    }

    public function getResponseBodyRawData()
    {
        if (array_key_exists('php://output', $this->mockedData)) {
            return $this->mockedData['php://output'];
        }

        return file_get_contents("php://output");
    }

    public function setValidationError($valitionType, $messageException = null, $method = null, $line = null)
    {
        if (empty($method) && empty($line)) {
            foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10) as $oneTrace) {
                if (array_key_exists('file', $oneTrace) && $oneTrace['file'] == __FILE__) {
                    continue;
                }

                if (array_key_exists('class', $oneTrace)) {
                    $method = $oneTrace['class'];
                }
                elseif (array_key_exists('file', $oneTrace)) {
                    $method = $oneTrace['file'];
                }

                if (array_key_exists('line', $oneTrace)) {
                    $line = $oneTrace['line'];
                }
            }
        }

        $this->logValidationError($valitionType, $method, $line);

        if ($this->__get('IsCombined')) {
            return false;
        }

        switch ($this->getMode()) {
            case self::MODE_PASS:
                $this->cleanParams();
                break;

            default:
                $this->cleanParams();
                \SwaggerValidator\Exception::throwNewException($messageException, $this, __FILE__, __LINE__);
        }
    }

    public static function logLoadFile($file, $method = null, $line = null)
    {
        if (self::getConfig('log', 'loadFile')) {
            self::logDebug('Loading File : "' . $file . '"', $method, $line);
        }
    }

    public static function logLoadRef($ref, $method = null, $line = null)
    {
        if (self::getConfig('log', 'loadRef')) {
            self::logDebug('Loading Reference : "' . $ref . '"', $method, $line);
        }
    }

    public static function logReplaceRef($oldRef, $newRef, $method = null, $line = null)
    {
        if (self::getConfig('log', 'replaceRef')) {
            self::logDebug('Replacing Reference From "' . $oldRef . '" to "' . $newRef . '"', $method, $line);
        }
    }

    public static function logDecode($decodePath, $decodeType, $method = null, $line = null)
    {
        if (self::getConfig('log', 'decode')) {
            self::logDebug('Decoding Path "' . $decodePath . '" As "' . $decodeType . '"', $method, $line);
        }
    }

    public static function logValidate($path, $type, $method = null, $line = null)
    {
        if (self::getConfig('log', 'validate')) {
            self::logDebug('Success validate "' . $path . '" As "' . $type . '"', $method, $line);
        }
    }

    public static function logModel($path, $method = null, $line = null)
    {
        if (self::getConfig('log', 'model')) {
            self::logDebug('Model Created "' . $path . '"', $method, $line);
        }
    }

    /**
     * Used to customizing log and more when a debug is send
     *
     * @param string $message
     * @param mixed $context
     * @param string $method
     * @param TypeInteger $line
     */
    public static function logDebug($message, $method = null, $line = null)
    {
        print "[" . date('Y-m-d H:i:s') . "][DEBUG][{{$method}#{$line}] - {$message} \n";
    }

    /**
     * Used to customizing log and more when a validation error is occured
     *
     * @param const $validationType
     * @param \SwaggerValidator\Common\Context $swaggerContext
     */
    public function logValidationError($validationType, $method = null, $line = null)
    {
        print "[" . date('Y-m-d H:i:s') . "][VALIDATION][KO][{{$method}#{$line}][{$validationType}] : " . $this->__toString() . "\n";
    }

    /**
     * Used to clean params if validation error occured for mode PASS
     *
     * @param const $type
     * @param const $location
     * @param const $method
     * @param string $name
     */
    public function cleanParams()
    {
        $_GET    = array();
        $_POST   = array();
        $_FILES  = array();
        $_COOKIE = array();
    }

    public static function cleanCheckedDataName()
    {
        self::$contextValidatedParams = array(
            \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM  => array(),
            \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY => array(),
            \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY  => false,
        );
    }

    public static function getCheckedDataName()
    {
        return self::$contextValidatedParams;
    }

    public static function getCheckedMethodFormLocation($type, $location)
    {
        switch ($type . $location) {
            case self::TYPE_REQUEST . \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM:
                return 'getRequestFormDataKey';

            case self::TYPE_REQUEST . \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY:
                return 'getRequestQueryKey';
        }
    }

    public static function addCheckedDataName($location, $name)
    {
        if (!is_array(self::$contextValidatedParams)) {
            self::$contextValidatedParams = array(
                \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM  => array(),
                \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY => array(),
                \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY  => false,
            );
        }

        switch ($location) {
            case \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM:
            case \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY:
                self::$contextValidatedParams[$location][] = $name;
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY:
                self::$contextValidatedParams[$location] = true;
                break;
        }
    }

    public function mock($options = array())
    {
        $this->mockedData = $options;

        if (empty($this->mockedData) || !is_array($this->mockedData)) {
            $this->mockedData = array();
        }
    }

    private function checkIsEmpty($mixed)
    {
        return empty($mixed);
    }

    public function getEnv($name)
    {
        if (array_key_exists($name, $this->mockedData)) {
            return $this->mockedData[$name];
        }

        return getenv($name);
    }

    public function getRequestHeader()
    {
        return apache_request_headers() + $this->mockedData;
    }

    public function getResponseHeader()
    {
        return apache_response_headers() + $this->mockedData;
    }

}
