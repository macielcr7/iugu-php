<?php

if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
} 