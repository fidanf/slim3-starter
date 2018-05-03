<?php

/**
 * Custom Helpers
 */

use App\Support\Extensions\ViewFactory;
use Respect\Validation\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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

LengthAwarePaginator::viewFactoryResolver(function (){
    return new ViewFactory;
});

LengthAwarePaginator::defaultView('pagination/defaultPagination.twig');

Paginator::currentPathResolver(function (){
    return isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '/';
});

Paginator::currentPageResolver(function (){
   return $_GET['page'] ?? 1;
});

Validator::with('App\Validation\Rules');
