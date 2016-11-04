<?php

require_once  __DIR__.'/DB.php';
$sql = <<<SQL
    SELECT recipe_item_category.recipe_id, 
           recipe_item_category.category_id, 
           recipe_category.name as category_name
    FROM recipe_item_category 
    INNER JOIN recipe_category ON recipe_item_category.category_id = recipe_category.category_id
SQL;


class RecipeCategory {
    public $category_id;
    public $name;
}


class Category implements IServices {
    // two fields for the recipe_item_category table
    public $recipe_id;
    public $category_id;
    // this will be filled by an inner join with the recipe_category table
    public $category_name;
    
    public function __construct() { }
    
    
    /**
     * Insert object into the recipe_item_category into the database
     */
    public function save() {
        // get the sql connnection
        $conn = DBHelper::getConnection();
        // sql query        
        $sql = "INSERT INTO recipe_item_category (recipe_id, category_id) VALUES (?,?);";
        // create the prepare statement
        $stmt = $conn->prepare($sql);
        // bind the parameters
        $stmt->bind_param('ii', 
                $this->recipe_id, 
                $this->category_id);
        // execute the query
        $stmt->execute();
        // release the connection
        $conn = null;
    }
  
    
    /**
     * Deletes item from the recipe item category table
     * @param integer $recipe_id
     */
    public static function removeAll($recipe_id) {
        
        $sql = "DELETE FROM recipe_item_category WHERE recipe_id = ?; ";
        $conn = DBHelper::getConnection();
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $this->recipe_id);
        $stmt->execute();
        // release the connection
        $conn = null;
    }

  
    /**
     * retrieves all categories from the database
     * @param type $recipe_id
     * @return array
     */
    public static function getAll($id) {
        global $sql;
        $query = $sql . " WHERE recipe_id = :recipe_id; ";
        return DBHelper::getAll($query, $id, 'Category');
    }
    
   /**
    * fills the values with a sql object row
    * @param type $row
    */
    public function fill($row) {
        $this->recipe_id = $row['recipe_id'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }
    
    
    /**
     * get all of the categories from the recipe_categories table
     * note this is different from the other files because 
     */
    public static function getCategories() {
        $conn = DBHelper::getPDODB();
        $sql = "SELECT `category_id`, `name` FROM recipe_category ORDER BY `name`;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // retrieve all of the rows
        $rows = $stmt->fetchAll();
        // iterate through the rows and create object
        $categories = array();
        
        foreach ($rows as $row) {
            $category = new RecipeCategory();
            $category->category_id = $row['category_id'];
            $category->name = $row['name'];
            array_push($categories, $category);
        }
        // release the connection
        $conn = null;
        // return the objects
        return $categories;
        
    }
    
    
}




if (basename(__FILE__, '.php') === basename($_SERVER['SCRIPT_FILENAME'], '.php'))
{
    try {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            echo json_encode(Category::getCategories());
        }
    } catch (Exception $ex) {
        print_r($ex);
    }
    
}