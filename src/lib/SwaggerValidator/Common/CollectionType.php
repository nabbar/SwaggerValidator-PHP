<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Common;

/**
 * Description of CollectionType
 *
 * @author Nabbar
 */
class CollectionType extends \Swagger\Common\Collection
{

    /**
     * Helpers
     */
    const IOHelper  = '\\Swagger\\CustomIOHelper';
    const Exception = '\\Swagger\\Exception';

    /**
     * Swagger Standard Objects
     */
    const Swagger             = '\\Swagger\\Object\\Swagger';
    const Contact             = '\\Swagger\\Object\\Contact';
    const Definitions         = '\\Swagger\\Object\\Definitions';
    const ExternalDocs        = '\\Swagger\\Object\\ExternalDocs';
    const HeaderItem          = '\\Swagger\\Object\\HeaderItem';
    const Headers             = '\\Swagger\\Object\\Headers';
    const Info                = '\\Swagger\\Object\\Info';
    const Reference           = '\\Swagger\\Object\\Reference';
    const License             = '\\Swagger\\Object\\License';
    const Operation           = '\\Swagger\\Object\\Operation';
    const ParameterBody       = '\\Swagger\\Object\\ParameterBody';
    const Parameters          = '\\Swagger\\Object\\Parameters';
    const PathItem            = '\\Swagger\\Object\\PathItem';
    const Paths               = '\\Swagger\\Object\\Paths';
    const ResponseItem        = '\\Swagger\\Object\\ResponseItem';
    const Responses           = '\\Swagger\\Object\\Responses';
    const Security            = '\\Swagger\\Object\\Security';
    const SecurityItem        = '\\Swagger\\Object\\SecurityItem';
    const SecurityDefinitions = '\\Swagger\\Object\\SecurityDefinitions';
    const SecurityRequirement = '\\Swagger\\Object\\SecurityRequirement';

    /**
     * Swagger Primitive Datatype Object
     */
    const TypeArray            = '\\Swagger\\DataType\\TypeArray';
    const TypeArrayItems       = '\\Swagger\\DataType\\TypeArrayItems';
    const TypeBoolean          = '\\Swagger\\DataType\\TypeBoolean';
    const TypeCombined         = '\\Swagger\\DataType\\TypeCombined';
    const TypeFile             = '\\Swagger\\DataType\\TypeFile';
    const TypeInteger          = '\\Swagger\\DataType\\TypeInteger';
    const TypeNumber           = '\\Swagger\\DataType\\TypeNumber';
    const TypeObject           = '\\Swagger\\DataType\\TypeObject';
    const TypeObjectProperties = '\\Swagger\\DataType\\TypeObject';
    const TypeString           = '\\Swagger\\DataType\\TypeString';

    /**
     * Security Definition Object
     */
    const ApiKeySecurity               = '\\Swagger\\Security\\ApiKeySecurity';
    const BasicAuthenticationSecurity  = '\\Swagger\\Security\\BasicAuthenticationSecurity';
    const OAuth2AccessCodeSecurity     = '\\Swagger\\Security\\OAuth2AccessCodeSecurity';
    const OAuth2ApplicationSecurity    = '\\Swagger\\Security\\OAuth2ApplicationSecurity';
    const OAuth2ImplicitSecurity       = '\\Swagger\\Security\\OAuth2ImplicitSecurity';
    const OAuth2PasswordSecurity       = '\\Swagger\\Security\\OAuth2PasswordSecurity';
    const OAuth2PasswordSecurityScopes = '\\Swagger\\Security\\OAuth2PasswordSecurityScopes';

    /**
     *
     * @var \Swagger\Common\CollectionType
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
     * @return \Swagger\Common\CollectionType
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
    public static function setInstance(\Swagger\Common\CollectionType $instance)
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
     * Return the callable string for the given type
     * @param string $type
     * @return callable
     */
    public function __get($type)
    {
        if (!$this->__isset($type)) {
            return;
        }

        if (parent::__isset($type)) {
            return parent::__get($type);
        }

        if (defined($this->normalizeType($type))) {
            return constant($this->normalizeType($type));
        }

        return null;
    }

    /**
     * Replace the default callable string by the given for the type in parameters
     * @param string $type
     * @param callable $callable
     */
    public function __set($type, $callable)
    {
        if ($this->__isset($type) && is_callable($callable)) {
            parent::__set($this->normalizeKey($type), $callable);
        }
    }

    public function __isset($type)
    {
        return defined($this->normalizeType($type));
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
     * Return the callable string for the given type
     * @param string $type
     * @return callable
     */
    public function get($type)
    {
        return $this->__get($type);
    }

    /**
     * Replace the default callable string by the given for the type in parameters
     * @param string $type
     * @param callable $callable
     */
    public function set($type, $callable)
    {
        return $this->__set($type, $callable);
    }

    public function normalizeType($type)
    {
        $type = str_replace(__CLASS__, 'self::', $type);
        $type = str_replace(__NAMESPACE__, '', $type);

        if (stripos($type, 'self::') === false) {
            $type = 'self::' . $type;
        }

        return $type;
    }

    public function normalizeKey($key)
    {
        $ready = str_replace(array(' ', '-', '_', '/', '|', '#', '$', '.', ',', ';', ':'), ' ', $key);
        return implode('-', array_map('ucwords', explode(' ', $ready)));
    }

}
