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
class SwaggerFaulsSmokeTest extends genericTestClass
{

    public function getTestCasesForRequest()
    {
        return array(
            array(
                'error'       => \SwaggerValidator\Common\Context::VALIDATION_TYPE_BASEPATH_ERROR,
                'basepath'    => '/error',
                'route'       => '/statuses/update',
                'method'      => 'post',
                'querystring' => array(
                    'status' => 'test',
                ),
                'headers'     => '',
                'postForm'    => '',
                'bodyRaw'     => '',
            ),
            array(
                'error'       => \SwaggerValidator\Common\Context::VALIDATION_TYPE_ROUTE_ERROR,
                'basepath'    => '/1.1',
                'route'       => '/test/me',
                'method'      => 'post',
                'querystring' => array(
                    'status' => 'test',
                ),
                'headers'     => '',
                'postForm'    => '',
                'bodyRaw'     => '',
            ),
            array(
                'error'       => \SwaggerValidator\Common\Context::VALIDATION_TYPE_METHOD_ERROR,
                'basepath'    => '/1.1',
                'route'       => '/statuses/update',
                'method'      => 'get',
                'querystring' => array(
                    'status' => 'test',
                ),
                'headers'     => '',
                'postForm'    => '',
                'bodyRaw'     => '',
            ),
            array(
                'error'       => \SwaggerValidator\Common\Context::VALIDATION_TYPE_NOTFOUND,
                'basepath'    => '/1.1',
                'route'       => '/statuses/update',
                'method'      => 'post',
                'querystring' => array(
                    'query' => 'false'
                ),
                'headers'     => '',
                'postForm'    => '',
                'bodyRaw'     => '',
            ),
            array(
                'error'       => \SwaggerValidator\Common\Context::VALIDATION_TYPE_TOOMANY,
                'basepath'    => '/1.1',
                'route'       => '/statuses/update',
                'method'      => 'post',
                'querystring' => array(
                    'status' => 'test',
                    'query'  => 'false'
                ),
                'headers'     => '',
                'postForm'    => '',
                'bodyRaw'     => '',
            ),
            array(
                'error'       => \SwaggerValidator\Common\Context::VALIDATION_TYPE_TOOMANY,
                'basepath'    => '/1.1',
                'route'       => '/statuses/update',
                'method'      => 'post',
                'querystring' => array(
                    'status' => 'test',
                ),
                'headers'     => '',
                'postForm'    => array(
                    'postForm' => false,
                ),
                'bodyRaw'     => '',
            ),
            array(
                'error'       => \SwaggerValidator\Common\Context::VALIDATION_TYPE_TOOMANY,
                'basepath'    => '/1.1',
                'route'       => '/statuses/update',
                'method'      => 'post',
                'querystring' => array(
                    'status' => 'test',
                ),
                'headers'     => '',
                'postForm'    => '',
                'bodyRaw'     => '{"body":"error"}',
            ),
        );
    }

    /**
     *
     * @dataProvider getTestCasesForRequest
     * @small
     */
    public function testSmokeFaulsModelRequest($expected, $basepath, $route, $method, $querystring, $headers, $postForm, $bodyRaw)
    {
        if (version_compare(PHP_VERSION, "5.4", "<")) {
            $querystring = '?' . http_build_query($querystring, null, '&');
        }
        else {
            $querystring = '?' . http_build_query($querystring, null, '&', PHP_QUERY_RFC3986);
        }

        $this->swaggerFilePath = PHPUNIT_PATH_EXAMPLE . 'swaggerTwitter.json';
        $this->swaggerBuild();
        $this->loadModel();

        $this->assertInternalType('object', $this->swaggerObject);
        $this->assertInternalType('array', $this->swaggerModel);
        $this->assertGreaterThan(0, count($this->swaggerModel));

        $this->basePath = $basepath;

        $context = $this->mockContextRequest($route, $querystring, $method, $headers, $bodyRaw, $postForm);
        $context->setMode(\SwaggerValidator\Common\Context::MODE_DENY);

        try {
            $this->swaggerObject->validate($context);
        }
        catch (\SwaggerValidator\Exception $exc) {
            $error = $exc->getContext();

            $this->assertInternalType('object', $error);
            $this->assertInstanceOf('\SwaggerValidator\Common\Context', $error);
            $this->assertEquals($expected, $error->getValidationErrorCode());
        }
    }

