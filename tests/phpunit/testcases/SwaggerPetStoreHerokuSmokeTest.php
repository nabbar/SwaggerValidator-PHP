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
 * Description of SwaggerSmokeTest
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class SwaggerPetStoreHerokuSmokeTest extends genericTestClass
{

    /**
     * @large
     */
    public function testSmokeModel()
    {
        ob_start();

        $this->swaggerFilePath = PHPUNIT_PATH_EXAMPLE . 'swaggerPetStoreHeroku.json';
        $this->swaggerBuild();
        $this->loadModel();

        $keyLocationPath   = \SwaggerValidator\Common\FactorySwagger::LOCATION_PATH;
        $keyLocationQuery  = \SwaggerValidator\Common\FactorySwagger::LOCATION_QUERY;
        $keyLocationForm   = \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM;
        $keyLocationHeader = \SwaggerValidator\Common\FactorySwagger::LOCATION_HEADER;
        $keyLocationBody   = \SwaggerValidator\Common\FactorySwagger::LOCATION_BODY;

        $keyParameters = \SwaggerValidator\Common\FactorySwagger::KEY_PARAMETERS;
        $keyResponses  = \SwaggerValidator\Common\FactorySwagger::KEY_RESPONSES;
        $keyHeaders    = \SwaggerValidator\Common\FactorySwagger::KEY_HEADERS;
        $keySchema     = \SwaggerValidator\Common\FactorySwagger::KEY_SCHEMA;

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
            $context->setMode(\SwaggerValidator\Common\Context::MODE_DENY);

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
                $context->setMode(\SwaggerValidator\Common\Context::MODE_DENY);

                $this->assertTrue($this->swaggerObject->validate($context), $testKey);
            }
        }

        ob_end_clean();
    }

    /**
     * @medium
     */
    public function testDocument()
    {
        if (version_compare(PHP_VERSION, "5.4", "<")) {
            $this->assertTrue(version_compare(PHP_VERSION, "5.4", "<"));
            return;
        }

        ob_start();

        $this->swaggerFilePath = PHPUNIT_PATH_EXAMPLE . 'swaggerPetStoreHeroku.json';
        $this->genDocCompare();

        ob_end_clean();
    }

}
