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

namespace SwaggerValidator\Interfaces;

/**
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 */
interface ContextBase
{

    public function __construct($mode = null, $type = null);

    public function __get($name);

    public function __set($name, $value);

    public function __isset($name);

    public function __unset($name);

    public function __toString();

    public function __debugInfo();

    public function setMode($value = null);

    public function getMode();

    public function setType($value = null);

    public function getType();

    public function setLocation($value = null);

    public function getLocation();

    public function setMethod($value = null);

    public function getMethod();

    public function loadMethod();

    public function setBasePath($value = null);

    public function getBasePath();

    public function setRoutePath($value = null);

    public function getRoutePath();

    public function setRequestPath($value = null);

    public function getRequestPath();

    public function setScheme($value = null);

    public function getScheme();

    public function setHost($value = null);

    public function getHost();

    public function addContext($key = null, $value = null);

    public function getContext();

    public function setCombined($value = false);

    public function getCombined();

    public function setDataPath($value = null);

    public function getDataPath();

    public function setExternalRef($value = null);

    public function getExternalRef();

    public function getLastExternalRef();

    public function checkExternalRef($value = NULL);

    public function setDataCheck($value = null);

    public function getDataCheck();

    public function setDataValue($value = null);

    public function getDataValue();

    public function isDataExists();

    public function isDataEmpty();
}
