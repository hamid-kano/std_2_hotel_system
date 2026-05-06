<?php
/**
 * Database Configuration
 * Centralized database connection management
 */

class Database {
    private static $instance = null;
    private $connection;
    
    private $host = 'localhost';
    private $port = 3333;
    private $username = 'homework_std_ro_db';
    private $password = 'Hamid.1234!';
    private $database = 'homework_std_ro_db';
    
    private function __construct() {
        $this->connection = mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->database,
            $this->port
        );
        
        if (!$this->connection) {
            error_log("DB Connection failed: " . mysqli_connect_error());
            http_response_code(500);
            exit('Service temporarily unavailable.');
        }
        
        mysqli_set_charset($this->connection, 'utf8mb4');
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function select($sql, $values = [], $types = '') {
        $conn = $this->connection;
        
        if (empty($values)) {
            $result = mysqli_query($conn, $sql);
            return $result ?: false;
        }
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            if (!empty($values)) {
                mysqli_stmt_bind_param($stmt, $types, ...$values);
            }
            
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            } else {
                $error = mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
                error_log("Select execute failed: " . $error);
                return false;
            }
        } else {
            error_log("Select prepare failed: " . mysqli_error($conn));
            return false;
        }
    }
    
    public function insert($sql, $values, $types) {
        $conn = $this->connection;
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, $types, ...$values);
            
            if (mysqli_stmt_execute($stmt)) {
                $insertId = mysqli_insert_id($conn);
                mysqli_stmt_close($stmt);
                return $insertId;
            } else {
                $error = mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
                error_log("Insert execute failed: " . $error);
                return false;
            }
        } else {
            error_log("Insert prepare failed: " . mysqli_error($conn));
            return false;
        }
    }
    
    public function update($sql, $values, $types) {
        $conn = $this->connection;
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, $types, ...$values);
            
            if (mysqli_stmt_execute($stmt)) {
                $affected = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $affected;
            } else {
                $error = mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
                error_log("Update execute failed: " . $error);
                return false;
            }
        } else {
            error_log("Update prepare failed: " . mysqli_error($conn));
            return false;
        }
    }
    
    public function delete($sql, $values, $types) {
        return $this->update($sql, $values, $types);
    }
    
    public function selectAll($table) {
        $conn = $this->connection;
        $table = mysqli_real_escape_string($conn, $table);
        return mysqli_query($conn, "SELECT * FROM `$table`");
    }
    
    public function __destruct() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}
