<?php
/**
 * Validator
 * Advanced validation rules
 */

class Validator {
    
    private $data;
    private $rules;
    private $errors = [];
    
    public function __construct($data, $rules) {
        $this->data = $data;
        $this->rules = $rules;
    }
    
    public function validate() {
        foreach ($this->rules as $field => $ruleString) {
            $value = $this->data[$field] ?? null;
            $rules = explode('|', $ruleString);
            
            foreach ($rules as $rule) {
                $this->applyRule($field, $value, $rule);
            }
        }
        
        return empty($this->errors);
    }
    
    private function applyRule($field, $value, $rule) {
        if (str_contains($rule, ':')) {
            [$ruleName, $param] = explode(':', $rule, 2);
        } else {
            $ruleName = $rule;
            $param = null;
        }
        
        switch ($ruleName) {
            case 'required':
                if (empty($value) && $value !== '0') {
                    $this->addError($field, "$field is required");
                }
                break;
                
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "$field must be a valid email");
                }
                break;
                
            case 'min':
                if (!empty($value) && strlen($value) < (int)$param) {
                    $this->addError($field, "$field must be at least $param characters");
                }
                break;
                
            case 'max':
                if (!empty($value) && strlen($value) > (int)$param) {
                    $this->addError($field, "$field must not exceed $param characters");
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $this->addError($field, "$field must be numeric");
                }
                break;
                
            case 'integer':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_INT)) {
                    $this->addError($field, "$field must be an integer");
                }
                break;
                
            case 'date':
                if (!empty($value) && !strtotime($value)) {
                    $this->addError($field, "$field must be a valid date");
                }
                break;
                
            case 'after':
                if (!empty($value)) {
                    $compareDate = $this->data[$param] ?? null;
                    if ($compareDate && strtotime($value) <= strtotime($compareDate)) {
                        $this->addError($field, "$field must be after $param");
                    }
                }
                break;
                
            case 'before':
                if (!empty($value)) {
                    $compareDate = $this->data[$param] ?? null;
                    if ($compareDate && strtotime($value) >= strtotime($compareDate)) {
                        $this->addError($field, "$field must be before $param");
                    }
                }
                break;
                
            case 'in':
                $allowed = explode(',', $param);
                if (!empty($value) && !in_array($value, $allowed)) {
                    $this->addError($field, "$field must be one of: " . implode(', ', $allowed));
                }
                break;
                
            case 'unique':
                // Format: unique:table,column
                [$table, $column] = explode(',', $param);
                $db = Database::getInstance();
                $result = $db->select(
                    "SELECT COUNT(*) as count FROM `$table` WHERE `$column` = ?",
                    [$value],
                    's'
                );
                $row = mysqli_fetch_assoc($result);
                if ($row['count'] > 0) {
                    $this->addError($field, "$field already exists");
                }
                break;
        }
    }
    
    private function addError($field, $message) {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }
    
    public function errors() {
        return $this->errors;
    }
    
    public static function make($data, $rules) {
        $validator = new self($data, $rules);
        $validator->validate();
        return $validator;
    }
}
