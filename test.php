<?php

echo ini_get('curl.cainfo') . PHP_EOL;
echo ini_get('openssl.cafile') . PHP_EOL;

var_dump(file_exists(ini_get('curl.cainfo')));
var_dump(is_readable(ini_get('curl.cainfo')));