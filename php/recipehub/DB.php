<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
const DB_LOCAL = true;
class DBHelper {
    
    /**
     * 
     * @return \mysqli
     */
    public static function getConnection() {
        if (DB_LOCAL) {
            $conn = new mysqli('127.0.0.1', 'USER_NAME', 'PASSWORD', 'DB_NAME');
        } else {
            // REMOVED FOR SECURITY
        }
        
        // 
        if ($conn->connect_errno > 0) {
            die('Unable to connect to database [' . $this->conn->connect_error . ']');
        }
        return $conn;
    }
    
    /**
     * 
     * @param type $query
     * @param type $recipe_id
     * @param type $objectClass
     * @return array
     */
    public static function getAll($query, $recipe_id, $objectClass) {
        $db = DBHelper::getPDODB();
        $stmt = $db->prepare($query);
        // prepare the statement and bind parameters
        $stmt->execute(array(':recipe_id' => $recipe_id));
        // retrieve all of the rows
       
        $rows = $stmt->fetchAll();
        // iterate through the rows and create object
        $array = array();
        foreach ($rows as $row) {
            $obj = new $objectClass;
            $obj->fill($row);
            array_push($array, $obj);
        }
        // close the database connection
        $db = null;
        // return the objects
        return $array;
    }
    
    /**
     * 
     * @param type $query
     * @param type $params
     * @param type $obj
     */
    public static function getById($query, $params, $obj) {
        //  create a PDO connection
        $db = DBHelper::getPDODB();
        // prepare the statement and bind parameters
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        // get the single row
        $row = $stmt->fetch();
        //
        $obj->fill($row);
        // close connection
        $db = null; 
    }
    
    /**
     * 
     * @return \PDO
     */
    public static function getPDODB() {
        if (DB_LOCAL) {
            
            return new PDO('mysql:host=127.0.0.1;dbname=DB_NAME','USERNAME','PASSWORD');
        }
        // REMOVED FOR SECURITY
    }
}



/**
 * Interface required for all web service classes
 */
interface IServices  {
    public function save();
    public function fill($row);
}