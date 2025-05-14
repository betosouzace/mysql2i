<?php

namespace Mysql2i\Core;

/**
 * ConnectionManager class
 * 
 * Manages MySQL connections for the library
 */
class ConnectionManager
{
    /**
     * @var \mysqli Current connection instance
     */
    private $currentConnection = null;
    
    /**
     * Get the current connection
     * 
     * @return \mysqli|null Current connection object or null
     */
    public function getCurrentConnection()
    {
        return $this->currentConnection;
    }
    
    /**
     * Set the current connection
     * 
     * @param \mysqli $connection Connection to set as current
     * @return void
     */
    public function setCurrentConnection($connection)
    {
        $this->currentConnection = $connection;
    }
    
    /**
     * Get a connection
     * 
     * Returns the provided connection if not null, otherwise returns the current connection
     * 
     * @param \mysqli|null $connection Connection to return if not null
     * @return \mysqli|null Connection or null
     */
    public function getConnection($connection = null)
    {
        if (!empty($connection)) {
            return $connection;
        }
        
        return $this->currentConnection;
    }
} 