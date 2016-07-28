<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SwaggerValidator\DataType;

/**
 * Description of File
 *
 * @author Nabbar
 */
class TypeFile extends \SwaggerValidator\DataType\TypeCommon
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
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
                \SwaggerValidator\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
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
        \SwaggerValidator\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return array(
            'tmp_name' => uniqid('file_'),
            'error'    => UPLOAD_ERR_OK,
        );
    }

}
