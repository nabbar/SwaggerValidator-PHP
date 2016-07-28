<?php

include_once 'Swagger.php';

\Swagger\Swagger::setSwaggerFile("swagger_example.json");
$swagger = \Swagger\Swagger::load();
