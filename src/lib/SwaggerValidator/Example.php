<?php

include_once 'Swagger.php';

\SwaggerValidator\Swagger::setSwaggerFile("swagger_example.json");
$swagger = \SwaggerValidator\Swagger::load();
