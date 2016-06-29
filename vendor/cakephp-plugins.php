<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'AkkaFacebook' => $baseDir . '/vendor/akkaweb/cakephp-facebook/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'CakeCaptcha' => $baseDir . '/vendor/captcha-com/cakephp-captcha/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/'
    ]
];