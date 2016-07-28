<?php

namespace Swagger\DataType;

/**
 * Abstract class used to check validation regardless JSON & Swagger validation schema
 * @see http://json-schema.org/latest/json-schema-validation.html
 * @author Nabbar
 */
abstract class TypeCommon extends \Swagger\Common\CollectionSwagger
{

    /**
     *
     * @var \stdClass|array
     */
    private $jsonObject;

    abstract protected function type(\Swagger\Common\Context $context, $valueParams);

    abstract protected function format(\Swagger\Common\Context $context, $valueParams);

    abstract protected function getExampleType(\Swagger\Common\Context $context);

    abstract protected function getExampleFormat(\Swagger\Common\Context $context);

    public function jsonSerialize()
    {
        /*        if (!empty($this->jsonObject)) {
          return $this->jsonObject;
          }
         */
        return parent::jsonSerialize();
    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        foreach (get_object_vars($jsonData) as $key => $value) {
            $this->$key = $value;
        }

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    protected function storeJsonObject()
    {

        $this->jsonObject = null;
        $this->jsonObject = $this->jsonSerialize();
    }

    public function isRequired()
    {
        if (isset($this->required)) {
            return (bool) ($this->required);
        }

        return false;
    }

    public function pattern(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('pattern')) {
            return true;
        }

        if (empty($this->pattern)) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        $pattern = str_replace('~', '\~', $this->pattern);

        return preg_match('~' . $pattern . '~', $valueParams);
    }

    public function allowEmptyValue(\Swagger\Common\Context $context, $valueParams)
    {
        if (isset($this->allowEmptyValue) && $this->allowEmptyValue == true) {
            return empty($valueParams);
        }

        return false;
    }

    public function hasFormat()
    {
        return $this->__isset('format');
    }

    public function hasDefault()
    {
        return $this->__isset('default');
    }

    public function getDefault(\Swagger\Common\Context $context)
    {
        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $this->__get('default');
    }

    public function hasExample()
    {
        return $this->__isset('example');
    }

    public function getExample(\Swagger\Common\Context $context)
    {
        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return $this->__get('example');
    }

    public function hasEnum()
    {
        return $this->__isset('enum') && is_array($this->enum);
    }

    public function getModel(\Swagger\Common\Context $context)
    {
        if ($this->hasExample()) {
            return $this->getExample($context);
        }
        elseif ($this->hasDefault()) {
            return $this->getDefault($context);
        }
        elseif ($this->hasEnum()) {
            return $this->enum[0];
        }
        elseif ($this->hasFormat()) {
            return $this->getExampleFormat($context);
        }
        else {
            return $this->getExampleType($context);
        }
    }

    public function enum(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('enum')) {
            return true;
        }
        if (!is_array($this->enum)) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        return in_array($valueParams, $this->enum);
    }

    public function multipleOf(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('multipleOf')) {
            return true;
        }

        if (!is_numeric($this->multipleOf) || $this->multipleOf <= 0) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        return (($valueParams % $this->multipleOf) == 0);
    }

    public function minimum(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('minimum')) {
            return true;
        }

        if (!$this->__isset('exclusiveMinimum') || $this->exclusiveMinimum == false) {
            return ($this->minimum <= $valueParams);
        }

        return ($this->minimum < $valueParams);
    }

    public function maximum(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('maximum')) {
            return true;
        }

        if (!$this->__isset('exclusiveMaximum') || $this->exclusiveMaximum == false) {
            return ($this->maximum >= $valueParams);
        }

        return ($this->maximum > $valueParams);
    }

    public function minLength(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('minLength')) {
            return true;
        }

        return ($this->minLength <= strlen($valueParams));
    }

    public function maxLength(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('maxLength')) {
            return true;
        }

        return ($this->maxLength >= strlen($valueParams));
    }

    public function minItems(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('minItems')) {
            return true;
        }

        return ($this->minItems <= count($valueParams));
    }

    public function maxItems(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('maxItems')) {
            return true;
        }

        return ($this->maxItems >= count($valueParams));
    }

    public function uniqueItems(\Swagger\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('uniqueItems') || $this->uniqueItems == false) {
            return true;
        }

        return (count(array_unique($valueParams)) == count($valueParams));
    }

    public function collectionFormat(\Swagger\Common\Context $context, &$valueParams)
    {
        if (!is_string($valueParams)) {
            return false;
        }

        if (!$this->__isset('collectionFormat')) {
            return false;
        }

        switch ($this->collectionFormat) {

            case 'ssv':
                // Space separated values foo bar.
                $valueParams = explode(' ', $valueParams);
                break;

            case 'tsv':
                // Tab separated values foo\tbar.
                $valueParams = explode("\t", $valueParams);
                break;

            case 'pipes':
                // Pipe separated values foo|bar.
                $valueParams = explode('|', $valueParams);
                break;

            case 'multi':
                // Corresponds to multiple parameter instances instead of multiple values for a single instance foo=bar&foo=baz.
                // This is valid only for parameters in "query" or "formData".
                if (!in_array($context->getLocation(), array(\Swagger\Common\Context::LOCATION_QUERY, \Swagger\Common\Context::LOCATION_FORM))) {
                    return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
                }

                /**
                 * @todo Making parsing multi for collectionFormat
                 */
                break;

            default:
            case 'csv':
                // Comma separated values foo,bar.
                $valueParams = explode(',', $valueParams);
                break;
        }

        return true;
    }

}
