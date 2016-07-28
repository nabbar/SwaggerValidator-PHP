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
class CollectionFile extends \Swagger\Common\Collection
{

    const ID_PREFIX = 'file:';

    /**
     *
     * @var \Swagger\Common\CollectionFile
     */
    private static $instance;

    /**
     *
     * @var array
     */
    private static $fileIdList = array();

    /**
     * Private construct for singleton
     */
    private function __construct()
    {

    }

    /**
     *
     * @return \Swagger\Common\CollectionFile
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
    public static function setInstance(\Swagger\Common\CollectionFile $instance)
    {
        self::$instance   = $instance;
        self::$fileIdList = array();
    }

    public static function prune()
    {
        self::$instance   = null;
        self::$fileIdList = array();
    }

    public function __isset($ref)
    {
        parent::__isset(self::getIdFromRef($ref));
    }

    public function __unset($ref)
    {
        parent::__unset(self::getIdFromRef($ref));
    }

    /**
     * Return the content of the reference as object or mixed data
     * @param string $fileLink
     * @return \Swagger\Common\ReferenceFile
     * @throws \Swagger\Exception
     */
    public function __get($fileLink)
    {
        if (empty($fileLink)) {
            \Swagger\Exception::throwNewException('Cannot find file link from ref : ' . $fileLink, __FILE__, __LINE__);
        }

        $id = self::getIdFromRef($fileLink);

        if (!is_object(parent::__get($id))) {
            $this->__set($fileLink);
        }

        \Swagger\Common\Context::logLoadFile(self::getRefFromId($id), __METHOD__, __LINE__);

        return parent::__get($id);
    }

    public function __set($ref, $value = null)
    {
        $id = self::getIdFromRef($ref);

        if ($id == $ref) {
            $ref = self::getRefFromId($id);
        }

        if (!is_object($value) || !($value instanceof \Swagger\Common\ReferenceFile)) {
            $value = new \Swagger\Common\ReferenceFile($ref);
        }

        if (is_object($value) && ($value instanceof \Swagger\Common\ReferenceFile)) {
            $value->extractAllReference();
            return parent::__set($id, $value);
        }

        \Swagger\Exception::throwNewException('Cannot register file from ref : ' . $ref, __FILE__, __LINE__);
    }

    public function jsonSerialize()
    {
        return null;
    }

    public function serialize()
    {
        return null;
    }

    public function unserialize($data)
    {
        return null;
    }

    /**
     * Return the content of the reference as object or mixed data
     * @param string $fileLink
     * @return \Swagger\Common\ReferenceFile
     * @throws \Swagger\Exception
     */
    public function get($fileLink)
    {
        return $this->__get($fileLink);
    }

    public function set($ref, $value = null)
    {
        return $this->__set($ref, $value);
    }

    public static function getReferenceFileLink($ref)
    {
        if (strpos($ref, '#') === false) {
            return $ref;
        }

        $fileLink = explode('#', $ref);
        array_pop($fileLink);
        return implode('#', $fileLink);
    }

    public static function getReferenceInnerPath($ref)
    {
        if (strpos($ref, '#') === false) {
            return;
        }

        $fileLink = explode('#', $ref);
        return array_pop($fileLink);
    }

    public static function getIdFromRef($fullRef)
    {
        if (substr($fullRef, 0, 3) === self::ID_PREFIX) {
            return $fullRef;
        }

        if (!is_array(self::$fileIdList)) {
            self::$fileIdList = array();
        }

        if (!array_key_exists($fullRef, self::$fileIdList)) {
            //self::$fileIdList[$fullRef] = uniqid(self::ID_PREFIX);
            self::$fileIdList[$fullRef] = self::ID_PREFIX . hash('sha256', $fullRef, false);
        }

        return self::$fileIdList[$fullRef];
    }

    public static function getRefFromId($id)
    {
        if (substr($id, 0, 3) !== self::ID_PREFIX) {
            return $id;
        }

        if (!is_array(self::$fileIdList)) {
            self::$fileIdList = array();
        }

        if (!in_array($id, self::$fileIdList)) {
            return null;
        }

        return array_search($id, self::$fileIdList);
    }

}
