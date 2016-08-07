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
            'loadFile'   => true,
            'loadRef'    => true,
            'replaceRef' => true,
            'decode'     => true,
            'validate'   => true,
            'model'      => true,
        ),
    );

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
        self::setConfig('log', 'decode', false);
        self::setConfig('log', 'validate', false);
        self::setConfig('log', 'model', false);
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
        if ($this->__get('DataValueExists') === false) {
            $this->contextDataValueEmpty = true;
        }
        elseif (is_object($this->getDataValue())) {
            $this->contextDataValueEmpty = false;
        }
        elseif (is_array($this->getDataValue())) {
            $this->contextDataValueEmpty = false;
        }
        elseif (is_string($this->getDataValue())) {
            $this->contextDataValueEmpty = (bool) (strlen($this->getDataValue()) == 0);
        }
        elseif (is_numeric($this->getDataValue())) {
            $this->contextDataValueEmpty = false;
        }
        else {
            $this->contextDataValueEmpty = (bool) $this->checkIsEmpty($this->getDataValue());
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

        $this->contextDataValueExists = false;
        $this->contextDataValue       = null;

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
                $this->contextDataValueExists = true;
                $value                        = $this->getDataValue();
                $this->contextDataValue       = $value[$paramName];
            }
            elseif (is_object($this->getDataValue()) && property_exists($this->getDataValue(), $paramName)) {
                $this->contextDataValueExists = true;
                $this->contextDataValue       = $this->getDataValue()->$paramName;
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
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $_POST[$paramName];
        }
        elseif (array_key_exists($paramName, $_FILES)) {
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $_FILES[$paramName];
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
                $this->contextDataValueExists = false;
                $this->contextDataValue       = null;
                break;
            }

            $this->contextDataValueExists = true;
            $this->contextDataValue       = urldecode($path[$key]);
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
        parse_str(implode('?', $uri), $qrs);

        if (array_key_exists($paramName, $qrs)) {
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $qrs[$paramName];
        }

        return $this->checkDataIsEmpty();
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
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $headers[$paramName];
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
            $this->contextDataValueExists = true;
            $this->contextDataValue       = $headers[$paramName];
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
            $this->contextDataValueExists = false;
            $this->contextDataValueEmpty  = true;
            $this->contextDataValue       = null;
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
                $this->contextDataType        = self::CONTENT_TYPE_OTHER;
                $this->contextDataValueExists = false;
                $this->contextDataValueEmpty  = true;
                $this->contextDataValue       = null;
                break;
        }
    }

    /**
     * Method to build the body mixed data from a JSON Raw Body
     * @param string $contents
     */
    public function buildBodyJson($contents)
    {
        $this->contextDataType        = self::CONTENT_TYPE_JSON;
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
    }

    /**
     * Method to build the body mixed data from a XML Raw Body
     * @param string $contents
     */
    public function buildBodyXml($contents)
    {
        $this->contextDataType        = self::CONTENT_TYPE_XML;
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
            $this->contextDataValue = \SwaggerValidator\Common\Collection::jsonEncode($this->getDataValue());

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
                $this->contextDataValue = json_decode($this->getDataValue(), false);

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

        switch ($this->getLocation()) {
            case \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY:
                \SwaggerValidator\Common\Sandbox::getInstance()->setBody($this->getDataValue());
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM:
                \SwaggerValidator\Common\Sandbox::getInstance()->setForm($this->getLastDataPath(), $this->getDataValue());
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER:
                \SwaggerValidator\Common\Sandbox::getInstance()->setHeader($this->getLastDataPath(), $this->getDataValue());
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH:
                \SwaggerValidator\Common\Sandbox::getInstance()->setPath($this->getLastDataPath(), $this->getDataValue());
                break;

            case \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY:
                \SwaggerValidator\Common\Sandbox::getInstance()->setQueryString($this->getLastDataPath(), $this->getDataValue());
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

        return array(
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
    public static function logLoadFile($file, $method = null, $line = null)
    {
        if (self::getConfig('log', 'loadFile')) {
            self::logDebug('Loading File : "' . $file . '"', $method, $line);
        }
    }

    /**
     * Log loading external reference
     * @param string $ref
     * @param string $method
     * @param int $line
     */
    public static function logLoadRef($ref, $method = null, $line = null)
    {
        if (self::getConfig('log', 'loadRef')) {
            self::logDebug('Loading Reference : "' . $ref . '"', $method, $line);
        }
    }

    /**
     * Log a replacement of external reference to internal id of reference
     * @param string $oldRef
     * @param string $newRef
     * @param string $method
     * @param int $line
     */
    public static function logReplaceRef($oldRef, $newRef, $method = null, $line = null)
    {
        if (self::getConfig('log', 'replaceRef')) {
            self::logDebug('Replacing Reference From "' . $oldRef . '" to "' . $newRef . '"', $method, $line);
        }
    }

    /**
     * Log a decoding json mixed data as SwaggerValidator PHP object
     * @param string $decodePath
     * @param string $decodeType
     * @param string $method
     * @param int $line
     */
    public static function logDecode($decodePath, $decodeType, $method = null, $line = null)
    {
        if (self::getConfig('log', 'decode')) {
            self::logDebug('Decoding Path "' . $decodePath . '" As "' . $decodeType . '"', $method, $line);
        }
    }

    /**
     * Log a validation success
     * @param string $path
     * @param string $type
     * @param string $method
     * @param int $line
     */
    public static function logValidate($path, $type, $method = null, $line = null)
    {
        if (self::getConfig('log', 'validate')) {
            self::logDebug('Success validate "' . $path . '" As "' . $type . '"', $method, $line);
        }
    }

    /**
     * Log a creation model success
     * @param string $path
     * @param string $method
     * @param int $line
     */
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
                $e = new \SwaggerValidator\Exception();
                $e->init($messageException, $this, __FILE__, __LINE__);
                throw $e;
        }
    }

}
