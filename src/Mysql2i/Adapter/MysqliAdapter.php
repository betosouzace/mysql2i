<?php

namespace Mysql2i\Adapter;

use Mysql2i\Core\ConnectionManager;

/**
 * Mysqli adapter implementation
 * 
 * This class implements the AdapterInterface using mysqli functions
 */
class MysqliAdapter implements AdapterInterface
{
    /**
     * @var ConnectionManager
     */
    private $connectionManager;
    
    /**
     * @var bool Flag to track if connection is closing
     */
    private $isClosing = false;
    
    /**
     * @var array Cache for field type mappings
     */
    private $typeCache = [];
    
    /**
     * @var array Cache for field flag mappings
     */
    private $flagCache = [];
    
    /**
     * Constructor
     *
     * @param ConnectionManager $connectionManager
     */
    public function __construct(ConnectionManager $connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function affectedRows($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        if (!$link || !($link instanceof \mysqli) || $link->connect_errno || !isset($link->host_info)) {
            return false;
        }
        
        return mysqli_affected_rows($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function clientEncoding($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_character_set_name($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function close($link = null)
    {
        if ($this->isClosing) {
            return true;
        }
        
        $link = $this->connectionManager->getConnection($link);
        
        if (!$link || !($link instanceof \mysqli) || $link->connect_errno) {
            return true;
        }
        
        $this->isClosing = true;
        return true; // We don't actually close the connection here
    }
    
    /**
     * {@inheritdoc}
     */
    public function connect($host = '', $username = '', $passwd = '', $new_link = false, $client_flags = 0)
    {
        $currentLink = $this->connectionManager->getCurrentConnection();
        
        if ($currentLink instanceof \mysqli && !$currentLink->connect_errno) {
            return $currentLink;
        }
        
        $link = mysqli_connect($host, $username, $passwd);
        $this->connectionManager->setCurrentConnection($link);
        $this->isClosing = false;
        
        return $link;
    }
    
    /**
     * {@inheritdoc}
     */
    public function createDb($database_name, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        $query = "CREATE DATABASE `" . $database_name . "`";
        mysqli_query($link, $query);
        
        if (empty(mysqli_errno($link))) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function dataSeek($result, $offset)
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        return mysqli_data_seek($result, $offset);
    }
    
    /**
     * {@inheritdoc}
     */
    public function dbName($result, $row, $field = null)
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        mysqli_data_seek($result, $row);
        $f = mysqli_fetch_row($result);
        
        return $f[0];
    }
    
    /**
     * {@inheritdoc}
     */
    public function dbQuery($database, $query, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        mysqli_select_db($link, $database);
        $r = mysqli_query($link, $query);
        
        return $r;
    }
    
    /**
     * {@inheritdoc}
     */
    public function dropDb($database, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        $query = "DROP DATABASE `" . $database . "`";
        mysqli_query($link, $query);
        
        if (empty(mysqli_errno($link))) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function errno($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_errno($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function error($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_error($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function escapeString($escapestr)
    {
        $link = $this->connectionManager->getCurrentConnection();
        
        if (!$link) {
            return addslashes($escapestr);
        }
        
        return mysqli_real_escape_string($link, $escapestr);
    }
    
    /**
     * {@inheritdoc}
     */
    public function fetchArray($result, $resulttype = MYSQLI_BOTH)
    {
        return mysqli_fetch_array($result, $resulttype);
    }
    
    /**
     * {@inheritdoc}
     */
    public function fetchAssoc($result)
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * {@inheritdoc}
     */
    public function fetchField($result, $field_offset = null)
    {
        if (!empty($field_offset)) {
            for ($x = 0; $x < $field_offset; $x++) {
                mysqli_fetch_field($result);
            }
        }
        
        return mysqli_fetch_field($result);
    }
    
    /**
     * {@inheritdoc}
     */
    public function fetchLengths($result)
    {
        return mysqli_fetch_lengths($result);
    }
    
    /**
     * {@inheritdoc}
     */
    public function fetchObject($result, $class_name = 'stdClass', $params = [])
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        if (empty($params)) {
            return mysqli_fetch_object($result, $class_name);
        }
        
        return mysqli_fetch_object($result, $class_name, $params);
    }
    
    /**
     * {@inheritdoc}
     */
    public function fetchRow($result)
    {
        return mysqli_fetch_row($result);
    }
    
    /**
     * Get field flags as string
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return string Flag string
     */
    public function fieldFlags($result, $field_offset)
    {
        if (empty($this->flagCache)) {
            $this->initFlagCache();
        }
        
        $flags_num = mysqli_fetch_field_direct($result, $field_offset)->flags;
        
        $result = [];
        foreach ($this->flagCache as $n => $t) {
            if ($flags_num & $n) {
                $result[] = $t;
            }
        }
        
        $return = implode(' ', $result);
        $return = str_replace('PRI_KEY', 'PRIMARY_KEY', $return);
        $return = strtolower($return);
        
        return $return;
    }
    
    /**
     * Get field length
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return int Field length
     */
    public function fieldLen($result, $field_offset)
    {
        $fieldInfo = mysqli_fetch_field_direct($result, $field_offset);
        
        return $fieldInfo->length;
    }
    
    /**
     * Get field name
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return string Field name
     */
    public function fieldName($result, $field_offset)
    {
        $fieldInfo = mysqli_fetch_field_direct($result, $field_offset);
        
        return $fieldInfo->name;
    }
    
    /**
     * Set field cursor to specified offset
     * 
     * @param \mysqli_result $result Result resource
     * @param int $fieldnr Field number
     * @return bool TRUE on success or FALSE on failure
     */
    public function fieldSeek($result, $fieldnr)
    {
        return mysqli_field_seek($result, $fieldnr);
    }
    
    /**
     * Get field table
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return string Table name
     */
    public function fieldTable($result, $field_offset)
    {
        $fieldInfo = mysqli_fetch_field_direct($result, $field_offset);
        
        return $fieldInfo->table;
    }
    
    /**
     * Get field type
     * 
     * @param \mysqli_result $result Result resource
     * @param int $field_offset Field offset
     * @return string Field type
     */
    public function fieldType($result, $field_offset)
    {
        if (empty($this->typeCache)) {
            $this->initTypeCache();
        }
        
        $type_id = mysqli_fetch_field_direct($result, $field_offset)->type;
        
        return array_key_exists($type_id, $this->typeCache) ? $this->typeCache[$type_id] : null;
    }
    
    /**
     * Initialize flag cache
     * 
     * @return void
     */
    private function initFlagCache()
    {
        $constants = get_defined_constants(true);
        
        if (!isset($constants['mysqli'])) {
            return;
        }
        
        foreach ($constants['mysqli'] as $c => $n) {
            if (preg_match('/MYSQLI_(.*)_FLAG$/', $c, $m)) {
                if (!array_key_exists($n, $this->flagCache)) {
                    $this->flagCache[$n] = $m[1];
                }
            }
        }
    }
    
    /**
     * Initialize type cache
     * 
     * @return void
     */
    private function initTypeCache()
    {
        $constants = get_defined_constants(true);
        
        if (!isset($constants['mysqli'])) {
            return;
        }
        
        foreach ($constants['mysqli'] as $c => $n) {
            if (preg_match('/^MYSQLI_TYPE_(.*)/', $c, $m)) {
                $this->typeCache[$n] = $m[1];
            }
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function freeResult($result)
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        return mysqli_free_result($result);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getClientInfo()
    {
        $link = $this->connectionManager->getCurrentConnection();
        
        return mysqli_get_client_info($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getHostInfo($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_get_host_info($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getProtoInfo($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_get_proto_info($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getServerInfo($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_get_server_info($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function info($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_info($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function insertId($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_insert_id($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function listDbs($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        $query = "SHOW DATABASES";
        $r = mysqli_query($link, $query);
        
        if (empty(mysqli_errno($link))) {
            return $r;
        } else {
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function listFields($database_name, $table_name, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        $query = "SHOW COLUMNS FROM `" . $table_name . "`";
        $r = mysqli_query($link, $query);
        
        if (empty(mysqli_errno($link))) {
            return $r;
        } else {
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function listProcesses($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_thread_id($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function listTables($database, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        $query = "SHOW TABLES FROM `" . $database . "`";
        $r = mysqli_query($link, $query);
        
        if (empty(mysqli_errno($link))) {
            return $r;
        } else {
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function numFields($result)
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        return mysqli_num_fields($result);
    }
    
    /**
     * {@inheritdoc}
     */
    public function numRows($result)
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        return mysqli_num_rows($result);
    }
    
    /**
     * {@inheritdoc}
     */
    public function pconnect($host = '', $username = '', $passwd = '', $new_link = false, $client_flags = 0)
    {
        $link = mysqli_connect('p:' . $host, $username, $passwd);
        
        $this->connectionManager->setCurrentConnection($link);
        
        return $link;
    }
    
    /**
     * {@inheritdoc}
     */
    public function ping($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_ping($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function query($query, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        if (!$link || !($link instanceof \mysqli) || $link->connect_errno || !isset($link->host_info) || !@$link->ping()) {
            return false;
        }
        
        $r = mysqli_query($link, $query);
        return $r;
    }
    
    /**
     * {@inheritdoc}
     */
    public function realEscapeString($escapestr, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        if (!$link || !($link instanceof \mysqli) || $this->isClosing) {
            return addslashes($escapestr); // Safe fallback if connection is closed
        }
        
        return mysqli_real_escape_string($link, $escapestr);
    }
    
    /**
     * {@inheritdoc}
     */
    public function result($result, $row, $field = null)
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        mysqli_data_seek($result, $row);
        
        if (!empty($field)) {
            mysqli_field_seek($result, 0);
            while ($finfo = mysqli_fetch_field($result)) {
                if ($field == $finfo->name) {
                    $f = mysqli_fetch_assoc($result);
                    return $f[$field];
                }
            }
        }
        
        $f = mysqli_fetch_array($result);
        return $f[0];
    }
    
    /**
     * {@inheritdoc}
     */
    public function selectDb($dbname, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        if (!$link || !($link instanceof \mysqli)) {
            return false;
        }
        
        if (empty($dbname)) {
            return false;
        }
        
        try {
            return mysqli_select_db($link, $dbname);
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCharset($charset, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_set_charset($link, $charset);
    }
    
    /**
     * {@inheritdoc}
     */
    public function stat($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_stat($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function tablename($result, $row, $field = null)
    {
        if (!$result || !($result instanceof \mysqli_result)) {
            return false;
        }
        
        mysqli_data_seek($result, $row);
        $f = mysqli_fetch_array($result);
        
        return $f[0];
    }
    
    /**
     * {@inheritdoc}
     */
    public function threadId($link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        return mysqli_thread_id($link);
    }
    
    /**
     * {@inheritdoc}
     */
    public function unbufferedQuery($query, $link = null)
    {
        $link = $this->connectionManager->getConnection($link);
        
        $r = mysqli_query($link, $query, MYSQLI_USE_RESULT);
        
        return $r;
    }
} 