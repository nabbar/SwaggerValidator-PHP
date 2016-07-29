<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('REPOS_PATH_ROOT', dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR);
define('REPOS_PATH_SRC', REPOS_PATH_ROOT . 'src' . DIRECTORY_SEPARATOR);
define('REPOS_PATH_BIN', REPOS_PATH_SRC . 'bin' . DIRECTORY_SEPARATOR);
define('REPOS_PATH_LIB', REPOS_PATH_SRC . 'lib' . DIRECTORY_SEPARATOR);
define('SWAGGER_PATH_ROOT', REPOS_PATH_LIB . 'SwaggerValidator' . DIRECTORY_SEPARATOR);

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

ksort($files, SORT_NATURAL);

$phar->buildFromIterator(new ArrayIterator($files));
$phar->setDefaultStub('Swagger.php');
//$phar->setSignatureAlgorithm(Phar::OPENSSL, getPrivateKey($pharPath));


