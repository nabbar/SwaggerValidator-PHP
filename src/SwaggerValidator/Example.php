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
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
if (file_exists('bin/SwaggerValidator.phar')) {
    //using phar package
    include_once 'phar://bin/SwaggerValidator.phar';
}
else {
    // using source package
    include_once 'Swagger.php';
}

//\SwaggerValidator\Swagger::setSwaggerFile("swagger_example.json");
\SwaggerValidator\Swagger::setSwaggerFile(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'phpunit' . DIRECTORY_SEPARATOR . 'examples' . DIRECTORY_SEPARATOR . 'swaggerPetStoreHeroku.json');
$swagger = \SwaggerValidator\Swagger::load();

/**
 * Validate request in Deny Mode (like strict : generate error if request is in error)
 */
$swagger->validate(new \SwaggerValidator\Common\Context(\SwaggerValidator\Common\Context::TYPE_REQUEST, \SwaggerValidator\Common\Context::MODE_DENY));

/**
 * Validate request in Pass Mode (like ignore & clean : clean not validated parameters in request)
 */
$swagger->validate(new \SwaggerValidator\Common\Context(\SwaggerValidator\Common\Context::TYPE_REQUEST, \SwaggerValidator\Common\Context::MODE_PASS));

/**
 * Validate response in Deny Mode (like strict : generate error if request is in error)
 */
$swagger->validate(new \SwaggerValidator\Common\Context(\SwaggerValidator\Common\Context::TYPE_RESPONSE, \SwaggerValidator\Common\Context::MODE_DENY));

/**
 * Validate response in Pass Mode (like ignore & clean : clean not validated element in response)
 */
$swagger->validate(new \SwaggerValidator\Common\Context(\SwaggerValidator\Common\Context::TYPE_RESPONSE, \SwaggerValidator\Common\Context::MODE_PASS));

/**
 * Generate an array for each operation with request & response model
 * use example in the sagger primitive type to define example
 * or less the swagger validator generate example contents
 */
$swagger->getModel(new \SwaggerValidator\Common\Context());

json_encode($swagger);
