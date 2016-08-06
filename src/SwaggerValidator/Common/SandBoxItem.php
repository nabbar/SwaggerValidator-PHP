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

namespace SwaggerValidator\Common;

/**
 * Description of SandBoxItem
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 */
class SandBoxItem extends \SwaggerValidator\Common\Collection
{

    public function jsonSerialize()
    {
        return null;
    }

    public function serialize()
    {
        return null;
    }

    public function unserialize($data)
    {
        return null;
    }

    public function get($name)
    {
        return parent::__get($name);
    }

    public function set($name, $value = null)
    {
        return parent::__set($name, $value);
    }

}
