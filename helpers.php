<?php

if (!function_exists('app')) {
    function app($make = null)
    {
        if(is_null($make)) {
            return App\Merchnt::getInstance();
        }

        return App\Merchnt::getInstance()->make($make);
    }
}

if (!function_exists('container')) {
    function container()
    {
        return App\Merchnt::getInstance()->getContainer();
    }
}

if (!function_exists('dispatcher')) {
    function dispatcher()
    {
        return App\Merchnt::getInstance()->getDispatcher();
    }
}