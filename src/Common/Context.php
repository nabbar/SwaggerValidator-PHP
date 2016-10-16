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
 * Description of SwaggerCommonContext
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Context extends ContextBase implements \SwaggerValidator\Interfaces\ContextLog, \SwaggerValidator\Interfaces\ContextDataLoader, \SwaggerValidator\Interfaces\ContextDataParser
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
    const VALIDATION_TYPE_HOSTNAME_ERROR = 'HOSTNAME';
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
    protected static $config = array(
        'mode' => array(
            self::TYPE_REQUEST  => self::MODE_DENY,
            self::TYPE_RESPONSE => self::MODE_PASS,
        ),
        'log'  => array(
            'loadFile'    => true,
            'loadRef'     => true,
            'replaceRef'  => true,
            'registerRef' => true,
            'dropRef'     => true,
            'reference'   => true,
            'decode'      => true,
            'validate'    => true,
            'model'       => true,
            'validation'  => true,
            'exception'   => true,
            'debug'       => true,
        ),
    );

    /**
     * Var Export Method
     */
    protected function __storeData($key, $value = null)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
        else {
            parent::__storeData($key, $value);
        }
    }

    public static function __set_state(array $properties)
    {
        $obj = new static;

        foreach ($properties as $key => $value) {
            $obj->__storeData($key, $value);
        }

        return $obj;
    }

    /**
     * Set a configuration option
     * @param string $optionGroup
     * @param string $optionName
     * @param mixed $value
     * @return void
     */
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

    /**
     * Method to disable all debug log
     */
    public static function setConfigDropAllDebugLog()
    {
        self::setConfig('log', 'loadFile', false);
        self::setConfig('log', 'loadRef', false);
        self::setConfig('log', 'replaceRef', false);
        self::setConfig('log', 'registerRef', false);
        self::setConfig('log', 'dropRef', false);
        self::setConfig('log', 'reference', false);
        self::setConfig('log', 'decode', false);
        self::setConfig('log', 'validate', false);
        self::setConfig('log', 'model', false);
        self::setConfig('log', 'validation', false);
        self::setConfig('log', 'exception', false);
        self::setConfig('log', 'debug', false);
    }

    /**
     * Retrieve a config value
     * @param string $optionGroup
     * @param string $optionName
     * @return mixed
     */
    public static function getConfig($optionGroup, $optionName)
    {
        if (!array_key_exists($optionGroup, self::$config) || !is_array(self::$config[$optionGroup])) {
            return;
        }

        if (!array_key_exists($optionName, self::$config[$optionGroup])) {
            return;
        }

        return self::$config[$optionGroup][$optionName];
    }

    /**
     * Load the called URL/Path to identify component
     * like scheme, host, base path
     */
    public function loadUri()
    {
        $this->contextScheme = $this->getEnv('REQUEST_SCHEME');
        $this->contextHost   = $this->getEnv('SERVER_NAME');

        $uri = explode('?', $this->getEnv('REQUEST_URI'));

        $this->contextBasePath = array_shift($uri);
    }

    /**
     * Check if the loaded data are empty or not
     */
    public function checkDataIsEmpty()
    {
        if ($this->isDataExists() === false) {
            $this->contextDataEmpty = true;
        }
        elseif (is_object($this->getDataValue())) {
            $this->contextDataEmpty = false;
        }
        elseif (is_array($this->getDataValue())) {
            $this->contextDataEmpty = false;
        }
        elseif (is_string($this->getDataValue())) {
            $this->contextDataEmpty = (bool) (strlen($this->getDataValue()) == 0);
        }
        elseif (is_numeric($this->getDataValue())) {
            $this->contextDataEmpty = false;
        }
        else {
            $this->contextDataEmpty = (bool) $this->checkIsEmpty($this->getDataValue());
        }
    }

    /**
     * return the response status sent
     * @return integer|null
     */
    public function getResponseStatus()
    {
        if (array_key_exists('http_response_code', $this->mockedData)) {
            return $this->mockedData['http_response_code'];
        }

        if (function_exists('http_response_code')) {
            return http_response_code();
        }

        return null;
    }

    /**
     * Load data and check it based on local context definition
     * @return void
     */
    public function dataLoad()
    {
        $paramName = $this->__get('DataPath');
        $paramName = array_pop($paramName);

        $this->contextDataExists = false;
        $this->contextDataValue  = null;

        if ($paramName === \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY && $this->getType() === self::TYPE_REQUEST) {
            return $this->loadRequestBody();
        }
        elseif ($paramName === \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY && $this->getType() === self::TYPE_RESPONSE) {
            return $this->loadResponseBody();
        }
        elseif ($this->getType() === self::TYPE_REQUEST && $this->getLocation() === \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER) {
            return $this->loadRequestHeader($paramName);
        }
        elseif ($this->getType() === self::TYPE_RESPONSE && $this->getLocation() === \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER) {
            return $this->loadResponseHeader($paramName);
        }
        elseif ($this->getType() === self::TYPE_REQUEST && $this->getLocation() === \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM) {
            return $this->loadRequestFormData($paramName);
        }
        elseif ($this->getType() === self::TYPE_REQUEST && $this->getLocation() === \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH) {
            return $this->loadRequestPath($paramName);
        }
        elseif ($this->getType() === self::TYPE_REQUEST && $this->getLocation() === \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY) {
            return $this->loadRequestQuery($paramName);
        }
        elseif ($this->getLocation() === \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY && !$this->checkIsEmpty($this->getDataValue())) {
            if (is_array($this->getDataValue()) && array_key_exists($paramName, $this->getDataValue())) {
                $this->contextDataExists = true;
                $value                   = $this->getDataValue();
                $this->contextDataValue  = $value[$paramName];
            }
            elseif (is_object($this->getDataValue()) && property_exists($this->getDataValue(), $paramName)) {
                $this->contextDataExists = true;
                $this->contextDataValue  = $this->getDataValue()->$paramName;
            }
        }

        return $this->checkDataIsEmpty();
    }

    /**
     * return the complete list of all params send in form data ($_POST or $_FILES)
     * @return array
     */
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

    /**
     * Filtering the request form data and files,
     * load the data and check it
     * @param string $paramName
     * @return void
     */
    public function loadRequestFormData($paramName)
    {
        if (array_key_exists($paramName, $_POST)) {
            $this->contextDataExists = true;
            $this->contextDataValue  = $_POST[$paramName];
        }
        elseif (array_key_exists($paramName, $_FILES)) {
            $this->contextDataExists = true;
            $this->contextDataValue  = $_FILES[$paramName];
        }

        return $this->checkDataIsEmpty();
    }

    /**
     * Filtering the request path to identify the path parameters,
     * load the data and check it
     * @param string $paramName
     * @return void
     */
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
                $this->contextDataExists = false;
                $this->contextDataValue  = null;
                break;
            }

            $this->contextDataExists = true;
            $this->contextDataValue  = urldecode($path[$key]);
        }

        return $this->checkDataIsEmpty();
    }

    /**
     * return the complete list of all params send in query string
     * @return array
     */
    public function getRequestQueryKey()
    {
        $uri = explode('?', $this->getEnv('REQUEST_URI'));

        array_shift($uri);
        parse_str(implode('?', $uri), $qrs);

        return array_keys($qrs);
    }

    /**
     * Filtering the request querystring, load the data and check it
     * @param string $paramName
     * @return void
     */
    public function loadRequestQuery($paramName)
    {
        $uri = explode('?', $this->getEnv('REQUEST_URI'));
        array_shift($uri);
        $uri = implode('?', $uri);

        /**
         * Override this method to use parsing query string PHP method
         * and not new standard of queryString
         */
        $qrs = $this->parseQueryAsMulti($uri);

        if (array_key_exists($paramName, $qrs)) {
            $this->contextDataExists = true;
            $this->contextDataValue  = $qrs[$paramName];
        }

        return $this->checkDataIsEmpty();
    }

    protected function parseQueryAsPHP($queryString)
    {
        parse_str($queryString, $result);
        return $result;
    }

    protected function parseQueryAsMulti($queryString)
    {
        $params = explode('&', $queryString);
        $result = array();

        foreach ($params as $oneParam) {

            // parse_str does only a rawurldecode and not an urldecode
            // need to realy urldecode following code
            parse_str($oneParam, $qrs);

            if (!is_array($qrs) || count($qrs) < 1) {
                continue;
            }

            $keys = array_keys($qrs);
            $key  = array_shift($keys);

            if (array_key_exists($key, $result)) {
                if (!is_array($result[$key])) {
                    $result[$key] = array($result[$key]);
                }
                $result[$key][] = $qrs[$key];
            }
            else {
                $result[$key] = $qrs[$key];
            }
        }

        return $result;
    }

    /**
     * Filtering the request header, load the data and check it
     * @param string $paramName
     * @return void
     */
    public function loadRequestHeader($paramName)
    {
        $headers = $this->getRequestHeader();

        if (array_key_exists($paramName, $headers)) {
            $this->contextDataExists = true;
            $this->contextDataValue  = $headers[$paramName];
        }

        return $this->checkDataIsEmpty();
    }

    /**
     * Filtering the response header, load the data and check it
     * @param string $paramName
     * @return void
     */
    public function loadResponseHeader($paramName)
    {
        $headers = $this->getResponseHeader();

        if (array_key_exists($paramName, $headers)) {
            $this->contextDataExists = true;
            $this->contextDataValue  = $headers[$paramName];
        }

        return $this->checkDataIsEmpty();
    }

    /**
     * Method to load Request body identify by his content type header
     * And only if a content length is defined and > 0
     * @return void
     */
    public function loadRequestBody()
    {
        if (array_key_exists('php://input', $this->mockedData)) {
            $this->loadBodyByContent($this->getRequestHeader(), $this->mockedData['php://input']);
        }
        else {
            $this->loadBodyByContent($this->getRequestHeader(), file_get_contents("php://input"));
        }
    }

    /**
     * Method to load Response body identify by his content type header
     * And only if a content length is defined and > 0
     */
    public function loadResponseBody()
    {
        if (array_key_exists('php://output', $this->mockedData)) {
            $this->loadBodyByContent($this->getResponseHeader(), $this->mockedData['php://output']);
        }
        else {
            $this->loadBodyByContent($this->getResponseHeader(), file_get_contents("php://output"));
        }
    }

    public function loadBodyByContent($headers, $rawBody)
    {
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
            $this->contextDataExists = false;
            $this->contextDataEmpty  = true;
            $this->contextDataValue  = null;
            return;
        }

        switch (strtolower($contentType)) {
            case 'json' :
                $this->buildBodyJson($rawBody);
                break;

            case 'xml' :
                $this->buildBodyXml($rawBody);
                break;

            default:
                $this->contextDataType   = self::CONTENT_TYPE_OTHER;
                $this->contextDataExists = false;
                $this->contextDataEmpty  = true;
                $this->contextDataValue  = null;
                break;
        }
    }

    /**
     * Method to build the body mixed data from a JSON Raw Body
     * @param string $contents
     */
    public function buildBodyJson($contents)
    {
        $this->contextDataType   = self::CONTENT_TYPE_JSON;
        $this->contextDataExists = (bool) (strlen($contents) > 0);
        $this->contextDataValue  = json_decode($contents, false);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->contextDataEmpty = true;
            $this->contextDataValue = null;
            if (function_exists('json_last_error_msg')) {
                $this->contextDecodeError = array(array('code' => json_last_error(), 'message' => json_last_error_msg()));
            }
            else {
                $this->contextDecodeError = array(array('code' => json_last_error(), 'message' => null));
            }
        }
        else {
            $this->checkDataIsEmpty();
        }
    }

    /**
     * Method to build the body mixed data from a XML Raw Body
     * @param string $contents
     */
    public function buildBodyXml($contents)
    {
        $this->contextDataType   = self::CONTENT_TYPE_XML;
        $this->contextDataExists = (bool) (strlen($contents) > 0);
        $this->contextDataValue  = simplexml_load_string($contents);

        if ($this->contextDataValue === false) {
            $this->contextDataEmpty   = true;
            $this->contextDataValue   = null;
            $this->contextDecodeError = array();

            foreach (libxml_get_errors() as $error) {
                $this->contextDecodeError[] = array('code' => $error->$code, 'message' => $error->message);
            }
        }
        else {
            $this->contextDataValue = \SwaggerValidator\Common\Collection::jsonEncode($this->getDataValue());

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->contextDataEmpty = true;
                $this->contextDataValue = null;
                if (function_exists('json_last_error_msg')) {
                    $this->contextDecodeError[] = array('code' => json_last_error(), 'message' => json_last_error_msg());
                }
                else {
                    $this->contextDecodeError[] = array('code' => json_last_error(), 'message' => null);
                }
            }
            else {
                $this->contextDataValue = json_decode($this->getDataValue(), false);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->contextDataEmpty = true;
                    $this->contextDataValue = null;
                    if (function_exists('json_last_error_msg')) {
                        $this->contextDecodeError[] = array('code' => json_last_error(), 'message' => json_last_error_msg());
                    }
                    else {
                        $this->contextDecodeError[] = array('code' => json_last_error(), 'message' => null);
                    }
                }
                else {
                    $this->checkDataIsEmpty();
                }
            }
        }
    }

    /**
     * return the list of all params (request/response) validated
     * used in the end of validation process to check the TOOMANY parameters error
     * @return array
     */
    public function getSandBoxKeys()
    {
        if ($this->getType() !== self::TYPE_REQUEST) {
            return array();
        }

        return array(
            \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY  => \SwaggerValidator\Common\Sandbox::getInstance()->hasBody(),
            \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM  => \SwaggerValidator\Common\Sandbox::getInstance()->keysForm(),
            \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY => \SwaggerValidator\Common\Sandbox::getInstance()->keysQueryString(),
        );
    }

    /**
     * Adding validated params to check
     * This method improve the TOOMANY errors at the end
     * of the validation process
     * @return \SwaggerValidator\Common\Context
     */
    public function setSandBox()
    {
        if ($this->getType() !== self::TYPE_REQUEST) {
            return $this;
        }

        $last = $this->getLastDataPath();
        $last = array_pop($last);

        switch ($this->getLocation()) {
            case \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY:
                \SwaggerValidator\Common\Sandbox::getInstance()->setBody($this->getDataValue());
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM:
                \SwaggerValidator\Common\Sandbox::getInstance()->setForm($last, $this->getDataValue());
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER:
                \SwaggerValidator\Common\Sandbox::getInstance()->setHeader($last, $this->getDataValue());
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH:
                \SwaggerValidator\Common\Sandbox::getInstance()->setPath($last, $this->getDataValue());
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY:
                \SwaggerValidator\Common\Sandbox::getInstance()->setQueryString($last, $this->getDataValue());
                break;
        }

        return $this;
    }

    /**
     * Method to list all received params name by location
     * @return array
     */
    public function getRequestDataKeys()
    {
        if ($this->getType() !== self::TYPE_REQUEST) {
            return array();
        }

        if (array_key_exists('php://input', $this->mockedData)) {
            $data = $this->mockedData['php://input'];
        }
        else {
            $data = file_get_contents("php://input");
        }

        return array(
            \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY  => (bool) (strlen($data) > 0),
            \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM  => $this->getRequestFormDataKey(),
            \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY => $this->getRequestQueryKey(),
        );
    }

    /**
     * Method to make a empty call usable with function return
     * @param mixed $mixed
     * @return boolean
     */
    private function checkIsEmpty($mixed)
    {
        return empty($mixed);
    }

    /**
     * Method to add capability of override the getenv function of PHP
     * for example to get env data in a sandbox
     * @param string $name
     * @return mixed
     */
    public function getEnv($name)
    {
        if (array_key_exists($name, $this->mockedData)) {
            return $this->mockedData[$name];
        }

        return getenv($name);
    }

    /**
     * Return the header received in the request
     * Use the apache_request_headers (>= PHP 4.3.0)
     * and the mocked data if defined
     * >= PHP 5.4.0 : usable for mod_apache and fastcgi
     * < PHP 5.4.0 : only available for apache module
     * >= 5.5.7 : available for PHP CLI
     * @return array
     */
    public function getRequestHeader()
    {
        return apache_request_headers() + $this->mockedData;
    }

    /**
     * Return the Response header
     * Use the apache_response_headers (>= PHP 4.3.0)
     * and the mocked data if defined
     * >= PHP 5.4.0 : usable for mod_apache and fastcgi
     * < PHP 5.4.0 : only available for apache module
     * >= 5.5.7 : available for PHP CLI
     * @return array
     */
    public function getResponseHeader()
    {
        return apache_response_headers() + $this->mockedData;
    }

    /**
     * Method to define a batch of data to be used to
     * simulate the playback of external data
     * @param array $options
     */
    public function mock($options = array())
    {
        $this->mockedData = $options;

        if (empty($this->mockedData) || !is_array($this->mockedData)) {
            $this->mockedData = array();
        }
    }

    /**
     * Used to clean params if validation error occured for mode PASS
     */
    public function cleanParams()
    {
        $_GET    = array();
        $_POST   = array();
        $_FILES  = array();
        $_COOKIE = array();

        foreach ($this->getRequestHeader() as $key) {
            if (array_key_exists($key, $_SERVER)) {
                unset($_SERVER[$key]);
            }
        }
    }

    /**
     * Log loading file
     * @param string $file
     * @param string $method
     * @param int $line
     */
    public function logLoadFile($file, $method = null, $line = null)
    {
        if (self::getConfig('log', 'loadFile')) {
            $this->logMessage('LOAD FILE', 'Loading File : "' . $file . '"', $method, $line);
        }
    }

    /**
     * Log a decoding json mixed data as SwaggerValidator PHP object
     * @param string $decodePath
     * @param string $decodeType
     * @param string $method
     * @param int $line
     */
    public function logDecode($className, $method = null, $line = null)
    {
        if (self::getConfig('log', 'decode')) {
            $this->logMessage('DECODE', 'Decoding Path "' . $this->getDataPath() . '" As "' . $className . '"', $method, $line);
        }
    }

    /**
     * Log a validation success
     * @param string $path
     * @param string $type
     * @param string $method
     * @param int $line
     */
    public function logValidate($className, $method = null, $line = null)
    {
        if (self::getConfig('log', 'validate')) {
            $this->logMessage('VALIDATE][OK', 'Success validate "' . $this->getDataPath() . '" As "' . $className . '"', $method, $line);
        }
    }

    /**
     * Log a creation model success
     * @param string $path
     * @param string $method
     * @param int $line
     */
    public function logModel($method = null, $line = null)
    {
        if (self::getConfig('log', 'model')) {
            $this->logMessage('MODEL', 'Model Created "' . $this->getDataPath() . '"', $method, $line);
        }
    }

    /**
     * Log an external reference action
     * @param string $type  Type of action
     * @param string $ref
     * @param string $oldRef
     * @param string $method
     * @param int $line
     */
    public function logReference($type, $ref, $oldRef = null, $method = null, $line = null)
    {
        if (self::getConfig('log', 'reference') || self::getConfig('log', $type . 'Ref')) {
            switch ($type) {
                case 'replace':
                    $this->logMessage('REPLACE REF', 'Replacing Reference From "' . $oldRef . '" to "' . $ref . '"', $method, $line);
                    break;
                case 'load':
                    $this->logMessage('LOAD REF', 'Loading Reference : "' . $ref . '"', $method, $line);
                    break;
                case 'register':
                    $this->logMessage('REGISTER REF', 'Registier Reference Definition : "' . $ref . '"', $method, $line);
                    break;
                case 'drop':
                    $this->logMessage('DROP REF', 'Drop Reference : "' . $ref . '"', $method, $line);
                    break;
            }
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
    public function logMessage($type, $message, $method = null, $line = null)
    {
        print "[" . date('Y-m-d H:i:s') . "][{$type}][{{$method}#{$line}] - {$message} \n";
        //file_put_contents('php://stdout', "[" . date('Y-m-d H:i:s') . "][DEBUG][{{$method}#{$line}] - {$message} \n");
    }

    /**
     * Used to customizing log and more when a validation error is occured
     *
     * @param const $validationType
     * @param \SwaggerValidator\Common\Context $swaggerContext
     */
    public function logValidationError($validationType, $messageException = null, $method = null, $line = null)
    {
        if (self::getConfig('log', 'validation')) {
            $this->logMessage("VALIDATE][KO][{$validationType}", "{$messageException} --- " . $this->__toString() . "\n", $method, $line);
        }
        //file_put_contents('php://stderr', "[" . date('Y-m-d H:i:s') . "][VALIDATION][KO][{{$method}#{$line}][{$validationType}] : {$messageException} --- " . $this->__toString() . "\n");
    }

    /**
     * Used to customizing log and more when a validation error is occured
     *
     * @param const $validationType
     * @param \SwaggerValidator\Common\Context $swaggerContext
     */
    public function logException($messageException = null, $method = null, $line = null)
    {
        if (self::getConfig('log', 'exception')) {
            $this->logMessage("EXCEPTION", "Exception find : {$messageException} --- " . $this->__toString(), $method, $line);
        }
    }

    /**
     * Throw a new \SwaggerValidator\Exception with automatic find method, line, ...
     * @param string $message
     * @param mixed $context
     * @throws \SwaggerValidator\Exception
     */
    public function throwException($message, $method = null, $line = null)
    {
        $this->logException($message, $method, $line);

        $e = new \SwaggerValidator\Exception($message);

        $e->setFile($method);
        $e->setLine($line);
        $e->setContext($this);

        throw $e;
    }

    /**
     *
     * @param const $valitionType
     * @param string $messageException
     * @param string $method
     * @param int $line
     * @return boolean
     * @throws \SwaggerValidator\Exception
     */
    public function setValidationError($valitionType, $messageException = null, $method = null, $line = null)
    {
        $this->logValidationError($valitionType, $messageException, $method, $line);

        if ($this->__get('IsCombined')) {
            return false;
        }

        switch ($valitionType) {
            case self::VALIDATION_TYPE_BASEPATH_ERROR:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : BasePath ! Value Find : ' . json_encode($this->getDataValue());
                break;

            case self::VALIDATION_TYPE_HOSTNAME_ERROR:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : HostName ! Value Find : ' . json_encode($this->getDataValue());
                break;

            case self::VALIDATION_TYPE_ROUTE_ERROR:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : Route ! Value Find : ' . json_encode($this->getDataValue());
                break;

            case self::VALIDATION_TYPE_METHOD_ERROR:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : Method ! Value Find : ' . json_encode($this->getDataValue());
                break;

            case self::VALIDATION_TYPE_NOTFOUND:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : NotFound ! This parameters ' . $this->getDataPath() . ' is not found ! ';
                break;

            case self::VALIDATION_TYPE_TOOMANY:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : TooMany ! This path was found and not awaiting : ' . $this->getDataPath();
                break;

            case self::VALIDATION_TYPE_RESPONSE_ERROR:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : Response Status Error in ' . $this->getDataPath() . ' ! ';
                break;

            case self::VALIDATION_TYPE_PATTERN:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : Pattern ! The pattern is not matching with parameters : ' . $this->getDataPath() . ' ! ';
                break;

            case self::VALIDATION_TYPE_DATATYPE:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : Type ! The Type is not matching with parameters : ' . $this->getDataPath() . ' ! ';
                break;

            case self::VALIDATION_TYPE_DATASIZE:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : Size ! The Size is not matching with parameters : ' . $this->getDataPath() . ' ! ';
                break;

            case self::VALIDATION_TYPE_DATAVALUE:
                $this->setValidationErrorCode($valitionType);
                $messageException = 'Swagger Validation Error : Value ! The Value does not respect specification with parameters : ' . $this->getDataPath() . ' ! ';
                break;

            default:
                break;
        }

        switch ($this->getMode()) {
            case self::MODE_PASS:
                $this->cleanParams();
                break;

            default:
                $this->cleanParams();
                $e = new \SwaggerValidator\Exception($messageException);

                $e->setFile($method);
                $e->setLine($line);
                $e->setContext($this);

                throw $e;
        }
    }

}
