<?php
/**
 * Base Model
 * All models extend this class
 */

abstract class Model {
    protected static $table = '';
    protected static $primaryKey = 'id';
    
    protected static function db() {
        return Database::getInstance();
    }
    
    public static function all() {
        return static::db()->selectAll(static::$table);
    }
    
    public static function find($id) {
        $result = static::db()->select(
            "SELECT * FROM `" . static::$table . "` WHERE `" . static::$primaryKey . "` = ? LIMIT 1",
            [$id],
            'i'
        );
        return $result ? mysqli_fetch_assoc($result) : null;
    }
    
    public static function findOrFail($id) {
        $record = static::find($id);
        if (!$record) {
            Response::notFound();
        }
        return $record;
    }
    
    public static function where($column, $value, $type = 's') {
        return static::db()->select(
            "SELECT * FROM `" . static::$table . "` WHERE `$column` = ?",
            [$value],
            $type
        );
    }
    
    public static function count($where = '', $values = [], $types = '') {
        $sql = "SELECT COUNT(*) as count FROM `" . static::$table . "`";
        if ($where) $sql .= " WHERE $where";
        
        $result = empty($values)
            ? static::db()->select($sql)
            : static::db()->select($sql, $values, $types);
        
        $row = mysqli_fetch_assoc($result);
        return (int)($row['count'] ?? 0);
    }
    
    public static function create($data, $types) {
        $columns = implode('`, `', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO `" . static::$table . "` (`$columns`) VALUES ($placeholders)";
        
        return static::db()->insert($sql, array_values($data), $types);
    }
    
    public static function updateById($id, $data, $types) {
        $sets = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE `" . static::$table . "` SET $sets WHERE `" . static::$primaryKey . "` = ?";
        
        return static::db()->update($sql, [...array_values($data), $id], $types . 'i');
    }
    
    public static function deleteById($id) {
        return static::db()->delete(
            "DELETE FROM `" . static::$table . "` WHERE `" . static::$primaryKey . "` = ?",
            [$id],
            'i'
        );
    }
    
    public static function raw($sql, $values = [], $types = '') {
        return empty($values)
            ? static::db()->select($sql)
            : static::db()->select($sql, $values, $types);
    }
    
    public static function fetchAll($result) {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
    
    public static function fetchOne($result) {
        return $result ? mysqli_fetch_assoc($result) : null;
    }
}
