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

/**
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
if (!function_exists('apache_response_headers')) {

    function apache_response_headers()
    {
        $arh     = array();
        $headers = headers_list();
        foreach ($headers as $header) {
            $header                    = explode(":", $header);
            $arh[array_shift($header)] = trim(implode(":", $header));
        }
        return $arh;
    }

}

if (!function_exists('apache_request_headers')) {

    function apache_request_headers()
    {
        $arh = array();

        foreach ($_SERVER as $key => $val) {

            if (strtoupper(substr($key, 0, 5)) == 'HTTP_') {
                $key           = substr($key, 5);
                $arh_key       = implode('-', array_map('ucfirst', explode('_', $key)));
                $arh[$arh_key] = $val;
            }
            elseif (strtoupper(substr($key, 0, 2)) == 'X_') {
                $arh_key       = implode('-', array_map('ucfirst', explode('_', $key)));
                $arh[$arh_key] = $val;
            }
            elseif ($key === 'CONTENT_TYPE') {
                $arh['Content-Type'] = $val;
            }
            elseif ($key === 'CONTENT_LENGTH') {
                $arh['Content-Length'] = $val;
            }
        }
        return( $arh );
    }

}

if (version_compare(PHP_VERSION, "5.4", "<")) {

    interface JsonSerializable
    {

    }

    If (!defined('JSON_UNESCAPED_SLASHES')) {
        define('JSON_UNESCAPED_SLASHES', 0);
    }

    If (!defined('JSON_UNESCAPED_UNICODE')) {
        define('JSON_UNESCAPED_UNICODE', 0);
    }
}

if (!function_exists('random_int')) {

    if (!function_exists('mcrypt_create_iv')) {
        throw new \Exception('Library mcrypt must be loaded for random_int to work');
    }

    function random_int($min, $max)
    {
        if (!is_int($min) || !is_int($max)) {
            trigger_error('$min and $max must be integer values', E_USER_NOTICE);
            $min = (int) $min;
            $max = (int) $max;
        }

        if ($min > $max) {
            trigger_error('$max can\'t be lesser than $min', E_USER_WARNING);
            return null;
        }

        $range   = $counter = $max - $min;
        $bits    = 1;

        while ($counter >>= 1) {
            ++$bits;
        }

        $bytes   = (int) max(ceil($bits / 8), 1);
        $bitmask = pow(2, $bits) - 1;

        if ($bitmask >= PHP_INT_MAX) {
            $bitmask = PHP_INT_MAX;
        }

        do {
            $result = hexdec(
                            bin2hex(
                                    mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM)
                            )
                    ) & $bitmask;
        }
        while ($result > $range);

        return $result + $min;
    }

}
