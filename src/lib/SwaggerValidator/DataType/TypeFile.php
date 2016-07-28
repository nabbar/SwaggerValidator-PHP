<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\DataType;

/**
 * Description of File
 *
 * @author Nabbar
 */
class TypeFile extends \Swagger\DataType\TypeCommon
{

    public function __construct()
    {
        parent::registerMandatoryKey('type');
    }

    public function validate(\Swagger\Common\Context $context)
    {
        if ($context->getLocation() !== \Swagger\Common\FactorySwagger::LOCATION_FORM) {
            return $context->setDataCheck('location/type')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!isset($this->type)) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if ($this->type != \Swagger\Common\FactorySwagger::TYPE_FILE) {
            return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        $value = $context->getDataValue();

        if (is_array($value) && !empty($value['tmp_name']) && array_key_exists('error', $value)) {

            if ($value['error'] == UPLOAD_ERR_OK) {
                \Swagger\Common\Context::logValidate($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
                return true;
            }
            else {
                return $context->setDataCheck('type')->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATAVALUE, null, __METHOD__, __LINE__);
            }
        }

        return $context->setValidationError(\Swagger\Common\Context::VALIDATION_TYPE_DATATYPE, null, __METHOD__, __LINE__);
    }

    protected function format(\Swagger\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function type(\Swagger\Common\Context $context, $valueParams)
    {
        return true;
    }

    protected function getExampleFormat(\Swagger\Common\Context $context)
    {
        return $this->getExampleType($context);
    }

    protected function getExampleType(\Swagger\Common\Context $context)
    {
        \Swagger\Common\Context::logModel($context->getDataPath(), __METHOD__, __LINE__);
        return array(
            'tmp_name' => uniqid('file_'),
            'error'    => UPLOAD_ERR_OK,
        );
    }

}
