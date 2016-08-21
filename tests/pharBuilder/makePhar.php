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
 * Builder for PHAR archive
 *
 * @author Nicolas JUHEL<swaggervalidator@nabbar.com>
 * @version 1.0.0
 */
define('REPOS_PATH_ROOT', dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR);
define('REPOS_PATH_SRC', REPOS_PATH_ROOT . 'src' . DIRECTORY_SEPARATOR);
define('REPOS_PATH_BIN', REPOS_PATH_ROOT . 'bin' . DIRECTORY_SEPARATOR);
define('SWAGGER_PATH_ROOT', REPOS_PATH_SRC);

function getPrivateKey($pharPath)
{
    /*
     * Generate a key with this command :
     * openssl genrsa -out key.priv.pem -aes256 4096
     * openssl rsa -in key.priv.pem -pubout -out key.pub.pem
     */
    $path = dirname(__FILE__);
    $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
    $path = str_replace('//', '/', $path . '/key.priv.pem');
    $path = str_replace('/', DIRECTORY_SEPARATOR, $path);

    copy(str_replace('.priv.', '.pub.', $path), $pharPath . '.pubkey');

    $private = openssl_get_privatekey(file_get_contents($path), readline('Passphrase :'));
    $result  = '';

    openssl_pkey_export($private, $result);
    return $private;
}

if (!Phar::canWrite()) {
    die("\n\n\t\t" . 'cannot write phar : change the ini phar.readonly to 0 !!' . "\n\n");
}

$pharPath = REPOS_PATH_BIN . 'SwaggerValidator.phar';
$phar     = new Phar($pharPath, 0, 'SwaggerValidator.phar');

//$phar->buildFromDirectory(getPath());
$list    = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(realpath(SWAGGER_PATH_ROOT), FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS));
$files   = array();
$exclude = array(
    '/Example.php',
);

foreach ($list as $key => $value) {
    $key = str_replace(realpath(SWAGGER_PATH_ROOT), '', $key);

    if (in_array($key, $exclude)) {
        continue;
    }

    $files[$key] = $value . "";
}
if (version_compare(PHP_VERSION, '5.4', '<')) {
    ksort($files);
}
else {
    ksort($files, SORT_NATURAL);
}

$phar->buildFromIterator(new ArrayIterator($files));
$phar->setDefaultStub('Swagger.php');
//$phar->setSignatureAlgorithm(Phar::OPENSSL, getPrivateKey($pharPath));


