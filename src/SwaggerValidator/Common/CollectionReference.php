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
 * Description of ReferenceCollection
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class CollectionReference extends \SwaggerValidator\Common\Collection
{

    const ID_PREFIX = 'id:';

    /**
     *
     * @var \SwaggerValidator\Common\CollectionReference
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
     * @return \SwaggerValidator\Common\CollectionReference
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
    public static function setInstance(\SwaggerValidator\Common\CollectionReference $instance)
    {
        self::$instance  = $instance;
        self::$refIdList = array();
    }

    /**
     * prune the singleton of this collection
     */
    public static function prune()
    {
        self::$instance         = null;
        self::$refIdList        = array();
        self::$refIdDefinitions = array();
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

        \SwaggerValidator\Common\Context::logLoadRef(self::getRefFromId($id), __METHOD__, __LINE__);
        return parent::__get($id);
    }

    public function __set($ref, $value = null)
    {
        $id = self::getIdFromRef($ref);

        if ($id == $ref) {
            $ref = self::getRefFromId($id);
        }

        if (!is_object($value) || !($value instanceof \SwaggerValidator\Common\ReferenceItem)) {
            $link = \SwaggerValidator\Common\CollectionFile::getReferenceFileLink($ref);
            $fRef = \SwaggerValidator\Common\CollectionFile::getReferenceInnerPath($ref);
            $file = \SwaggerValidator\Common\CollectionFile::getInstance()->$link;

            if (!is_object($file) || !($file instanceof \SwaggerValidator\Common\ReferenceFile)) {
                \SwaggerValidator\Exception::throwNewException('Cannot retrieve contents for ref : ' . $ref, "", __FILE__, __LINE__);
            }

            $value = new \SwaggerValidator\Common\ReferenceItem($file->$fRef);
        }

        if (is_object($value) && ($value instanceof \SwaggerValidator\Common\ReferenceItem)) {
            /**
             * Register the item before cleanning ref, to prevent circular reference
             */
            parent::__set($id, $value);

            foreach ($value->extractAllReferences() as $oneRef) {
                $this->__get($oneRef);
            }

            return parent::__set($id, $value);
        }

        \SwaggerValidator\Exception::throwNewException('Cannot register item from ref : ' . $ref, "", __FILE__, __LINE__);
    }

    public function jsonSerialize()
    {
        $result = new \stdClass();

        foreach (parent::keys() as $key) {
            $name          = str_replace(':', '', $key);
            $result->$name = json_decode(\SwaggerValidator\Common\Collection::jsonEncode(parent::__get($key)->getObject(new \SwaggerValidator\Common\Context())));
        }

        //$result->fullRealRef = array_flip(self::$refIdDefinitions);

        return $result;
    }

    public function serialize()
    {
        return serialize(get_object_vars($this));
    }

    public function unserialize($data)
    {
        self::getInstance();
        $base = $data;

        if (!is_array($data)) {
            $data = unserialize($data);
        }

        if (!is_array($data)) {
            \SwaggerValidator\Exception::throwNewException('Cannot unserialize object ! ', array($base, $data), __FILE__, __LINE__);
        }

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Return the content of the reference as object or mixed data
     * @param string $ref
     * @return \SwaggerValidator\Common\ReferenceItem
     * @throws \SwaggerValidator\Exception
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
            \SwaggerValidator\Exception::throwNewException('Cannot load an non string fullRef !', $fullRef, __METHOD__, __LINE__);
        }

        if (strlen($fullRef) < 1) {
            \SwaggerValidator\Exception::throwNewException('Cannot load an empty fullRef !', $fullRef, __METHOD__, __LINE__);
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
        foreach (parent::keys() as $key) {
            if (!in_array($key, self::$refIdDefinitions)) {
                //\SwaggerValidator\Common\Context::logDebug('Drop Ref : ' . $key, __METHOD__, __LINE__);
                parent::__unset($key);
            }
        }
        self::$refIdList = self::$refIdDefinitions;
    }

    public function unserializeReferenceDefinitions(\SwaggerValidator\Common\Context $context)
    {
        foreach (parent::keys() as $key) {
            if (in_array($key, self::$refIdDefinitions)) {
                parent::__get($key)->getObject($context->setExternalRef(self::getRefFromId($key)));
            }
        }
    }

    public static function getDefinitions()
    {
        return self::$refIdDefinitions;
    }

    public function jsonUnSerialize(\SwaggerValidator\Common\Context $context)
    {
        foreach (parent::keys() as $key) {
            parent::__get($key)->getObject($context->setExternalRef(self::getRefFromId($key)));
        }
    }

}
