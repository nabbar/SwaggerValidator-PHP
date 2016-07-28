<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Common;

/**
 * Description of ReferenceCollection
 *
 * @author Nabbar
 */
class CollectionReference extends \Swagger\Common\Collection
{

    const ID_PREFIX = 'id:';

    /**
     *
     * @var \Swagger\Common\CollectionReference
     */
    private static $instance;

    /**
     *
     * @var array
     */
    private static $refIdList = array();

    /**
     *
     * @var array
     */
    private static $refIdDefinitions = array();

    /**
     * Private construct for singleton
     */
    private function __construct()
    {

    }

    /**
     * get the singleton of this collection
     * @return \Swagger\Common\CollectionReference
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
    public static function setInstance(\Swagger\Common\CollectionReference $instance)
    {
        self::$instance  = $instance;
        self::$refIdList = array();
    }

    /**
     * prune the singleton of this collection
     */
    public static function prune()
    {
        self::$instance  = null;
        self::$refIdList = array();
    }

    public function __isset($ref)
    {
        parent::__isset(self::getIdFromRef($ref));
    }

    public function __unset($ref)
    {
        parent::__unset(self::getIdFromRef($ref));
    }

    public function __get($ref)
    {
        $id = self::getIdFromRef($ref);

        if (!is_object(parent::__get($id))) {
            $this->__set($ref);
        }

        \Swagger\Common\Context::logLoadRef(self::getRefFromId($id), __METHOD__, __LINE__);
        return parent::__get($id);
    }

    public function __set($ref, $value = null)
    {
        $id = self::getIdFromRef($ref);

        if ($id == $ref) {
            $ref = self::getRefFromId($id);
        }

        if (!is_object($value) || !($value instanceof \Swagger\Common\ReferenceItem)) {
            $link = \Swagger\Common\CollectionFile::getReferenceFileLink($ref);
            $fRef = \Swagger\Common\CollectionFile::getReferenceInnerPath($ref);
            $file = \Swagger\Common\CollectionFile::getInstance()->$link;

            if (!is_object($file) || !($file instanceof \Swagger\Common\ReferenceFile)) {
                \Swagger\Exception::throwNewException('Cannot retrieve contents for ref : ' . $ref, __FILE__, __LINE__);
            }

            $value = new \Swagger\Common\ReferenceItem($file->$fRef);
        }

        if (is_object($value) && ($value instanceof \Swagger\Common\ReferenceItem)) {
            /**
             * Register the item before cleanning ref, to prevent circular reference
             */
            parent::__set($id, $value);

            foreach ($value->extractAllReferences() as $oneRef) {
                $this->__get($oneRef);
            }

            return parent::__set($id, $value);
        }

        \Swagger\Exception::throwNewException('Cannot register item from ref : ' . $ref, __FILE__, __LINE__);
    }

    public function jsonSerialize()
    {
        $this->cleanReferenceDefinitions();

        $result = new \stdClass();

        foreach ($this->keys() as $key) {
            $result->$key = json_decode(\Swagger\Common\Collection::jsonEncode($this->$key->getObject(new \Swagger\Common\Context())));
        }

        $result->fullRealRef = array_flip(self::$refIdDefinitions);

        return $result;
    }

    public function serialize()
    {
        $this->cleanReferenceDefinitions();

        return serialize(array(
            self::$refIdList,
            parent::serialize(),
        ));
    }

    public function unserialize($data)
    {
        list(self::$refIdList, $col) = unserialize($data);

        self::$refIdDefinitions = self::$refIdList;
        parent::unserialize($col);
    }

    /**
     * Return the content of the reference as object or mixed data
     * @param string $ref
     * @return \Swagger\Common\ReferenceItem
     * @throws \Swagger\Exception
     */
    public function get($ref)
    {
        return $this->__get($ref);
    }

    public function set($ref, $value = null)
    {
        return $this->__set($ref, $value);
    }

    public static function getIdFromRef($fullRef)
    {
        if (!is_string($fullRef)) {
            print_r(debug_backtrace(null, 10));
            die();
        }

        if (substr($fullRef, 0, 3) === self::ID_PREFIX) {
            return $fullRef;
        }

        if (!is_array(self::$refIdList)) {
            self::$refIdList = array();
        }

        if (!array_key_exists($fullRef, self::$refIdList)) {
            //self::$refIdList[$fullRef] = uniqid(self::ID_PREFIX);
            self::$refIdList[$fullRef] = self::ID_PREFIX . hash('sha256', $fullRef, false);
        }

        return self::$refIdList[$fullRef];
    }

    public static function getRefFromId($id)
    {
        if (substr($id, 0, 3) !== self::ID_PREFIX) {
            return $id;
        }

        if (!is_array(self::$refIdList)) {
            self::$refIdList = array();
        }

        if (!in_array($id, self::$refIdList)) {
            return null;
        }

        return array_search($id, self::$refIdList);
    }

    public static function registerDefinition($fullRef = null)
    {
        if (substr($fullRef, 0, 3) === self::ID_PREFIX) {
            $id      = $fullRef;
            $fullRef = self::getRefFromId($id);
        }
        else {
            $id = self::getIdFromRef($fullRef);
        }

        if (!is_array(self::$refIdDefinitions)) {
            self::$refIdDefinitions = array();
        }

        if (!array_key_exists($fullRef, self::$refIdDefinitions)) {
            self::$refIdDefinitions[$fullRef] = $id;
        }
    }

    public function cleanReferenceDefinitions()
    {
        foreach ($this->keys() as $key) {
            if (!in_array($key, self::$refIdDefinitions)) {
                unset($this->$key);
            }
        }
        self::$refIdList = self::$refIdDefinitions;
    }

    public static function getDefinitions()
    {
        return self::$refIdDefinitions;
    }

    public function jsonUnSerialize(\Swagger\Common\Context $context)
    {
        foreach ($this->keys() as $key) {
            $this->$key->getObject($context->setExternalRef(self::getRefFromId($key)));
        }
    }

}