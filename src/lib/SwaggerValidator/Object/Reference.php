<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Object;

/**
 * Description of Reference
 *
 * @author Nabbar
 */
class Reference extends \Swagger\Common\CollectionSwagger
{

    private $referenceId;
    private $reference;
    private $jsonData;

    public function __construct()
    {

    }

    public function jsonSerialize()
    {
        $keyRef = \Swagger\Common\FactorySwagger::KEY_REFERENCE;

        $result          = new \stdClass();
        $result->$keyRef = '#/' . \Swagger\Common\FactorySwagger::KEY_DEFINITIONS . '/' . $this->referenceId;

        return $result;
    }

    public function serialize()
    {
        return serialize(array(
            'ref' => $this->reference,
            'id'  => $this->referenceId
        ));
    }

    public function unserialize($data)
    {
        list($this->reference, $this->referenceId) = unserialize($data);
    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        $keyRef = \Swagger\Common\FactorySwagger::KEY_REFERENCE;

        $this->reference   = $jsonData->$keyRef;
        $this->referenceId = \Swagger\Common\CollectionReference::getIdFromRef($this->reference);

        if ($this->reference == $this->referenceId) {
            $this->reference = null;
        }

        $object         = \Swagger\Common\CollectionReference::getInstance()->get($this->referenceId);
        $this->jsonData = $object->getJson($context);

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function validate(\Swagger\Common\Context $context)
    {
        $object = \Swagger\Common\CollectionReference::getInstance()->get($this->referenceId);
        return $object->getObject($context->setExternalRef($this->referenceId))->validate($context->setExternalRef($this->referenceId));
    }

    public function getModel(\Swagger\Common\Context $context)
    {
        if ($context->checkExternalRef($this->referenceId)) {
            return new \stdClass();
        }

        $object = \Swagger\Common\CollectionReference::getInstance()->get($this->referenceId);
        return $object->getObject($context->setExternalRef($this->referenceId))->getModel($context->setExternalRef($this->referenceId));
    }

}
