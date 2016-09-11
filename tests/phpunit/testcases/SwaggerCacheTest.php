<?php

/*
 * Copyright 2016 Nicolas JUHEL<swaggervalidator@nabbar.com>.
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
 * Description of SwaggerCacheTest
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 */
class SwaggerCacheTest extends genericTestClass
{

    private $swaggerFileCache;

    public static function setUpBeforeClass()
    {
        $swaggerFileCache = PHPUNIT_PATH_TEMP . 'swaggerMultiFile.json.ser.tmp';

        if (file_exists($swaggerFileCache)) {
            unlink($swaggerFileCache);
        }

        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        $swaggerFileCache = PHPUNIT_PATH_TEMP . 'swaggerMultiFile.json.ser.tmp';

        if (file_exists($swaggerFileCache)) {
            unlink($swaggerFileCache);
        }
    }

    /**
     * @small
     */
    public function testCacheGenerate()
    {
        $time = time();

        $this->swaggerFileCache = PHPUNIT_PATH_TEMP . 'swaggerMultiFile.json.ser.tmp';
        $this->swaggerFilePath  = PHPUNIT_PATH_EXAMPLE . 'swaggerMultiFile.json';

        \SwaggerValidator\Swagger::cleanInstances();
        \SwaggerValidator\Swagger::setCachePath($this->swaggerFileCache);
        \SwaggerValidator\Swagger::setCacheLifeTime(0);
        \SwaggerValidator\Swagger::setSwaggerFile($this->swaggerFilePath);

        /**
         * Test generate cache file
         */
        $swaggerObject1 = \SwaggerValidator\Swagger::load($this->swaggerGetContext());

        $this->assertFileExists($this->swaggerFileCache);
        $this->assertGreaterThanOrEqual($time, filemtime($this->swaggerFileCache));

        $this->assertInternalType('object', $swaggerObject1);
        $this->assertInstanceOf('\SwaggerValidator\Object\Swagger', $swaggerObject1);

        $this->assertTrue(isset($swaggerObject1->swagger));
        $this->assertNotEmpty($swaggerObject1->swagger);

        $this->assertInternalType('string', $swaggerObject1->swagger);

        $this->assertTrue(isset($swaggerObject1->info));
        $this->assertNotEmpty($swaggerObject1->info);

        $this->assertInternalType('object', $swaggerObject1->info);
        $this->assertInstanceOf('\SwaggerValidator\Object\Info', $swaggerObject1->info);

        $this->assertTrue(isset($swaggerObject1->paths));
        $this->assertNotEmpty($swaggerObject1->paths);

        $this->assertInternalType('object', $swaggerObject1->paths);
        $this->assertInstanceOf('\SwaggerValidator\Object\Paths', $swaggerObject1->paths);

        $schemes = $swaggerObject1->schemes;
        if (!empty($schemes)) {
            $this->assertInternalType('array', $schemes);
            $this->scheme = array_shift($schemes);
        }

        $host = $swaggerObject1->host;
        if (!empty($host)) {
            $this->assertInternalType('string', $host);
            $this->host = $host;
        }

        $basepath = $swaggerObject1->basePath;
        if (!empty($basepath)) {
            $this->assertInternalType('string', $basepath);
            $this->basePath = $basepath;
        }
        if (substr($this->basePath, -1, 1) == '/') {
            $this->basePath = substr($this->basePath, 0, -1);
        }

        unset($swaggerObject1);

        /**
         * Test reaload cache file
         */
        sleep(3);
        $time = time();

        \SwaggerValidator\Swagger::cleanInstances();
        \SwaggerValidator\Swagger::setCachePath($this->swaggerFileCache);
        \SwaggerValidator\Swagger::setCacheLifeTime(0);
        $swaggerObject2 = \SwaggerValidator\Swagger::load($this->swaggerGetContext());

        $this->assertFileExists($this->swaggerFileCache);
        $this->assertLessThan($time, filemtime($this->swaggerFileCache));

        $this->assertInternalType('object', $swaggerObject2);
        $this->assertInstanceOf('\SwaggerValidator\Object\Swagger', $swaggerObject2);

        $this->assertTrue(isset($swaggerObject2->swagger));
        $this->assertNotEmpty($swaggerObject2->swagger);

        $this->assertInternalType('string', $swaggerObject2->swagger);

        $this->assertTrue(isset($swaggerObject2->info));
        $this->assertNotEmpty($swaggerObject2->info);

        $this->assertInternalType('object', $swaggerObject2->info);
        $this->assertInstanceOf('\SwaggerValidator\Object\Info', $swaggerObject2->info);

        $this->assertTrue(isset($swaggerObject2->paths));
        $this->assertNotEmpty($swaggerObject2->paths);

        $this->assertInternalType('object', $swaggerObject2->paths);
        $this->assertInstanceOf('\SwaggerValidator\Object\Paths', $swaggerObject2->paths);

        $schemes = $swaggerObject2->schemes;
        if (!empty($schemes)) {
            $this->assertInternalType('array', $schemes);
            $this->assertEquals($this->scheme, array_shift($schemes));
        }

        $host = $swaggerObject2->host;
        if (!empty($host)) {
            $this->assertInternalType('string', $host);
            $this->assertEquals($this->host, $host);
        }

        $basepath = $swaggerObject2->basePath;
        if (!empty($basepath)) {
            $this->assertInternalType('string', $basepath);

            if (substr($basepath, -1, 1) == '/') {
                $basepath = substr($basepath, 0, -1);
            }

            $this->assertEquals($this->basePath, $basepath);
        }

        unset($swaggerObject2);

        /**
         * Test forced regen cache file by cache lifetime
         */
        sleep(2);
        $time = time();
        sleep(1);

        \SwaggerValidator\Swagger::cleanInstances();
        \SwaggerValidator\Swagger::setCachePath($this->swaggerFileCache);
        \SwaggerValidator\Swagger::setCacheLifeTime(1);

        $swaggerObject3 = \SwaggerValidator\Swagger::load($this->swaggerGetContext());

        $this->assertFileExists($this->swaggerFileCache);
        $this->assertGreaterThan($time, filemtime($this->swaggerFileCache));

        $this->assertInternalType('object', $swaggerObject3);
        $this->assertInstanceOf('\SwaggerValidator\Object\Swagger', $swaggerObject3);

        $this->assertTrue(isset($swaggerObject3->swagger));
        $this->assertNotEmpty($swaggerObject3->swagger);

        $this->assertInternalType('string', $swaggerObject3->swagger);

        $this->assertTrue(isset($swaggerObject3->info));
        $this->assertNotEmpty($swaggerObject3->info);

        $this->assertInternalType('object', $swaggerObject3->info);
        $this->assertInstanceOf('\SwaggerValidator\Object\Info', $swaggerObject3->info);

        $this->assertTrue(isset($swaggerObject3->paths));
        $this->assertNotEmpty($swaggerObject3->paths);

        $this->assertInternalType('object', $swaggerObject3->paths);
        $this->assertInstanceOf('\SwaggerValidator\Object\Paths', $swaggerObject3->paths);

        $schemes = $swaggerObject3->schemes;
        if (!empty($schemes)) {
            $this->assertInternalType('array', $schemes);
            $this->assertEquals($this->scheme, array_shift($schemes));
        }

        $host = $swaggerObject3->host;
        if (!empty($host)) {
            $this->assertInternalType('string', $host);
            $this->assertEquals($this->host, $host);
        }

        $basepath = $swaggerObject3->basePath;
        if (!empty($basepath)) {
            $this->assertInternalType('string', $basepath);

            if (substr($basepath, -1, 1) == '/') {
                $basepath = substr($basepath, 0, -1);
            }

            $this->assertEquals($this->basePath, $basepath);
        }
    }

}
