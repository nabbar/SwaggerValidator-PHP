<?php

/**
 * Description of SwaggerSmokeTest
 *
 * @author Nabbar
 */
class SwaggerPetStoreFullSmokeTest extends genericTestClass
{

    public function testSmokeModel()
    {
        $this->swaggerFilePath = PHPUNIT_PATH_EXAMPLE . 'swaggerPetStoreFull.json';
        $this->swaggerBuild();
        $this->loadModel();

        $keyLocationPath   = \Swagger\Common\FactorySwagger::LOCATION_PATH;
        $keyLocationQuery  = \Swagger\Common\FactorySwagger::LOCATION_QUERY;
        $keyLocationForm   = \Swagger\Common\FactorySwagger::LOCATION_FORM;
        $keyLocationHeader = \Swagger\Common\FactorySwagger::LOCATION_HEADER;
        $keyLocationBody   = \Swagger\Common\FactorySwagger::LOCATION_BODY;

        $keyParameters = \Swagger\Common\FactorySwagger::KEY_PARAMETERS;
        $keyResponses  = \Swagger\Common\FactorySwagger::KEY_RESPONSES;
        $keyHeaders    = \Swagger\Common\FactorySwagger::KEY_HEADERS;
        $keySchema     = \Swagger\Common\FactorySwagger::KEY_SCHEMA;

        $queryString = null;
        $headers     = array();
        $postForm    = array();
        $bodyRaw     = null;

        $this->assertInternalType('object', $this->swaggerObject);
        $this->assertInternalType('array', $this->swaggerModel);
        $this->assertGreaterThan(0, count($this->swaggerModel));

        foreach (array_keys($this->swaggerModel) as $testKey) {

            $path        = null;
            $queryString = null;
            $method      = null;
            $headers     = null;
            $bodyRaw     = null;
            $postForm    = null;

            $this->assertNotEmpty($testKey);

            $this->assertArrayHasKey($testKey, $this->swaggerModel, $testKey);

            $this->assertInternalType('array', $this->swaggerModel[$testKey], $testKey);

            $this->assertArrayHasKey('path', $this->swaggerModel[$testKey]);
            $this->assertNotEmpty($this->swaggerModel[$testKey]['path'], $testKey);
            $path = $this->swaggerModel[$testKey]['path'];

            $this->assertArrayHasKey('method', $this->swaggerModel[$testKey], $testKey);
            $this->assertNotEmpty($this->swaggerModel[$testKey]['method'], $testKey);
            $method = $this->swaggerModel[$testKey]['method'];

            $this->assertArrayHasKey($keyParameters, $this->swaggerModel[$testKey], $testKey);
            $this->assertInternalType('array', $this->swaggerModel[$testKey][$keyParameters], $testKey);

            if (array_key_exists($keyLocationPath, $this->swaggerModel[$testKey][$keyParameters])) {
                foreach ($this->swaggerModel[$testKey][$keyParameters][$keyLocationPath] as $key => $value) {
                    $path = str_replace('{' . $key . '}', urlencode($value), $path);
                }
            }

            if (array_key_exists($keyLocationQuery, $this->swaggerModel[$testKey][$keyParameters])) {
                $queryString = '';

                foreach ($this->swaggerModel[$testKey][$keyParameters][$keyLocationQuery] as $key => $value) {
                    if (!is_array($value) && !is_object($value)) {
                        $queryString .= '&' . $key . '=' . urlencode($value);
                    }
                    else {
                        print "\nCannot generate an array in the queryString for param '$key' in path '$path'\n";
                    }
                }

                $queryString = '?' . substr($queryString, 1);
            }

            if (array_key_exists($keyLocationHeader, $this->swaggerModel[$testKey][$keyParameters])) {
                $headers = $this->swaggerModel[$testKey][$keyParameters][$keyLocationHeader];
            }

            if (array_key_exists($keyLocationForm, $this->swaggerModel[$testKey][$keyParameters])) {
                $postForm = $this->swaggerModel[$testKey][$keyParameters][$keyLocationForm];
            }

            if (array_key_exists($keyLocationBody, $this->swaggerModel[$testKey][$keyParameters])) {
                $bodyRaw = $this->swaggerModel[$testKey][$keyParameters][$keyLocationBody][$keyLocationBody];
            }

            $context = $this->mockContextRequest($path, $queryString, $method, $headers, $bodyRaw, $postForm);
            $context->setMode(\Swagger\Common\Context::MODE_DENY);

            $this->assertTrue($this->swaggerObject->validate($context), $testKey);

            $this->assertArrayHasKey($keyResponses, $this->swaggerModel[$testKey], $testKey);
            $this->assertInternalType('array', $this->swaggerModel[$testKey][$keyResponses], $testKey);

            foreach (array_keys($this->swaggerModel[$testKey][$keyResponses]) as $status) {

                $headers = array(
                    "http_response_code" => $status,
                );
                $bodyRaw = null;

                if (!is_array($this->swaggerModel[$testKey][$keyResponses][$status])) {
                    continue;
                }

                if (array_key_exists($keyHeaders, $this->swaggerModel[$testKey][$keyResponses][$status])) {
                    foreach ($this->swaggerModel[$testKey][$keyResponses][$status][$keyHeaders] as $key => $value) {
                        $headers[$key] = $value;
                    }
                }

                if (array_key_exists($keySchema, $this->swaggerModel[$testKey][$keyResponses][$status])) {
                    $bodyRaw = $this->swaggerModel[$testKey][$keyResponses][$status][$keySchema];
                }

                $context = $this->mockContextResponse($path, $method, $headers, $bodyRaw);
                $context->setMode(\Swagger\Common\Context::MODE_DENY);

                $this->assertTrue($this->swaggerObject->validate($context), $testKey);
            }
        }
    }

}
