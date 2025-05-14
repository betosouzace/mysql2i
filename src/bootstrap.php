<?php

/**
 * Bootstrap file for Mysql2i library
 * 
 * Include this file after your application's autoloader to enable
 * mysql compatibility functions in newer PHP versions.
 */

// Include autoloader if not already loaded through Composer
if (!class_exists('Mysql2i\\Mysql2i')) {
    require_once __DIR__ . '/autoload.php';
}

// Initialize the Mysql2i library
Mysql2i\Mysql2i::initialize(); 