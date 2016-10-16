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
 * Description of string
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
class TypeString extends \SwaggerValidator\DataType\TypeCommon
{

    const PATTERN_BYTE     = '^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?$';
    //const PATTERN_BINARY   = '^(?:([A-Fa-f0-9]{2})*|([01]{4}[ ]?)*)?$'; // Allow Hexa form
    const PATTERN_BINARY   = '^([01]{1,4}[ ]?)*$'; // Allow only binary
    const PATTERN_DATE     = '^\d{4}-\d{2}-\d{2}$';
    const PATTERN_DATETIME = '\d{4}-\d{2}-\d{2}[tT]\d{2}:\d{2}:\d{2}(\.\d)?(z|Z|[+-]\d{2}:\d{2})';
    const PATTERN_URI      = '^http[s]?:\/\/(?:[\w\-._~!$&\'()*+,;=]+|(%[0-9A-Fa-f]{2})+)(\/((?:[\w\-._~!$&\'()*+,;=:@]|%[0-9A-Fa-f]{2})+\/?)*)?(\?(?:[\w\-._~!$&\'()*+,;=:@\/\\]|%[0-9A-Fa-f]{2})*)?(#(?:[\w\-._~!$&\'()*+,;=:@\/\\]|%[0-9A-Fa-f]{2})*)?';
    const PATTERN_IPV4     = '^([01]?[0-9][0-9]?|2[0-4][0-9]|25[0-5])(\.([01]?[0-9][0-9]?|2[0-4][0-9]|25[0-5])){3}$';
    const PATTERN_IPV6     = '(^\d{20}$)|(^((:[a-fA-F0-9]{1,4}){6}|::)ffff:(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[0-9]{1,2})(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[0-9]{1,2})){3}$)|(^((:[a-fA-F0-9]{1,4}){6}|::)ffff(:[a-fA-F0-9]{1,4}){2}$)|(^([a-fA-F0-9]{1,4}) (:[a-fA-F0-9]{1,4}){7}$)|(^:(:[a-fA-F0-9]{1,4}(::)?){1,6}$)|(^((::)?[a-fA-F0-9]{1,4}:){1,6}:$)|(^::$)|(^::1$)';

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
        if (!$this->__isset('type')) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if ((!isset($this->minLength) || $this->minLength < 1) && $context->isDataEmpty()) {
            return true;
        }

        if ($this->type != \SwaggerValidator\Common\FactorySwagger::TYPE_STRING) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_SWAGGER_ERROR, null, __METHOD__, __LINE__);
        }

        if (!$this->type($context, $context->getDataValue())) {
            return $context->setDataCheck('type')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, $context->getDataPath() . ' is not a valid string !!', __METHOD__, __LINE__);
        }

        if (!$this->minLength($context, $context->getDataValue())) {
            return $context->setDataCheck('minLength')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, null, __METHOD__, __LINE__);
        }

        if (!$this->maxLength($context, $context->getDataValue())) {
            return $context->setDataCheck('maxLength')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATASIZE, null, __METHOD__, __LINE__);
        }

        if (!$this->pattern($context, $context->getDataValue())) {
            return $context->setDataCheck('pattern')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_PATTERN, null, __METHOD__, __LINE__);
        }

        if (!$this->format($context, $context->getDataValue())) {
            return false;
        }

        if (!$this->enum($context, $context->getDataValue())) {
            return $context->setDataCheck('enum')->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATAVALUE, null, __METHOD__, __LINE__);
        }

