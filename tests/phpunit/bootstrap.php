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

/**
 * Bootstrap for PHPUnit
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
define('PHPUNIT_PATH_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('PHPUNIT_PATH_TEMP', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR);
define('PHPUNIT_PATH_EXPECTED', PHPUNIT_PATH_ROOT . "expected" . DIRECTORY_SEPARATOR);
define('PHPUNIT_PATH_EXAMPLE', PHPUNIT_PATH_ROOT . "examples" . DIRECTORY_SEPARATOR);
define('REPOS_PATH_TESTS', dirname(PHPUNIT_PATH_ROOT) . DIRECTORY_SEPARATOR);
define('REPOS_PATH_ROOT', dirname(REPOS_PATH_TESTS) . DIRECTORY_SEPARATOR);
define('REPOS_PATH_SRC', REPOS_PATH_ROOT . 'src' . DIRECTORY_SEPARATOR);
define('REPOS_PATH_BIN', REPOS_PATH_ROOT . 'bin' . DIRECTORY_SEPARATOR);
define('SWAGGER_PATH_ROOT', REPOS_PATH_SRC);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'testcases' . DIRECTORY_SEPARATOR . 'genericTestClass.php';

require_once SWAGGER_PATH_ROOT . 'SwaggerAutoload.php';
\SwaggerValidator\SwaggerAutoload::registerAutoloader();

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'testcases' . DIRECTORY_SEPARATOR . 'OverrideSwagger.php';
