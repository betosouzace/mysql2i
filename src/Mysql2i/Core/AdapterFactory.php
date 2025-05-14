<?php

namespace Mysql2i\Core;

use Mysql2i\Adapter\AdapterInterface;
use Mysql2i\Adapter\MysqliAdapter;

/**
 * AdapterFactory class
 * 
 * Factory for creating adapter instances
 */
class AdapterFactory
{
    /**
     * @var AdapterInterface Singleton adapter instance
     */
    private static $instance = null;
    
    /**
     * Create an adapter instance
     * 
     * @param string $adapterType Type of adapter to create
     * @return AdapterInterface Adapter instance
     */
    public static function createAdapter($adapterType = 'mysqli')
    {
        if (self::$instance !== null) {
            return self::$instance;
        }
        
        $connectionManager = new ConnectionManager();
        
        switch ($adapterType) {
            case 'mysqli':
            default:
                self::$instance = new MysqliAdapter($connectionManager);
        }
        
        return self::$instance;
    }
    
    /**
     * Get the singleton adapter instance
     * 
     * @return AdapterInterface Adapter instance
     */
    public static function getAdapter()
    {
        if (self::$instance === null) {
            self::createAdapter();
        }
        
        return self::$instance;
    }
} 