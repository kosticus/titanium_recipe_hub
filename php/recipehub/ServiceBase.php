<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class EmptyClass { }

class ServiceBase {
    // table name
    public $table;
    // primry key
    public $primaryKey;
    // array of columns in the class
    public $columns;
    
    
    /**
     * 
     */
    public function save() {
        
    }
    
    /*
     * 
     */
    public function fill($row) {
        $class = new EmptyClass;
        foreach ($columns as $column) {
            $class->$column = $row[$column];
        }
        return $class;
    }

    /**
     * 
     */
    public function loadParams() {
        foreach ($columns as $column) {
            
        }
    }
}