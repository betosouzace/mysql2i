<?php

namespace Mysql2i\Adapter;

/**
 * Interface for MySQL adapter implementations
 * 
 * This interface defines methods that must be implemented by adapter classes
 * to provide compatibility between mysql and mysqli extensions.
 */
interface AdapterInterface
{
    /**
     * Get the number of affected rows in a previous MySQL operation
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return int|bool Number of rows or FALSE on error
     */
    public function affectedRows($link = null);
    
    /**
     * Get MySQL client encoding
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return string The default character set
     */
    public function clientEncoding($link = null);
    
    /**
     * Close MySQL connection
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return bool TRUE on success or FALSE on failure
     */
    public function close($link = null);
    
    /**
     * Open a connection to a MySQL Server
     * 
     * @param string $host The MySQL server
     * @param string $username The username
     * @param string $passwd The password
     * @param bool $new_link Create a new link
     * @param int $client_flags Client flags
     * @return \mysqli|bool Connection resource or FALSE on error
     */
    public function connect($host = '', $username = '', $passwd = '', $new_link = false, $client_flags = 0);
    
    /**
     * Create a MySQL database
     * 
     * @param string $database_name The name of the database
     * @param \mysqli|null $link MySQL connection resource
     * @return bool TRUE on success or FALSE on failure
     */
    public function createDb($database_name, $link = null);
    
    /**
     * Move internal result pointer
     * 
     * @param \mysqli_result $result Result resource
     * @param int $offset The row offset
     * @return bool TRUE on success or FALSE on failure
     */
    public function dataSeek($result, $offset);
    
    /**
     * Get database name from result
     * 
     * @param \mysqli_result $result Result resource
     * @param int $row The row number
     * @param mixed $field Field to retrieve (numeric or named)
     * @return string The database name
     */
    public function dbName($result, $row, $field = null);
    
    /**
     * Send a MySQL query and select a database
     * 
     * @param string $database The database name
     * @param string $query The query
     * @param \mysqli|null $link MySQL connection resource
     * @return \mysqli_result|bool Result resource or FALSE on error
     */
    public function dbQuery($database, $query, $link = null);
    
    /**
     * Drop (delete) a MySQL database
     * 
     * @param string $database The database name
     * @param \mysqli|null $link MySQL connection resource
     * @return bool TRUE on success or FALSE on failure
     */
    public function dropDb($database, $link = null);
    
    /**
     * Returns the numerical value of the error message from previous MySQL operation
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return int Error number
     */
    public function errno($link = null);
    
    /**
     * Returns the text of the error message from previous MySQL operation
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return string Error text
     */
    public function error($link = null);
    
    /**
     * Escapes a string for use in a mysql_query
     * 
     * @param string $escapestr The string to escape
     * @return string The escaped string
     */
    public function escapeString($escapestr);
    
    /**
     * Fetch a result row as an associative array, a numeric array, or both
     * 
     * @param \mysqli_result $result Result resource
     * @param int $resulttype Type of returned array
     * @return array|bool Array of fetched data or FALSE on error
     */
    public function fetchArray($result, $resulttype = MYSQLI_BOTH);
    
    /**
     * Fetch a result row as an associative array
     * 
     * @param \mysqli_result $result Result resource
     * @return array|bool Array of fetched data or FALSE on error
     */
    public function fetchAssoc($result);
    
    /**
     * Get column information from a result and return as an object
     * 
     * @param \mysqli_result $result Result resource
     * @param int|null $field_offset Field offset
     * @return object Object with field information
     */
    public function fetchField($result, $field_offset = null);
    
    /**
     * Get the length of each output in a result
     * 
     * @param \mysqli_result $result Result resource
     * @return array|bool Array with lengths or FALSE on error
     */
    public function fetchLengths($result);
    
    /**
     * Fetch a result row as an object
     * 
     * @param \mysqli_result $result Result resource
     * @param string $class_name Name of the class to instantiate
     * @param array $params Parameters for the constructor
     * @return object|bool Object with fetched data or FALSE on error
     */
    public function fetchObject($result, $class_name = 'stdClass', $params = []);
    
    /**
     * Get a result row as an enumerated array
     * 
     * @param \mysqli_result $result Result resource
     * @return array|bool Array of fetched data or FALSE on error
     */
    public function fetchRow($result);
    
    /**
     * Get field flags as string
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return string Flag string
     */
    public function fieldFlags($result, $field_offset);
    
    /**
     * Get field length
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return int Field length
     */
    public function fieldLen($result, $field_offset);
    
    /**
     * Get field name
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return string Field name
     */
    public function fieldName($result, $field_offset);
    
    /**
     * Set field cursor to specified offset
     * 
     * @param \mysqli_result $result Result resource
     * @param int $fieldnr Field number
     * @return bool TRUE on success or FALSE on failure
     */
    public function fieldSeek($result, $fieldnr);
    
    /**
     * Get field table
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return string Table name
     */
    public function fieldTable($result, $field_offset);
    
