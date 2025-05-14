<?php

namespace Mysql2i\Compatibility;

use Mysql2i\Core\AdapterFactory;

/**
 * Functions class
 * 
 * Provides compatibility layer for mysql functions
 */
class Functions
{
    /**
     * Register all mysql functions
     * 
     * @return void
     */
    public static function register()
    {
        // Only register if mysql extension is not loaded
        if (extension_loaded('mysql')) {
            return;
        }
        
        // Get a reference to the adapter
        $adapter = AdapterFactory::getAdapter();
        
        // Define function mappings
        $functions = [
            'mysql_affected_rows'      => 'affectedRows',
            'mysql_client_encoding'    => 'clientEncoding',
            'mysql_close'              => 'close',
            'mysql_connect'            => 'connect',
            'mysql_create_db'          => 'createDb',
            'mysql_data_seek'          => 'dataSeek',
            'mysql_db_name'            => 'dbName',
            'mysql_db_query'           => 'dbQuery',
            'mysql_drop_db'            => 'dropDb',
            'mysql_errno'              => 'errno',
            'mysql_error'              => 'error',
            'mysql_escape_string'      => 'escapeString',
            'mysql_fetch_array'        => 'fetchArray',
            'mysql_fetch_assoc'        => 'fetchAssoc',
            'mysql_fetch_field'        => 'fetchField',
            'mysql_fetch_lengths'      => 'fetchLengths',
            'mysql_fetch_object'       => 'fetchObject',
            'mysql_fetch_row'          => 'fetchRow',
            'mysql_field_flags'        => 'fieldFlags',
            'mysql_field_len'          => 'fieldLen',
            'mysql_field_name'         => 'fieldName',
            'mysql_field_seek'         => 'fieldSeek',
            'mysql_field_table'        => 'fieldTable',
            'mysql_field_type'         => 'fieldType',
            'mysql_free_result'        => 'freeResult',
            'mysql_get_client_info'    => 'getClientInfo',
            'mysql_get_host_info'      => 'getHostInfo',
            'mysql_get_proto_info'     => 'getProtoInfo',
            'mysql_get_server_info'    => 'getServerInfo',
            'mysql_info'               => 'info',
            'mysql_insert_id'          => 'insertId',
            'mysql_list_dbs'           => 'listDbs',
            'mysql_list_fields'        => 'listFields',
            'mysql_list_processes'     => 'listProcesses',
            'mysql_list_tables'        => 'listTables',
            'mysql_num_fields'         => 'numFields',
            'mysql_num_rows'           => 'numRows',
            'mysql_pconnect'           => 'pconnect',
            'mysql_ping'               => 'ping',
            'mysql_query'              => 'query',
            'mysql_real_escape_string' => 'realEscapeString',
            'mysql_result'             => 'result',
            'mysql_select_db'          => 'selectDb',
            'mysql_set_charset'        => 'setCharset',
            'mysql_stat'               => 'stat',
            'mysql_tablename'          => 'tablename',
            'mysql_thread_id'          => 'threadId',
            'mysql_unbuffered_query'   => 'unbufferedQuery',
        ];
        
        // Create functions in global namespace
        foreach ($functions as $mysqlFunc => $adapterMethod) {
            if (!function_exists($mysqlFunc)) {
                self::createFunction($mysqlFunc, $adapterMethod);
            }
        }
    }
    
    /**
     * Create a mysql function with the given name
     * 
     * @param string $functionName Name of function to create
     * @param string $methodName Name of adapter method to call
     * @return void
     */
    private static function createFunction($functionName, $methodName)
    {
        // Create a global function with a reference to the adapter
        $code = sprintf('
            function %s() {
                $adapter = \Mysql2i\Core\AdapterFactory::getAdapter();
                $args = func_get_args();
                return call_user_func_array([$adapter, "%s"], $args);
            }
        ', $functionName, $methodName);
        
        eval($code);
    }
} 