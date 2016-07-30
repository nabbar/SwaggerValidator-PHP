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
 * Description of Collection
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
abstract class Collection implements \Countable, \IteratorAggregate, \ArrayAccess, \Serializable, \JsonSerializable
{

    /**
     *
     * @var array
     */
    private $collection = array();

    /**
     *
     * @var boolean
     */
    protected $originTypeArray = false;

    /**
     * Property Overloading
     */
    public function __isset($key)
    {
        return array_key_exists($key, $this->collection);
    }

    public function __get($key)
    {
        if (!array_key_exists($key, $this->collection)) {
            return;
        }

        $args = func_get_args();
        array_shift($args);

        $obj = $this->collection[$key];

        if (count($args) > 0 && (is_object($obj) || is_callable($obj))) {
            return call_user_func($obj, $args);
        }

        return $obj;
    }

    public function __set($key, $value)
    {
        if (strlen($key) > 0) {
            $this->collection[$key] = $value;
        }
    }

    public function __unset($key)
    {
        if (array_key_exists($key, $this->collection)) {
            unset($this->collection[$key]);
        }
    }

    /**
     * Array Access
     */
    public function offsetSet($key, $value)
    {
        return $this->__set($key, $value);
    }

    public function offsetExists($key)
    {
        return $this->__isset($key);
    }

    public function offsetUnset($key)
    {
        return $this->__unset($key);
    }

    public function offsetGet($key)
    {
        return $this->__get($key);
    }

    /**
     * IteratorAggregate
     */
    public function getIterator()
    {
        return new \ArrayIterator($this);
    }

    /**
     * Countable
     */
    public function count()
    {
        return count($this->collection);
    }

    protected function setJSONIsArray()
    {
        $this->originTypeArray = true;
    }

    public function jsonSerialize()
    {
        if ($this->originTypeArray === true) {
            $result = array();
        }
        else {
            $result = new \stdClass();
        }

        foreach (array_keys($this->collection) as $key) {
            $value = json_decode(self::jsonEncode($this->collection[$key]));

            if ($this->originTypeArray === true) {
                $result[] = $value;
            }
            else {
                $result->$key = $value;
            }
        }

        return $result;
    }

    public function serialize()
    {
        return serialize($this->collection);
    }

    public function unserialize($data)
    {
        $this->collection = unserialize($data);
    }

    /**
     * Fetch set data
     * @return array This set's key-value data array
     */
    public function all()
    {
        return $this->collection;
    }

    /**
     * Fetch set data keys
     * @return array This set's key-value data array keys
     */
    public function keys()
    {
        return array_keys($this->collection);
    }

    /**
     * Does this set contain a key?
     * @param  string  $key The data key
     * @return boolean
     */
    public function has($key)
    {
        return $this->__isset($key);
    }

    /**
     * Remove value with key from this set
     * @param  string $key The data key
     */
    public function remove($key)
    {
        $this->__unset($key);
    }

    /**
     * Clear all values
     */
    public function clear()
    {
        $this->collection = array();
    }

    public static function jsonEncode($mixed)
    {
        //return json_encode($mixed, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        return json_encode($mixed, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public static function jsonEncodePretty($mixed)
    {
        return json_encode($mixed, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

}
