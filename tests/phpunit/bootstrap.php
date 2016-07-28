<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'genericTestClass.php';

define('PHPUNIT_PATH_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('PHPUNIT_PATH_EXPECTED', PHPUNIT_PATH_ROOT . "expected" . DIRECTORY_SEPARATOR);
define('PHPUNIT_PATH_EXAMPLE', PHPUNIT_PATH_ROOT . "examples" . DIRECTORY_SEPARATOR);
define('SWAGGER_PATH_ROOT', dirname(PHPUNIT_PATH_ROOT) . DIRECTORY_SEPARATOR . 'Swagger' . DIRECTORY_SEPARATOR);

print "\n";
print "Loading :" . SWAGGER_PATH_ROOT . "Autoload.php\n";

require_once SWAGGER_PATH_ROOT . 'Autoload.php';
\Swagger\Autoload::registerAutoloader();

