<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Swagger\Object;

/**
 * Description of HeaderItem
 *
 * @author Nabbar
 */
class HeaderItem extends \Swagger\Common\CollectionSwagger
{

    public function __construct()
    {

    }

    public function jsonUnSerialize(\Swagger\Common\Context $context, $jsonData)
    {
        if (!is_object($jsonData)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        if (!($jsonData instanceof \stdClass)) {
            $this->buildException('Mismatching type of JSON Data received', $context);
        }

        $header     = $this->extractNonRecursiveReference($context, $jsonData);
        $this->item = \Swagger\Common\FactorySwagger::getInstance()->jsonUnSerialize($context->setDataPath('header'), $this->getCleanClass(__CLASS__), $key, $header);

        \Swagger\Common\Context::logDecode($context->getDataPath(), get_class($this), __METHOD__, __LINE__);
    }

    public function getModel(\Swagger\Common\Context $context)
    {
        return $this->item->getModel($context);
    }

}
