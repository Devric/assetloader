<?php

define('___ENV', 'dev');
define('___ASSETPATH', 'asset');

require_once('./asset.php');
    
Asset::css(array(
    'a',
    'b'
));

Asset::js(array(
    'a',
    'b'
));

Asset::addCss(array(
    'a',
    'b'
));

Asset::addJs(array(
    'jquery.min',
    'jquery.modal'
));

//  Asset::allJs(ENV);
