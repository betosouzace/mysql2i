<?php

namespace Mysql2i;

use Mysql2i\Core\Constants;
use Mysql2i\Compatibility\Functions;

/**
 * Main Mysql2i class
 * 
 * Entry point for the Mysql2i library
 */
class Mysql2i
{
    /**
     * @var bool Whether the library has been initialized
     */
    private static $initialized = false;
    
    /**
     * Initialize the Mysql2i library
     * 
     * This method will register all MySQL compatibility functions
     * and define necessary constants.
     * 
     * @return void
     */
    public static function initialize()
    {
        if (self::$initialized) {
            return;
        }
        
        // Initialize constants
        Constants::initialize();
        
        // Register functions
        Functions::register();
        
        self::$initialized = true;
    }
} 