<?php
/**
 * index.php
 *
 * @User    : wsj6563@gmail.com
 * @Date    : 16/2/17 14:39
 * @Encoding: UTF-8
 * @Created by PhpStorm.
 */
namespace sinopex\searchSuggest;

require 'vendor/autoload.php';
use sinopex\searchSuggest\helper\Suggest;

$word = 'php';

$hints = (new Suggest())->get($word);
print_r($hints);