<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'genericTestClass.php';

define('PHPUNIT_PATH_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('PHPUNIT_PATH_EXPECTED', PHPUNIT_PATH_ROOT . "expected" . DIRECTORY_SEPARATOR);
define('PHPUNIT_PATH_EXAMPLE', PHPUNIT_PATH_ROOT . "examples" . DIRECTORY_SEPARATOR);
define('REPOS_PATH_TESTS', dirname(PHPUNIT_PATH_ROOT) . DIRECTORY_SEPARATOR);
define('REPOS_PATH_ROOT', dirname(REPOS_PATH_TESTS) . DIRECTORY_SEPARATOR);
define('REPOS_PATH_SRC', REPOS_PATH_ROOT . 'src' . DIRECTORY_SEPARATOR);
define('REPOS_PATH_LIB', REPOS_PATH_SRC . 'lib' . DIRECTORY_SEPARATOR);
define('SWAGGER_PATH_ROOT', REPOS_PATH_LIB . 'SwaggerValidator' . DIRECTORY_SEPARATOR);

require_once SWAGGER_PATH_ROOT . 'Autoload.php';
\SwaggerValidator\Autoload::registerAutoloader();