    /**
     * Get field type
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return string Field type
     */
    public function fieldType($result, $field_offset);
    
    /**
     * Free result memory
     * 
     * @param \mysqli_result $result Result resource
     * @return bool TRUE on success or FALSE on failure
     */
    public function freeResult($result);
    
    /**
     * Get MySQL client info
     * 
     * @return string Client info
     */
    public function getClientInfo();
    
    /**
     * Get MySQL host info
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return string Host info
     */
    public function getHostInfo($link = null);
    
    /**
     * Get MySQL protocol info
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return int Protocol version
     */
    public function getProtoInfo($link = null);
    
    /**
     * Get MySQL server info
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return string Server info
     */
    public function getServerInfo($link = null);
    
    /**
     * Get information about the most recent query
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return string|bool Info or FALSE on failure
     */
    public function info($link = null);
    
    /**
     * Get the ID generated in the last query
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return int|bool Last ID or FALSE on error
     */
    public function insertId($link = null);
    
    /**
     * List databases available on a MySQL server
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return \mysqli_result|bool Result resource or FALSE on error
     */
    public function listDbs($link = null);
    
    /**
     * List MySQL table fields
     * 
     * @param string $database_name Database name
     * @param string $table_name Table name
     * @param \mysqli|null $link MySQL connection resource
     * @return \mysqli_result|bool Result resource or FALSE on error
     */
    public function listFields($database_name, $table_name, $link = null);
    
    /**
     * List MySQL processes
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return \mysqli_result|bool Result resource or FALSE on error
     */
    public function listProcesses($link = null);
    
    /**
     * List tables in a MySQL database
     * 
     * @param string $database Database name
     * @param \mysqli|null $link MySQL connection resource
     * @return \mysqli_result|bool Result resource or FALSE on error
     */
    public function listTables($database, $link = null);
    
    /**
     * Get number of fields in result
     * 
     * @param \mysqli_result $result Result resource
     * @return int|bool Number of fields or FALSE on error
     */
    public function numFields($result);
    
    /**
     * Get number of rows in result
     * 
     * @param \mysqli_result $result Result resource
     * @return int|bool Number of rows or FALSE on error
     */
    public function numRows($result);
    
    /**
     * Open a persistent connection to a MySQL server
     * 
     * @param string $host The MySQL server
     * @param string $username The username
     * @param string $passwd The password
     * @param bool $new_link Create a new link
     * @param int $client_flags Client flags
     * @return \mysqli|bool Connection resource or FALSE on error
     */
    public function pconnect($host = '', $username = '', $passwd = '', $new_link = false, $client_flags = 0);
    
    /**
     * Ping a server connection or reconnect if connection is broken
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return bool TRUE on success or FALSE on failure
     */
    public function ping($link = null);
    
    /**
     * Send a MySQL query
     * 
     * @param string $query The query string
     * @param \mysqli|null $link MySQL connection resource
     * @return \mysqli_result|bool Result resource or FALSE on error
     */
    public function query($query, $link = null);
    
    /**
     * Escape special characters in a string for use in an SQL statement
     * 
     * @param string $escapestr The string to escape
     * @param \mysqli|null $link MySQL connection resource
     * @return string The escaped string
     */
    public function realEscapeString($escapestr, $link = null);
    
    /**
     * Get result data
     * 
     * @param \mysqli_result $result Result resource
     * @param int $row The row number
     * @param mixed $field Field to retrieve (numeric or named)
     * @return mixed The data at the specified position or FALSE on error
     */
    public function result($result, $row, $field = null);
    
    /**
     * Select a MySQL database
     * 
     * @param string $dbname Database name
     * @param \mysqli|null $link MySQL connection resource
     * @return bool TRUE on success or FALSE on failure
     */
    public function selectDb($dbname, $link = null);
    
    /**
     * Set the client character set
     * 
     * @param string $charset The character set
     * @param \mysqli|null $link MySQL connection resource
     * @return bool TRUE on success or FALSE on failure
     */
    public function setCharset($charset, $link = null);
    
    /**
     * Get current system status
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return string|bool Status info or FALSE on error
     */
    public function stat($link = null);
    
    /**
     * Get table name of field
     * 
     * @param \mysqli_result $result Result resource
     * @param int $row The row number
     * @param mixed $field Field to retrieve (numeric or named)
     * @return string|bool Table name or FALSE on error
     */
    public function tablename($result, $row, $field = null);
    
    /**
     * Return the current thread ID
     * 
     * @param \mysqli|null $link MySQL connection resource
     * @return int|bool Thread ID or FALSE on error
     */
    public function threadId($link = null);
    
    /**
     * Send an SQL query without fetching and buffering the result rows
     * 
     * @param string $query The query string
     * @param \mysqli|null $link MySQL connection resource
     * @return \mysqli_result|bool Result resource or FALSE on error
     */
    public function unbufferedQuery($query, $link = null);
} 