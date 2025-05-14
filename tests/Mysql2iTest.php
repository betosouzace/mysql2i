<?php

/**
 * Basic tests for Mysql2i library
 */
class Mysql2iTest
{
    /**
     * Test that constants are defined
     * 
     * @return bool
     */
    public function testConstants()
    {
        require_once __DIR__ . '/../src/bootstrap.php';
        
        $constants = [
            'MYSQL_BOTH',
            'MYSQL_NUM',
            'MYSQL_ASSOC',
            'MYSQL_CLIENT_COMPRESS',
            'MYSQL_CLIENT_SSL',
            'MYSQL_CLIENT_INTERACTIVE',
            'MYSQL_CLIENT_IGNORE_SPACE'
        ];
        
        $success = true;
        foreach ($constants as $constant) {
            if (!defined($constant)) {
                echo "Constant {$constant} is not defined\n";
                $success = false;
            }
        }
        
        if ($success) {
            echo "All constants are defined correctly\n";
        }
        
        return $success;
    }
    
    /**
     * Test that functions are defined
     * 
     * @return bool
     */
    public function testFunctions()
    {
        require_once __DIR__ . '/../src/bootstrap.php';
        
        $functions = [
            'mysql_affected_rows',
            'mysql_client_encoding',
            'mysql_close',
            'mysql_connect',
            'mysql_create_db',
            'mysql_data_seek',
            'mysql_db_name',
            'mysql_db_query',
            'mysql_drop_db',
            'mysql_errno',
            'mysql_error',
            'mysql_escape_string',
            'mysql_fetch_array',
            'mysql_fetch_assoc',
            'mysql_fetch_field',
            'mysql_fetch_lengths',
            'mysql_fetch_object',
            'mysql_fetch_row',
            'mysql_field_flags',
            'mysql_field_len',
            'mysql_field_name',
            'mysql_field_seek',
            'mysql_field_table',
            'mysql_field_type',
            'mysql_free_result',
            'mysql_get_client_info',
            'mysql_get_host_info',
            'mysql_get_proto_info',
            'mysql_get_server_info',
            'mysql_info',
            'mysql_insert_id',
            'mysql_list_dbs',
            'mysql_list_fields',
            'mysql_list_processes',
            'mysql_list_tables',
            'mysql_num_fields',
            'mysql_num_rows',
            'mysql_pconnect',
            'mysql_ping',
            'mysql_query',
            'mysql_real_escape_string',
            'mysql_result',
            'mysql_select_db',
            'mysql_set_charset',
            'mysql_stat',
            'mysql_tablename',
            'mysql_thread_id',
            'mysql_unbuffered_query'
        ];
        
        $success = true;
        foreach ($functions as $function) {
            if (!function_exists($function)) {
                echo "Function {$function} is not defined\n";
                $success = false;
            }
        }
        
        if ($success) {
            echo "All functions are defined correctly\n";
        }
        
        return $success;
    }
    
    /**
     * Run all tests
     */
    public function runTests()
    {
        $this->testConstants();
        $this->testFunctions();
    }
}

// Run tests when script is executed directly
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    $test = new Mysql2iTest();
    $test->runTests();
} 