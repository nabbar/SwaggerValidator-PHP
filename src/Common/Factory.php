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
 * Description of Factory
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class Factory extends \SwaggerValidator\Common\Collection
{

    /**
     *
     * @var \SwaggerValidator\Common\Factory
     */
    private static $instance;

    /**
     * Private construct for singleton
     */
    private function __construct()
    {

    }

    /**
     * get the singleton of this collection
     * @return \SwaggerValidator\Common\Factory
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
    public static function setInstance(\SwaggerValidator\Common\Factory $instance)
    {
        self::$instance = $instance;
    }

    /**
     * prune the singleton of this collection
     */
    public static function pruneInstance()
    {
        self::$instance = null;
    }

    /**
     * Check if the type is defined and return his callable string
     * @param callable $type
     * @throws Exception
     */
    private function getClass($type)
    {
        $collType = \SwaggerValidator\Common\CollectionType::getInstance();
        $class    = $collType->get($type);

        if (empty($class)) {
            parent::throwException('Cannot retrieve the callable for this type : ' . $type, __FILE__, __LINE__);
        }

        return $class;
    }

    /**
     * return an instance of the given type
     * @param string $type
     * @return object
     */
    public function __get($type)
    {
        $class = $this->getClass($type);
        $name  = $this->normalizeType($type);

        if (parent::__isset($name)) {
            $instance = parent::__get($name);
        }
        else {
            $instance = $this->invoke($type);
        }

        return clone $instance;
    }

    /**
     * Start new instance of the object type
     * @param string $type the name of the object type for the new instance
     * @param type $parameters [optional] the parameters to the constructor
     * @return object
     * @throws Exception
     */
    public function invoke($type, $parameters = null)
    {
        $class = $this->getClass($type);
        $name  = $this->normalizeType($type);

        $params = func_get_args();
        array_shift($params);

        $reflector = new \ReflectionClass($class);
        $instance  = $reflector->newInstanceArgs($params);

        if (empty($params)) {
            parent::__set($name, $instance);
        }

        return (clone $instance);
    }

    /**
     * Register the base instance to be clone when a new instance is call
     * @param string $type
     * @param object|\Closure $object
     */
    public function __set($type, $object)
    {
        $class = $this->getClass($type);
        $name  = $this->normalizeType($type);

        if (is_object($object) || ($object instanceof \Closure)) {
            parent::__set($name, $object);
        }
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

    /**
     * return an instance of the given type
     * @param string $type
     * @return object
     */
    public function get($type)
    {
        return $this->__get($type);
    }

    /**
     * Register the base instance to be clone when a new instance is call
     * @param string $type
     * @param object|\Closure $object
     */
    public function set($type, $object)
    {
        return $this->__set($type, $object);
    }

    public function normalizeType($type)
    {
        return \SwaggerValidator\Common\CollectionType::getInstance()->normalizeType($type);
    }

}
