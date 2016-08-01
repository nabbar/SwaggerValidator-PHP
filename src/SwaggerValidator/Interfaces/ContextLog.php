<?php

/*
 * Copyright 2016 Nicolas JUHEL<swaggervalidator@nabbar.com>.
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

namespace SwaggerValidator\Interfaces;

/**
 *
 * @author Nicolas JUHEL <swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
interface ContextLog
{

    public static function logLoadFile($file, $method = null, $line = null);

    public static function logLoadRef($ref, $method = null, $line = null);

    public static function logReplaceRef($oldRef, $newRef, $method = null, $line = null);

    public static function logDecode($decodePath, $decodeType, $method = null, $line = null);

    public static function logValidate($path, $type, $method = null, $line = null);

    public static function logModel($path, $method = null, $line = null);

    public static function logDebug($message, $method = null, $line = null);

    public function logValidationError($validationType, $method = null, $line = null);
}
