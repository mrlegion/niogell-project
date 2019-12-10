<?php

function debug()
{
    $args = func_get_args();
    if ($args) {
        foreach ($args as $arg) {
            echo '<pre>' . print_r($arg, true) . '</pre>';
            echo '<br>';
        }
    }
}