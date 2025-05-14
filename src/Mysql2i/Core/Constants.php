<?php

namespace Mysql2i\Core;

/**
 * Constants class
 * 
 * Defines constants used in the old mysql extension
 */
class Constants
{
    /**
     * Initialize mysql constants using mysqli equivalents
     * 
     * @return void
     */
    public static function initialize()
    {
        if (!defined('MYSQL_BOTH')) {
            define('MYSQL_BOTH', MYSQLI_BOTH);
        }
        
        if (!defined('MYSQL_NUM')) {
            define('MYSQL_NUM', MYSQLI_NUM);
        }
        
        if (!defined('MYSQL_ASSOC')) {
            define('MYSQL_ASSOC', MYSQLI_ASSOC);
        }
        
        if (!defined('MYSQL_CLIENT_COMPRESS')) {
            define('MYSQL_CLIENT_COMPRESS', MYSQLI_CLIENT_COMPRESS);
        }
        
        if (!defined('MYSQL_CLIENT_SSL')) {
            define('MYSQL_CLIENT_SSL', MYSQLI_CLIENT_SSL);
        }
        
        if (!defined('MYSQL_CLIENT_INTERACTIVE')) {
            define('MYSQL_CLIENT_INTERACTIVE', MYSQLI_CLIENT_INTERACTIVE);
        }
        
        if (!defined('MYSQL_CLIENT_IGNORE_SPACE')) {
            define('MYSQL_CLIENT_IGNORE_SPACE', MYSQLI_CLIENT_IGNORE_SPACE);
        }
    }
} 