// completer les test integer
        $context->logValidate(get_class($this), __METHOD__, __LINE__);
        return true;
    }

    protected function type(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (is_string($valueParams)) {
            return true;
        }

        return false;
    }

    protected function format(\SwaggerValidator\Common\Context $context, $valueParams)
    {
        if (!$this->__isset('format') || empty($this->format)) {
            return true;
        }

        $pattern = null;

        switch ($this->format) {
            case 'byte':
                /**
                 * @see RFC 4648 : http://www.ietf.org/rfc/rfc4648.txt
                 */
                $pattern = '#' . self::PATTERN_BYTE . '#';
                break;

            case 'binary':
                $pattern = '#' . self::PATTERN_BINARY . '#';
                break;

            case 'date':
                /**
                 * @see RFC 3339 : http://www.ietf.org/rfc/rfc3339.txt
                 */
                $pattern = '#' . self::PATTERN_DATE . '#';
                break;

            case 'date-time':
                /**
                 * @see RFC 3339 : http://www.ietf.org/rfc/rfc3339.txt
                 */
                $pattern = '#' . self::PATTERN_DATETIME . '#';
                break;

            case 'password':
                return $this->validatePasswordForm($valueParams);
                break;

            case 'uri':
                $pattern = '/' . self::PATTERN_URI . '/';
                break;

            case 'ipv4':
                $pattern = '#' . self::PATTERN_IPV4 . '#';
                break;

            case 'ipv6':
                $pattern = '#' . self::PATTERN_IPV6 . '#';
                break;

            case 'string':
                return true;

            default:
                return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, 'The format does not match with registred patterns', __METHOD__, __LINE__);
                break;
        }

        if (empty($pattern)) {
            return $context->setValidationError(\SwaggerValidator\Common\Context::VALIDATION_TYPE_DATATYPE, 'The format does not match with registred patterns', __METHOD__, __LINE__);
        }

        return (bool) preg_match($pattern, $valueParams);
    }

    protected function getExampleFormat(\SwaggerValidator\Common\Context $context)
    {
        if ($this->format == 'byte') {
            /**
             * @see RFC 4648 : http://www.ietf.org/rfc/rfc4648.txt
             */
            $context->logModel(__METHOD__, __LINE__);
            return base64_encode($this->generateRandowString());
        }

        if ($this->format == 'binary') {
            /**
             * @todo get an example or regex for validation format
             */
            $context->logModel(__METHOD__, __LINE__);
            return $this->generateRandowBinary();
        }

        if ($this->format == 'date') {
            /**
             * @see RFC 3339 : http://www.ietf.org/rfc/rfc3339.txt
             */
            $context->logModel(__METHOD__, __LINE__);
            return date('Y-m-d');
        }

        if ($this->format == 'date-time') {
            /**
             * @see RFC 3339 : http://www.ietf.org/rfc/rfc3339.txt
             */
            $context->logModel(__METHOD__, __LINE__);
            return date('c');
        }

        if ($this->format == 'password') {
            /**
             * Format specified only to obfucate input field
             */
            $context->logModel(__METHOD__, __LINE__);
            return $this->generateRandowSign();
        }

        if ($this->format == 'uri') {
            /**
             * Format specified only to obfucate input field
             */
            $context->logModel(__METHOD__, __LINE__);
            return 'http://localhost/path/script.php?query#fragment';
        }

        if ($this->format == 'ipv4') {
            /**
             * Format specified only to obfucate input field
             */
            $context->logModel(__METHOD__, __LINE__);
            return long2ip(random_int(167772161, 4210752250));
        }

        if ($this->format == 'ipv6') {
            /**
             * Format specified only to obfucate input field
             */
            $context->logModel(__METHOD__, __LINE__);
            return '2001:' . base_convert(random_int(0, pow(2, 16) - 1), 10, 16) . ':' . base_convert(random_int(0, pow(2, 16) - 1), 10, 16) . ':' . base_convert(random_int(0, pow(2, 16) - 1), 10, 16) . ':' . base_convert(random_int(0, pow(2, 16) - 1), 10, 16) . ':' . base_convert(random_int(0, pow(2, 16) - 1), 10, 16) . '::';
        }

        return $this->getExampleType($context);
    }

    protected function getExampleType(\SwaggerValidator\Common\Context $context)
    {
        $context->logModel(__METHOD__, __LINE__);
        return $this->generateRandowString();
    }

    private function generateRandowString()
    {
        $min  = isset($this->minLength) ? $this->minLength : 0;
        $max  = isset($this->maxLength) ? $this->maxLength : 255;
        $char = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ipsum sapien, bibendum at placerat sit amet, volutpat sed lacus. Nulla justo arcu, sodales ac commodo quis, laoreet a ipsum. Duis sem elit, posuere eu facilisis nec, tempus ac ipsum. Ut molestie aliquet est, posuere tincidunt elit. Etiam convallis eu ligula non consequat. Pellentesque elit libero, faucibus luctus ante nec, volutpat dictum neque. Donec molestie, eros in pretium pulvinar, est leo vehicula lectus, a cursus neque erat vitae odio. Sed sed neque dignissim, imperdiet nunc maximus, finibus erat. Proin id scelerisque ipsum. Quisque porta mauris nec massa egestas, sed mollis est molestie. Aenean quam nisi, posuere sed varius sodales, sagittis sed ex. Vivamus id vulputate odio. Donec quis facilisis arcu, vel ultrices augue. Suspendisse potenti. Mauris vehicula ex lorem, ut ornare purus ultrices nec. Vestibulum elementum felis sit amet ipsum euismod ullamcorper. Phasellus sit amet vestibulum quam. Morbi tincidunt pretium sodales. Etiam dignissim risus non felis scelerisque aliquet. Phasellus faucibus urna arcu, et dignissim augue interdum sed. Vestibulum eget luctus metus, eu bibendum orci. Sed eros massa, vehicula quis condimentum eget, tristique ut quam. Maecenas et velit dignissim, tincidunt justo quis, iaculis odio. Mauris volutpat dignissim mi eget lacinia. In nisi odio, porta ut quam non, imperdiet varius orci. Donec consectetur sed ante sit amet sagittis. In non lectus eu nunc interdum laoreet a ut dui. Sed eu nulla malesuada, egestas velit id, semper felis. Fusce ac dui nisl. Donec ultricies nibh eu leo consectetur congue quis nec tellus. Morbi consequat mi id eros viverra ullamcorper. Fusce nec est quam. Pellentesque vulputate sapien at turpis molestie congue. Nunc et lorem eros. Suspendisse eget nibh pulvinar, vestibulum magna ut, suscipit est. Etiam varius lobortis porttitor. Mauris vel ultrices erat, at hendrerit enim. Sed leo ex, pulvinar vel metus et, molestie pretium tortor. Praesent interdum fringilla orci, gravida ornare nibh sollicitudin et. Curabitur pulvinar metus massa, malesuada facilisis sapien finibus at. Nullam finibus urna vel auctor fringilla. Mauris eu tortor blandit, bibendum tortor ac, congue eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse justo turpis, lacinia id tempor sed, dapibus vel elit. Sed efficitur, mi sit amet fermentum ultricies, felis felis aliquam enim, id feugiat magna elit in sapien. Sed malesuada, velit eu dapibus vehicula, sem tortor accumsan nibh, sed pellentesque enim metus in eros. Mauris sollicitudin varius purus, nec condimentum tellus sagittis at. Nullam vel metus ac quam gravida pellentesque. Nullam ultricies turpis nec dignissim aliquam. Nunc sed enim nec tellus accumsan tincidunt. Aliquam enim dui, consectetur sit amet dui sit amet, elementum congue neque.';
        $size = ceil(random_int($min, $max));

        if ($min > 0) {
            return substr($char, random_int(0, (int) (strlen($char) - ($min * 2))), $min);
        }

        return substr($char, random_int(0, (int) (strlen($char) - ($size * 2))), $size);
    }

    private function generateRandowSign()
    {
        $min  = isset($this->minLength) ? $this->minLength : 0;
        $max  = isset($this->maxLength) ? $this->maxLength : 255;
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ?,.;\/:§!*%µ$~#|`\\^@&{[(_)]}°+=\'-';
        $char = str_repeat($char . strrev($char), 25);
        $size = ceil(random_int($min, $max));
        $text = '';

        for ($i = 0; $i < $size; $i++) {
            $text .= substr($char, random_int(0, strlen($char)), 1);
        }

        return $text;
    }

    private function generateRandowBinary()
    {
        $min  = isset($this->minLength) ? $this->minLength : 0;
        $max  = isset($this->maxLength) ? $this->maxLength : 512;
        $size = ceil(random_int($min, (int) ($max / 2)));
        $text = '';

        for ($i = 0; $i < $size; $i++) {
            $text .= chr(random_int(0, 254));
        }

        $hexa   = unpack('H*', ($text));
        $binary = "";

        for ($i = 0; $i < strlen($hexa[1]); $i+=4) {
            $binary .= str_pad(base_convert(substr($hexa[1], $i, 4), 16, 2), 16, "0", STR_PAD_LEFT);
        }

        return $binary;
    }

    public function validatePasswordForm($value)
    {
        $min = (isset($this->minLength)) ? $this->minLength : 0;
        $max = (isset($this->maxLength)) ? $this->maxLength : 64;

        return (bool) preg_match('/([\w\b ?,.;\/:§!*%µ$~#\|`\\^@&{\[(_)\]}°+=\'-]{' . $min . ',' . $max . '})?/', $value);
    }

}
