<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once  __DIR__.'/DB.php';

class Amount {
    public $amount;
    public static function GetAll() {
        
        $sql = "SELECT amount FROM recipe_item_ingredient_amount; ";
        $conn = DBHelper::getPDODB();
        // build filter
        $stmt = $conn->prepare($sql);
        $stmt->execute(array());

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $amounts = array();
        foreach ($rows as $row) {
            $amount = new Amount();
            $amount->amount = $row['amount'];
            array_push($amounts, $amount);
        }
        return $amounts;
        
    }
    
}

class Unit {
    public $unit_id;
    public $name_abbr;
    public $name_full;
    
    public static function GetAll() {
        $sql = "SELECT * FROM recipe_item_ingredient_unit; ";
        $conn = DBHelper::getPDODB();
        // build filter
        $stmt = $conn->prepare($sql);
        $stmt->execute(array());

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $units = array();
        foreach ($rows as $row) {
            $unit = new Unit();
            $unit->unit_id = $row['unit_id'];
            $unit->name_abbr = $row['name_abbr'];
            $unit->name_full = $row['name_full'];
            array_push($units, $unit);
        }
        return $units;
    }
    
}

class Measurement {
    
    public function __construct() {
        $this->units = Unit::GetAll();
        $this->amounts = Amount::GetAll();
    }
    public $units;
    public $amounts;
}


$measurement = new Measurement();
echo json_encode($measurement);