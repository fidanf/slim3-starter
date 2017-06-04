<?php

/**
 * Custom Helpers
 */

use Symfony\Component\VarDumper\{VarDumper, Dumper\HtmlDumper, Cloner\VarCloner};

function debug()
{
    $args = func_get_args();
    call_user_func_array('dump', $args);
    die();
}

VarDumper::setHandler(function ($var) {
    $cloner = new VarCloner;
    $htmlDumper = new HtmlDumper;
    $htmlDumper->setStyles([
        'default' => 'background-color:#f6f6f6; color:#222; line-height:1.3em; 
            font-weight:normal; font:16px Monaco, Consolas, monospace; 
            word-wrap: break-word; white-space: pre-wrap; position:relative; 
            z-index:100000',
        'public' => 'color:#ec9114',
        'protected' => 'color:#ec9114',
        'private' => 'color:#ec9114',
    ]);
    $htmlDumper->dump($cloner->cloneVar($var));
});