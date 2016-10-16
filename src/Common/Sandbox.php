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

namespace SwaggerValidator\Common;

/**
 * Description of Sandbox
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 */
class Sandbox
{

    /**
     *
     * @var string
     */
    private $body;

    /**
     *
     * @var \SwaggerValidator\Common\SandBoxItem
     */
    private $form;

    /**
     *
     * @var \SwaggerValidator\Common\SandBoxItem
     */
    private $header;

    /**
     *
     * @var \SwaggerValidator\Common\SandBoxItem
     */
    private $query;

    /**
     *
     * @var \SwaggerValidator\Common\SandBoxItem
     */
    private $path;

    /**
     *
     * @var \SwaggerValidator\Common\Sandbox
     */
    private static $instance;

    /**
     * Private construct for singleton
     */
    private function __construct()
    {
        $this->body   = null;
        $this->form   = new \SwaggerValidator\Common\SandBoxItem();
        $this->header = new \SwaggerValidator\Common\SandBoxItem();
        $this->path   = new \SwaggerValidator\Common\SandBoxItem();
        $this->query  = new \SwaggerValidator\Common\SandBoxItem();
    }

    /**
     *
     * @return \SwaggerValidator\Common\Sandbox
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * replace the singleton of this collection
     */
    public static function setInstance(\SwaggerValidator\Common\Sandbox $instance)
    {
        self::$instance = $instance;
    }

    public static function pruneInstance()
    {
        self::$instance = null;
    }

    public function __isset($name)
    {
        return false;
    }

    public function __unset($name)
    {
        return false;
    }

    /**
     * Var Export Method
     */
    protected function __storeData($key, $value = null)
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
        else {
            parent::__storeData($key, $value);
        }
    }

    public static function __set_state(array $properties)
    {
        $obj = new static;

        foreach ($properties as $key => $value) {
            $obj->__storeData($key, $value);
        }

        return $obj;
    }

    /**
     * Return the content of the reference as object or mixed data
     * @param string $fileLink
     * @return \SwaggerValidator\Common\ReferenceFile
     * @throws \SwaggerValidator\Exception
     */
    public function __get($name)
    {
        return false;
    }

    public function __set($name, $value = null)
    {
        return false;
    }

    public function jsonSerialize()
    {

    }

    public function serialize()
    {

    }

    public function unserialize($data)
    {

    }

    public function hasBody()
    {
        return ($this->body !== null);
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($value = null)
    {
        return $this->body = $value;
    }

    public function hasForm($name)
    {
        return $this->form->has($name);
    }

    public function keysForm()
    {
        return $this->form->keys();
    }

    public function getForm($name)
    {
        return $this->form->get($name);
    }

    public function setForm($name, $value = null)
    {
        return $this->form->set($name, $value);
    }

    public function hasHeader($name)
    {
        return $this->header->has($name);
    }

    public function keysHeader()
    {
        return $this->header->keys();
    }

    public function getHeader($name)
    {
        return $this->header->get($name);
    }

    public function setHeader($name, $value = null)
    {
        return $this->header->set($name, $value);
    }

    public function hasPath($name)
    {
        return $this->path->has($name);
    }

    public function keysPath()
    {
        return $this->path->keys();
    }

    public function getPath($name)
    {
        return $this->path->get($name);
    }

    public function setPath($name, $value = null)
    {
        return $this->path->set($name, $value);
    }

    public function hasQueryString($name)
    {
        return $this->query->has($name);
    }

    public function keysQueryString()
    {
        return $this->query->keys();
    }

    public function getQueryString($name)
    {
        return $this->query->get($name);
    }

    public function setQueryString($name, $value = null)
    {
        return $this->query->set($name, $value);
    }

}
