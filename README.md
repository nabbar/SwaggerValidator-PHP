[![Dependency Status](https://gemnasium.com/badges/github.com/nabbar/SwaggerValidator-PHP.svg)](https://gemnasium.com/github.com/nabbar/SwaggerValidator-PHP)  ~  [![Code Climate](https://codeclimate.com/github/nabbar/SwaggerValidator-PHP/badges/gpa.svg)](https://codeclimate.com/github/nabbar/SwaggerValidator-PHP)  ~  [![Test Coverage](https://codeclimate.com/github/nabbar/SwaggerValidator-PHP/badges/coverage.svg)](https://codeclimate.com/github/nabbar/SwaggerValidator-PHP/coverage)  ~  [![Travis branch](https://img.shields.io/travis/nabbar/SwaggerValidator-PHP/master.svg?maxAge=600&label=PHP%205.3%20--7.0)](https://travis-ci.org/nabbar/SwaggerValidator-PHP)

[![Packagist](https://img.shields.io/badge/Packagist-njuhel%2Fswagger--validator-blue.svg)](https://packagist.org/packages/njuhel/swagger-validator) ~ [![Composer](https://img.shields.io/badge/composer-require%20njuhel%2Fswagger--validator-blue.svg)](https://packagist.org/packages/njuhel/swagger-validator)

# **Swagger Validator _PHP_**

A Swagger(OpenAPI) Validation and Parser as lib for PHP to secure and helpful application for request / response validating, 
security stage, testunit skeleton, testauto generation, ... This lib can be used into any existing application who's 
having a swagger definition file for request/response.

Swagger is old name of [OpenAPI Projet](https://openapis.org/) and who manage the [OAI Specification](https://github.com/OAI/OpenAPI-Specification/tree/master/schemas/)

## **Why Using a Swagger Validator**
A Swagger *Validator* could be understand as a validation of our swagger definition file with the swagger definition. 
A Swagger *Parser* could be understand as a parser for request entry (sometimes in addition parsing response)
The Swagger Validator is doing all this. It validate your swagger file, validate your entry request and response.

### _Validation / Parsing are mandatory_
  - validating the swagger guarantee that your definition file has no error and will be understand correctly
  - validating the request is a security stage to filter bad request, attempted hack, limit the control and 
    filtering statement in your working source code, ...
  - validating the response is also security stage to filter not needed information before sent them, to 
    limit and prevent error code attack, limit the control and filtering statement in your working source code
    ...

## **Features**
  - Best for Swagger First, Code after
  - Validate / Filter All Request & Response
  - Integration easy with any existing framework, application, ...
  - Allow a soft migration for a complete application MVC to HIM/API application
  - Give example model of request/response based on the swagger to example built automated testing stage, human skeleton for code, documentation skeletton, ...
  - Validate the swagger file in following the Swagger 2.0 specification and JSON Draft v4 (swagger has higher priority to json draft 4)
  - Custimization easy : all classes are overriding without writing the parser (using a customized factory)
  - Working finely with single and multi file swagger definition
  - Can generate single swagger definition file based on multi swagger definition file
  - Allow local and remote definition file
  - Allow using circular reference (only for no required properties in an object)
  - Store validated request params into a sandbox to access only validated params (and clean magics globals variables)
  - Follow RFC and recommandation for primitive type and format and not native language understanding type and format
  - Using cache for working file in parsing request/response
  - Using easy overriding IO class for collect request/response data to be validated
  - Unit test in your environnement for checking compatibility

## **Need to do**
  - use PHP PSR-7 Querystring parsing
  - response building automaticly base on content type response, accept and produce

## **Compatibility**
  **_Help us to fix error with compatibilities_**
  - scope PHP 5.3.10 (bug reported, need some more compatibilities) to PHP 7.0

  
## **Installation Guide**
- Install into a git repository as submodule : 
```sh
git submodule init
git submodule add http://srv01.https://github.com/nabbar/SwaggerValidator-PHP src/lib/SwaggerValidator
git submodule update
```

- Install by cloning git : 
```sh
git clone https://github.com/nabbar/SwaggerValidator-PHP SwaggerValidator
```

- Install with composer (adding this in composer.json): 
```json
    "require": {
        "nabbar/swagger-validator":">=1.2.0"
    },
```

- Install with phar : 
```sh
wget https://github.com/nabbar/SwaggerValidator-PHP/raw/master/bin/SwaggerValidator.phar 
```

  
## **Example & Docs**
 - **Examples** : [Example.php](src/Example.php) 
 - **Documentation** : [generated](doc/README.md)


