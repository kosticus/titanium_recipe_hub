<?php

require_once  __DIR__.'/DB.php';

class Ingredient implements IServices {
    public $recipe_item_ingredient_id;
    public $recipe_id;
    public $amount;
    public $unit_id;
    public $unit_name_abbr;
    public $ingredient;

    public function save() {
        $conn = DBHelper::getConnection();
        $sql = " INSERT INTO recipe_item_ingredient (recipe_id, amount, unit_id, ingredient) ".
               " VALUES (?,?,?,?); ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isis', 
                $this->recipe_id, 
                $this->amount, 
                $this->unit_id, 
                $this->ingredient);
        
        $stmt->execute();
        
        $this->recipe_item_ingredient_id = $stmt->insert_id;
        
        $conn = null;
    }

    /**
     * Delete
     * @param integer $recipe_id
     */
    public static function removeAll($recipe_id) {
        
        $sql = "DELETE FROM recipe_item_ingredient WHERE recipe_id = ?; ";
        $conn = DBHelper::getConnection();
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $this->recipe_id);
        $stmt->execute();
        $conn = null;
    }
    
    public static function getAll($id) {
        $query = "SELECT ".
                   " recipe_item_ingredient.recipe_item_ingredient_id, ".
                   " recipe_item_ingredient.recipe_id, ".
                   " recipe_item_ingredient.amount, ".
                   " recipe_item_ingredient.unit_id, ".
                   " recipe_item_ingredient.ingredient, ".
                   " recipe_item_ingredient_unit.name_abbr as unit_name_abbr".
                   " FROM recipe_item_ingredient ".
                   " LEFT JOIN recipe_item_ingredient_unit ON recipe_item_ingredient_unit.unit_id = recipe_item_ingredient.unit_id ".
                   " WHERE recipe_item_ingredient.recipe_id = :recipe_id;";
        return DBHelper::getAll($query, $id, 'Ingredient');
    }
    
    public function fill($row) {

        $this->recipe_item_ingredient_id = $row['recipe_item_ingredient_id'];
        $this->recipe_id = $row['recipe_id'];
        $this->amount = $row['amount'];
        if (isset($row['unit_id'])) {
            $this->unit_id = $row['unit_id'];
        }
        if (isset($row['unit_name_abbr'])) {
            $this->unit_name_abbr = $row['unit_name_abbr'];
        }
         $this->ingredient  = $row['ingredient'];
    }
}