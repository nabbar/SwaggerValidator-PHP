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

namespace SwaggerValidator\Common;

/**
 * Description of ReferenceFile
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class ReferenceFile
{

    const PATH_TYPE_URL  = 1;
    const PATH_TYPE_FILE = 2;

    private $fileUri;
    private $fileObj;
    private $fileTime;
    private $fileHash;
    private $basePath;
    private $baseType;

    public function __construct($filepath)
    {
        $this->fileUri = $filepath;

        $scheme = parse_url($filepath, PHP_URL_SCHEME);

        if (strtolower($scheme) == 'file' || $scheme === null || file_exists($filepath)) {
            $this->baseType = self::PATH_TYPE_FILE;
            $this->basePath = realpath(dirname($filepath));

            if (substr($this->basePath, -1, 1) != DIRECTORY_SEPARATOR) {
                $this->basePath .= DIRECTORY_SEPARATOR;
            }
        }
        elseif ($scheme !== false) {
            $this->baseType = self::PATH_TYPE_URL;

            $part         = parse_url($filepath);
            $part['path'] = dirname($part['path']);

            $this->basePath = $part['scheme'] . '://';

            if (!empty($part['user']) || !empty($part['pass'])) {
                $this->basePath .= $part['user'] . ':' . $part['pass'] . '@' . $part['host'];
            }
            else {
                $this->basePath .= $part['host'];
            }

            if (!empty($part['port'])) {
                $this->basePath .= ':' . $part['port'];
            }

            $this->basePath .= $part['path'];
        }
        else {
            \SwaggerValidator\Exception::throwNewException('Pathtype not well formatted : ' . $filepath, __FILE__, __LINE__);
        }

        $contents = file_get_contents($this->fileUri);

        if (empty($contents)) {
            \SwaggerValidator\Exception::throwNewException('Cannot read contents for file : ' . $filepath, __FILE__, __LINE__);
        }

        $this->fileTime = $this->getFileTime();
        $this->fileHash = hash('SHA512', $contents . '#' . $this->fileTime, true);
        $this->fileObj  = json_decode($contents, false);

        if (empty($this->fileObj)) {
            \SwaggerValidator\Exception::throwNewException('Cannot decode contents for file : ' . $filepath, __FILE__, __LINE__);
        }

        \SwaggerValidator\Common\Context::logLoadFile($this->fileUri, __METHOD__, __LINE__);
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return $this->getReference($name);
    }

    public function getFileTime()
    {
        if ($this->baseType !== self::PATH_TYPE_URL) {
            return filemtime($this->fileUri);
        }

        $curl = curl_init($this->fileUri);

        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FILETIME, true);

        $result = curl_exec($curl);

        if ($result === false) {
            die(curl_error($curl));
        }

        $timestamp = curl_getinfo($curl, CURLINFO_FILETIME);

        curl_close($curl);

        if ($timestamp != -1) {
            return $timestamp;
        }

        return time();
    }

    public function getReference($ref)
    {
        $obj            = $this->fileObj;
        $propertiesList = explode('/', $ref);
        array_shift($propertiesList);

        foreach ($propertiesList as $property) {

            if (empty($property)) {
                continue;
            }

            if (empty($obj)) {
                $this->throwNewException('Cannot find property "' . $property . '" from ref : ' . $this->fileUri . '#/' . $ref, __FILE__, __LINE__);
            }

            if (is_object($obj) && isset($obj->$property)) {
                $obj = $obj->$property;
            }
            elseif (is_array($obj) && isset($obj[$property])) {
                $obj = $obj[$property];
            }
            else {
                $this->throwNewException('Cannot find property "' . $property . '" from ref : ' . $this->fileUri . '#/' . $ref, __FILE__, __LINE__);
            }
        }

        return $obj;
    }

    public function extractAllReference()
    {
        $refList = array();

        if (is_object($this->fileObj)) {
            $refList = $this->extractReferenceObject($this->fileObj);
        }
        elseif (is_array($this->fileObj)) {
            $refList = $this->extractReferenceArray($this->fileObj);
        }

        return array_unique($refList);
    }

    private function extractReferenceArray(array &$array)
    {
        $refList = array();

        foreach ($array as $key => $value) {
            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) {
                $ref       = $this->getCanonical($value);
                $refList[] = $ref;

                \SwaggerValidator\Common\Context::logReplaceRef($value, $ref[0], __METHOD__, __LINE__);

                $value = $ref[0];
            }
            elseif (is_array($value)) {
                $refList = $refList + $this->extractReferenceArray($value);
            }
            elseif (is_object($value)) {
                $refList = $refList + $this->extractReferenceObject($value);
            }
            else {
                continue;
            }

            $array[$key] = $value;
        }

        return $refList;
    }

    private function extractReferenceObject(\stdClass &$stdClass)
    {
        $refList = array();

        foreach (get_object_vars($stdClass) as $key => $value) {
            if ($key === \SwaggerValidator\Common\FactorySwagger::KEY_REFERENCE) {
                $ref       = $this->getCanonical($value);
                $refList[] = $ref;

                \SwaggerValidator\Common\Context::logReplaceRef($value, $ref[0], __METHOD__, __LINE__);

                $value = $ref[0];
            }
            elseif (is_array($value)) {
                $refList = $refList + $this->extractReferenceArray($value);
            }
            elseif (is_object($value)) {
                $refList = $refList + $this->extractReferenceObject($value);
            }
            else {
                continue;
            }

            $stdClass->$key = $value;
        }

        return $refList;
    }

    public function getCanonical($fullRef)
    {
        $fileLink = \SwaggerValidator\Common\CollectionFile::getReferenceFileLink($fullRef);
        $innerRef = \SwaggerValidator\Common\CollectionFile::getReferenceInnerPath($fullRef);

        if (!empty($fileLink)) {
            $fileLink = $this->getFileLink($fileLink);
        }
        else {
            $fileLink = $this->fileUri;
        }

        if (!empty($innerRef)) {
            $innerRef = str_replace('//', '/', $innerRef);
        }
        else {
            $innerRef = '/';
        }

        return array(
            $fileLink . '#' . $innerRef,
            $fileLink,
            $innerRef
        );
    }

    private function getFileLink($uri)
    {
        $scheme = parse_url($uri, PHP_URL_SCHEME);

        if (strtolower($scheme) == 'file') {
            return $this->getFilePath(urldecode(substr($uri, 7)));
        }

        if ($this->baseType !== self::PATH_TYPE_URL) {

            if ($scheme === false || $scheme === null) {
                return $this->getFilePath($uri);
            }
            else {
                return $this->getUrlLink($this->basePath . $uri);
            }
        }
        else {
            return $this->getUrlLink($this->basePath . $uri);
        }
    }

    private function getFilePath($filepath)
    {
        $filepath = str_replace('/', DIRECTORY_SEPARATOR, $filepath);

        if (substr($filepath, 0, 1) == DIRECTORY_SEPARATOR) {
            $filepath = substr($filepath, 1);
        }

        if (file_exists($this->basePath . $filepath)) {
            return realpath($this->basePath . $filepath);
        }
        else {
            \SwaggerValidator\Exception::throwNewException('Cannot load file from ref : ' . $filepath, __FILE__, __LINE__);
        }

        return false;
    }

    private function getUrlLink($url)
    {
        $address = explode('/', $this->basePath . $url);
        $keys    = array_keys($address, '..');

        foreach ($keys AS $keypos => $key) {
            array_splice($address, $key - ($keypos * 2 + 1), 2);
        }

        return str_replace('./', '', implode('/', $address));
    }

}
