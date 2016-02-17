<?php
/**
 * init.php
 *
 * @User    : wsj6563@gmail.com
 * @Date    : 16/2/17 14:40
 * @Encoding: UTF-8
 * @Created by PhpStorm.
 */

namespace sinopex\searchSuggest;

use sinopex\searchSuggest\helper\Import;

require './vendor/autoload.php';

$import = new Import();
$import->run();