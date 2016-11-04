<?php
    

require_once  __DIR__.'/DB.php';





class Instruction implements IServices {
    public $recipe_id;
    public $instruction_index;
    public $instruction;

    public function __construct() {
    }
    
    public function getById($id) {
        
    }
  
    public static function getAll($recipe_id) {
        $query = " SELECT * FROM recipe_item_instruction ".
                 " WHERE recipe_id = :recipe_id ".
                 " ORDER BY instruction_index; ";
        
        return DBHelper::getAll($query, $recipe_id, 'Instruction');
    }
    
    /**
     * Saves the Instruction object
     */
    public function save() {
        $conn = DBHelper::getConnection();
        $sql = "INSERT INTO recipe_item_instruction (recipe_id, instruction_index, instruction) ".
               "VALUES (?,?,?);";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iis', 
                $this->recipe_id, 
                $this->instruction_index, 
                $this->instruction);
        $stmt->execute();
        $conn = null;
    }
  
    /**
     * Delete
     * @param integer $recipe_id
     */
    public static function removeAll($recipe_id) {
        
        $sql = "DELETE FROM recipe_item_instruction WHERE recipe_id = ?; ";
        $conn = DBHelper::getConnection();
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $this->recipe_id);
        $stmt->execute();
        $conn = null;
    }
  
  /**
   * Fills the Instruction object from a SQL row
   * @param type $row
   */
    public function fill($row) {
        $this->recipe_id = $row['recipe_id'];
        $this->instruction_index = $row['instruction_index'];
        $this->instruction = $row['instruction'];
    }
}
