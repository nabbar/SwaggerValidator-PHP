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

namespace SwaggerValidator\DataType;

/**
 * Description of File
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class TypeFile extends \SwaggerValidator\DataType\TypeCommon
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
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

    public function validate(\SwaggerValidator\Common\Context $context)
    {
        if ($context->getLocation() !== \SwaggerValidator\Common\FactorySwagger::LOCATION_FORM) {
            return $context->setDataCheck('location/type')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!isset($this->type)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if ($this->type != \SwaggerValidator\Common\FactorySwagger::TYPE_FILE) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        $value = $context->getDataValue();

        if (is_array($value) && !empty($value['tmp_name']) && array_key_exists('error', $value)) {

            if ($value['error'] == UPLOAD_ERR_OK) {
                $context->logValidate(get_class($this), __METHOD__, __LINE__);
                return true;
            }
            else {
                return $context->setDataCheck('type')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, null, __METHOD__, __LINE__);
            }
        }

        return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
    }

    protected function format(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function type(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function getExampleFormat(\SwaggerValidator\Common\Context $context)
    {
        return $this->getExampleType($context);
    }

    protected function getExampleType(\SwaggerValidator\Common\Context $context)
    {
        $context->logModel(__METHOD__, __LINE__);
        return array(
            'tmp_name' => uniqid('file_'),
            'error'    => UPLOAD_ERR_OK,
        );
    }

}
