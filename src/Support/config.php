<?php

if (!function_exists('config')) {
    function config($key, $default = null) {
        static $configs = [];
        if (empty($configs['iugu'])) {
            $configs['iugu'] = require __DIR__ . '/../../../config/iugu.php';
        }
        if (strpos($key, 'iugu.') === 0) {
            $subkey = substr($key, 5);
            if (array_key_exists($subkey, $configs['iugu'])) {
                return $configs['iugu'][$subkey];
            }
        }
        return $default;
    }
} 