    public function getTestCasesForResponse()
    {
        $contributor              = new \stdClass();
        $contributor->id          = 234;
        $contributor->id_str      = '234';
        $contributor->screen_name = 'test';

        $responseModel                 = new \stdClass();
        $responseModel->contributors   = array($contributor);
        $responseModel->favorite_count = 5643;
        $responseModel->favorited      = false;
        $responseModel->filter_level   = 'test';
        $responseModel->id             = 112;
        $responseModel->id_str         = 'id_str';

        $responseTooMany1            = $responseModel;
        $contributor->tooMany        = true;
        $responseModel->contributors = array($contributor);

        $responseTooMany2          = $responseModel;
        $responseTooMany2->tooMany = true;

        return array(
            array(
                'error'    => \SwaggerValidator\Common\Context::VALIDATION_TYPE_BASEPATH_ERROR,
                'basepath' => '/error',
                'route'    => '/statuses/update',
                'method'   => 'post',
                'status'   => 200,
                'headers'  => array(),
                'bodyRaw'  => $responseModel,
            ),
            array(
                'error'    => \SwaggerValidator\Common\Context::VALIDATION_TYPE_ROUTE_ERROR,
                'basepath' => '/1.1',
                'route'    => '/test/me',
                'method'   => 'post',
                'status'   => 200,
                'headers'  => array(),
                'bodyRaw'  => $responseModel,
            ),
            array(
                'error'    => \SwaggerValidator\Common\Context::VALIDATION_TYPE_METHOD_ERROR,
                'basepath' => '/1.1',
                'route'    => '/statuses/update',
                'method'   => 'get',
                'status'   => 200,
                'headers'  => array(),
                'bodyRaw'  => $responseModel,
            ),
            array(
                'error'    => \SwaggerValidator\Common\Context::VALIDATION_TYPE_RESPONSE_ERROR,
                'basepath' => '/1.1',
                'route'    => '/statuses/update',
                'method'   => 'post',
                'status'   => 'error',
                'headers'  => array(),
                'bodyRaw'  => $responseTooMany2,
            ),
            array(
                'error'    => \SwaggerValidator\Common\Context::VALIDATION_TYPE_NOTFOUND,
                'basepath' => '/1.1',
                'route'    => '/statuses/update',
                'method'   => 'post',
                'status'   => 200,
                'headers'  => array(
                    'header' => 'false',
                ),
                'bodyRaw'  => $responseModel,
            ),
            array(
                'error'    => \SwaggerValidator\Common\Context::VALIDATION_TYPE_TOOMANY,
                'basepath' => '/1.1',
                'route'    => '/statuses/update',
                'method'   => 'post',
                'status'   => 200,
                'headers'  => array(),
                'bodyRaw'  => $responseTooMany1,
            ),
            array(
                'error'    => \SwaggerValidator\Common\Context::VALIDATION_TYPE_TOOMANY,
                'basepath' => '/1.1',
                'route'    => '/statuses/update',
                'method'   => 'post',
                'status'   => 200,
                'headers'  => array(),
                'bodyRaw'  => $responseTooMany2,
            ),
        );
    }

    /**
     *
     * @dataProvider getTestCasesForResponse
     * @small
     */
    public function testSmokeFaulsModelResponse($expected, $basepath, $route, $method, $status, $headers, $bodyRaw)
    {
        $this->swaggerFilePath = PHPUNIT_PATH_EXAMPLE . 'swaggerTwitter.json';
        $this->swaggerBuild();
        $this->loadModel();

        $this->assertInternalType('object', $this->swaggerObject);
        $this->assertInternalType('array', $this->swaggerModel);
        $this->assertGreaterThan(0, count($this->swaggerModel));

        $this->basePath                = $basepath;
        $headers["http_response_code"] = $status;

        $context = $this->mockContextResponse($route, $method, $headers, $bodyRaw);
        $context->setMode(\SwaggerValidator\Common\Context::MODE_DENY);

        try {
            $this->swaggerObject->validate($context);
        }
        catch (\SwaggerValidator\Exception $exc) {
            $error = $exc->getContext();

            $this->assertInternalType('object', $error);
            $this->assertInstanceOf('\SwaggerValidator\Common\Context', $error);
            $this->assertEquals($expected, $error->getValidationErrorCode());
        }
    }

}
