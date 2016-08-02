[![Dependency Status](https://gemnasium.com/badges/github.com/njuhel/SwaggerValidator-PHP.svg)](https://gemnasium.com/github.com/njuhel/SwaggerValidator-PHP)  ~  [![Code Climate](https://codeclimate.com/github/njuhel/SwaggerValidator-PHP/badges/gpa.svg)](https://codeclimate.com/github/njuhel/SwaggerValidator-PHP)  ~  [![Test Coverage](https://codeclimate.com/github/njuhel/SwaggerValidator-PHP/badges/coverage.svg)](https://codeclimate.com/github/njuhel/SwaggerValidator-PHP/coverage)

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
  - custimization easy : all classes are overriding without writing the parser (using a customized factory)
  - working finely with single and multi file swagger definition
  - can generate single swagger definition file based on multi swagger definition file
  - allow local and remote definition file
  - allow using circular reference (only for no required properties in an object)
  - follow RFC and recommandation for primitive type and format and not native language understanding type and format
  - using cache for working file in parsing request/response
  - using easy overriding IO class for collect request/response data to be validated
  - unit test in your environnement for checking compatibility

## **Need to do**
  - use sandbox for validated request/response
  - use PHP PSR-7 Querystring parsing
  - response building automaticly base on content type response, accept and produce

## **Compatibility**
  **_Help us to fix error with compatibilities_**
  - scope PHP 5.3.10 (bug reported, need some more compatibilities) to PHP 7.0

  
## **Installation Guide**
- Install into a git repository as submodule : 
```sh
git submodule init
git submodule add --branch v1.0.x http://srv01.https://github.com/njuhel/SwaggerValidator-PHP src/lib/SwaggerValidator
git submodule update
```

- Install by cloning git : 
```sh
git clone --branch v1.0.x https://github.com/njuhel/SwaggerValidator-PHP SwaggerValidator
```

- Install with composer (adding this in composer.json): 
```json
    "require": {
        "njuhel/swagger-validator":">=1.0.0"
    },
```

- Install with phar : 
```sh
wget https://github.com/njuhel/SwaggerValidator-PHP/raw/v1.0.x/bin/SwaggerValidator.phar 
```

  
## **Example & Docs**
 - **Examples in Snippets** : [Example.php](https://github.com/njuhel/SwaggerValidator-PHP/blob/v1.0.x/src/SwaggerValidator/Example.php) 
 - **Documentation** : [generated](https://github.com/njuhel/SwaggerValidator-PHP/blob/v1.0.x/doc/README.md)


