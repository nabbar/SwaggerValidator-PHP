<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\Common;

/**
 * Description of CollectionType
 *
 * @author Nabbar
 */
class CollectionType extends \SwaggerValidator\Common\Collection
{

    /**
     * Helpers
     */
    const IOHelper  = '\\SwaggerValidator\\CustomIOHelper';
    const Exception = '\\SwaggerValidator\\Exception';

    /**
     * Swagger Standard Objects
     */
    const Swagger             = '\\SwaggerValidator\\Object\\Swagger';
    const Contact             = '\\SwaggerValidator\\Object\\Contact';
    const Definitions         = '\\SwaggerValidator\\Object\\Definitions';
    const ExternalDocs        = '\\SwaggerValidator\\Object\\ExternalDocs';
    const HeaderItem          = '\\SwaggerValidator\\Object\\HeaderItem';
    const Headers             = '\\SwaggerValidator\\Object\\Headers';
    const Info                = '\\SwaggerValidator\\Object\\Info';
    const Reference           = '\\SwaggerValidator\\Object\\Reference';
    const License             = '\\SwaggerValidator\\Object\\License';
    const Operation           = '\\SwaggerValidator\\Object\\Operation';
    const ParameterBody       = '\\SwaggerValidator\\Object\\ParameterBody';
    const Parameters          = '\\SwaggerValidator\\Object\\Parameters';
    const PathItem            = '\\SwaggerValidator\\Object\\PathItem';
    const Paths               = '\\SwaggerValidator\\Object\\Paths';
    const ResponseItem        = '\\SwaggerValidator\\Object\\ResponseItem';
    const Responses           = '\\SwaggerValidator\\Object\\Responses';
    const Security            = '\\SwaggerValidator\\Object\\Security';
    const SecurityItem        = '\\SwaggerValidator\\Object\\SecurityItem';
    const SecurityDefinitions = '\\SwaggerValidator\\Object\\SecurityDefinitions';
    const SecurityRequirement = '\\SwaggerValidator\\Object\\SecurityRequirement';

    /**
     * Swagger Primitive Datatype Object
     */
    const TypeArray            = '\\SwaggerValidator\\DataType\\TypeArray';
    const TypeArrayItems       = '\\SwaggerValidator\\DataType\\TypeArrayItems';
    const TypeBoolean          = '\\SwaggerValidator\\DataType\\TypeBoolean';
    const TypeCombined         = '\\SwaggerValidator\\DataType\\TypeCombined';
    const TypeFile             = '\\SwaggerValidator\\DataType\\TypeFile';
    const TypeInteger          = '\\SwaggerValidator\\DataType\\TypeInteger';
    const TypeNumber           = '\\SwaggerValidator\\DataType\\TypeNumber';
    const TypeObject           = '\\SwaggerValidator\\DataType\\TypeObject';
    const TypeObjectProperties = '\\SwaggerValidator\\DataType\\TypeObject';
    const TypeString           = '\\SwaggerValidator\\DataType\\TypeString';

    /**
     * Security Definition Object
     */
    const ApiKeySecurity               = '\\SwaggerValidator\\Security\\ApiKeySecurity';
    const BasicAuthenticationSecurity  = '\\SwaggerValidator\\Security\\BasicAuthenticationSecurity';
    const OAuth2AccessCodeSecurity     = '\\SwaggerValidator\\Security\\OAuth2AccessCodeSecurity';
    const OAuth2ApplicationSecurity    = '\\SwaggerValidator\\Security\\OAuth2ApplicationSecurity';
    const OAuth2ImplicitSecurity       = '\\SwaggerValidator\\Security\\OAuth2ImplicitSecurity';
    const OAuth2PasswordSecurity       = '\\SwaggerValidator\\Security\\OAuth2PasswordSecurity';
    const OAuth2PasswordSecurityScopes = '\\SwaggerValidator\\Security\\OAuth2PasswordSecurityScopes';

    /**
     *
     * @var \SwaggerValidator\Common\CollectionType
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
     * @return \SwaggerValidator\Common\CollectionType
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
    public static function setInstance(\SwaggerValidator\Common\CollectionType $instance)
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
