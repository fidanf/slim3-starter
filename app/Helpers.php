<?php

/**
 * Custom Helpers
 */

function debug()
{
    $args = func_get_args();
    call_user_func_array('dump', $args);
    die();
}