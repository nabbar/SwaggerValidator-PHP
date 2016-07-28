<?php

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