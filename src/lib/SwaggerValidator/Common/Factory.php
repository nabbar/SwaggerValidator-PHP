<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Common;

/**
 * Description of Factory
 *
 * @author Nabbar
 */
class Factory extends \Swagger\Common\Collection
{

    /**
     *
     * @var \Swagger\Common\Factory
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
     * @return \Swagger\Common\Factory
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
    public static function setInstance(\Swagger\Common\Factory $instance)
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
        $collType = \Swagger\Common\CollectionType::getInstance();
        $class    = $collType->$type;

        if (empty($class)) {
            \Swagger\Exception::throwNewException('Cannot retrieve the callable for this type : ' . $type, __FILE__, __LINE__);
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
            $instance = $this->invoke($name);
        }

        return clone $instance;
    }

    /**
     *
     * @param string $type the object type who's contain the calling method
     * @param string $method the method name to be call
     * @param boolean $static specify is this method is static or intanced method
     * @param mixed $parameters [optional] Params to be passed to the method called
     * @return mixed
     * @throws Exception
     */
    public function call($type, $method, $static = false, $parameters = null)
    {
        $class = $this->getClass($type);

        $params = func_get_args();
        array_shift($params);
        array_shift($params);
        array_shift($params);

        if ($static === true) {
            return forward_static_call_array(array($class, $method), $params);
        }

        if (empty($method) || $method === '__construct') {
            return $this->invoke($type, $params);
        }

        return call_user_func_array(array($this->__get($type), $method), $params);
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
        return null;
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
        return \Swagger\Common\CollectionType::getInstance()->normalizeType($type);
    }

    /**
     * Register a new callable for a existing type
     * @param string $type must be defined in this class
     * @param callable $nameSpace must be callable
     */
    public static function registerType($type, $nameSpace)
    {
        $collType = \Swagger\Common\CollectionType::getInstance();
        $class    = $collType->normalizeType($type);

        return $collType->$class = $nameSpace;
    }

}
