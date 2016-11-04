<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once  __DIR__.'/DB.php';
require_once  __DIR__.'/User.php';
require_once  __DIR__.'/Ingredient.php';
require_once  __DIR__.'/Instruction.php';
require_once  __DIR__.'/Category.php';
require_once  __DIR__.'/Rating.php';


class Recipe implements IServices  {
    public $recipe_id;
    public $title;
    public $description;
    public $author_id;
    public $author;
    public $prep_time;
    public $cook_time;
    public $serving_size;
    public $thumbnail;
    public $rating;

    // array of separate objects
    public $ingredients;
    public $instructions;
    public $categories;
    
    public function __construct($id = null) {
        $this->categories = array();
        $this->instructions = array();
        $this->ingredients = array();
        $this->rating = new Rating;
        if (!empty($id)) {
            $this->getById($id);
        }
        
    }
    
    
    public function getById($id) {
        $query = " SELECT * FROM recipe_item WHERE recipe_id = :recipe_id; ";
        $params = array(":recipe_id"=> $id);
        DBHelper::getById($query, $params, $this);
    }
    
    
    public function save() {
        $conn = DBHelper::getConnection();
        if (isset($this->recipe_id)) {
            // UPDATE            
            $sql = "UPDATE recipe_item SET ".
                        "title = ?, description = ?, author_id = ? ".
                        "prep_time = ?, cook_time = ?, serving_size = ?, thumbnail = ? ".
                   "WHERE recipe_id = ?; ";
            
            $stmt = $conn->prepare($sql);
            
            $stmt->bind_param('ssiiiiib', $this->title, $this->description, 
                    $this->author_id, $this->prep_time, $this->cook_time, $this->serving_size, 
                    $this->recipe_id, $encodedData);
            $stmt->execute();
        } else {
            // INSERT
            $sql = "INSERT INTO recipe_item (title,description,author_id, prep_time, cook_time, serving_size) ".
                   "VALUES (?,?,?,?,?,?);";
            $imagedata = $this->thumbnail;
            
            $this->thumbnail = '/Images/recipe-';

            // $encodedData= chunk_split($this->thumbnail);
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssiiii', $this->title, $this->description, 
                    $this->author_id, $this->prep_time, $this->cook_time, $this->serving_size);
            $stmt->execute();
            $this->recipe_id = $stmt->insert_id;
            
            
            // list($type, $imagedata) = explode(';', $imagedata);
            // list(, $imagedata)      = explode(',', $imagedata);
            $imagedata = base64_decode($imagedata);
            $imgpath = __DIR__.$this->thumbnail.$this->recipe_id.".png";
            
            file_put_contents($imgpath, $imagedata);
            
            if ($this->recipe_id) {
                
                foreach ($this->instructions as $instruction_data) {
                    $instruction = new Instruction();
                    $instruction->recipe_id = $this->recipe_id;
                    $instruction->instruction_index = $instruction_data['instruction_index'];
                    $instruction->instruction = $instruction_data['instruction'];
                    $instruction->save();
                }

                foreach ($this->ingredients as $ingredient_data) {
                    $ingredient = new Ingredient();
                    $ingredient->recipe_id = $this->recipe_id;
                    $ingredient->amount = $ingredient_data['amount'];
                    $ingredient->unit_id = $ingredient_data['unit_id'];
                    $ingredient->ingredient = $ingredient_data['ingredient'];
                    $ingredient->save();
                }

                foreach ($this->categories as $category_id) {
                    $category = new Category();
                    $category->category_id = $category_id;
                    $category->recipe_id = $this->recipe_id;
                    $category->save();
                }                
            }
            
            
        }
        
        $conn = null;
    }
    
    public static function getAll($search = "null", $filterBy = "null", $sortBy = "null", $limit = 20, $offset = 0) {
        
        
        $where = "";
        $params = array();
        
        if ($filterBy != "null" || $search != "null") {
            $where .= " WHERE ";
            
            if ($filterBy != "null") {
                $filterParts = explode(' ', $filterBy);
                $eq = "";

                switch ($filterParts[1]) {
                    case "eq" : $eq = "="; break;
                    case "neq" : $eq = "!="; break;
                    case "gt" : $eq = ">"; break;
                    case "lt" : $eq = "<"; break;
                    default : break;
                }
                $where .= " ($filterParts[0] $eq $filterParts[2]) ";
            }
            
            if ($filterBy != "null" && $search != "null") {
                $where .= " and ";
            }
            
            if ($search != "null") {
                $where .= " (recipe_item.title LIKE '%$search%') ";
            }
            
        }
        
        
        
        if ($sortBy === "null") {
            $sortBy = " ORDER BY recipe_created_ts DESC, rating_avg DESC ";
        } else {
            $sortBy = " ORDER BY $sortBy ";
        }
        
        $sql = " SELECT recipe_item.*, rv.avg as rating_avg, rv.count as rating_count ".
               " FROM recipe_item ".
               " INNER JOIN recipe_item_category ric ON ric.recipe_id = recipe_item.recipe_id ".
               " LEFT JOIN vw_recipe_rating_view rv ON rv.recipe_id = recipe_item.recipe_id ".
               " $where ".
               " $sortBy ".
               " LIMIT $limit OFFSET $offset ; ";
        
        
        
        $conn = DBHelper::getPDODB();
        // build filter
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        // 
        // $stmt->execute(array(':limit' => $limit, ':offset'=>$offset));
        // 
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $recipes = array();
        foreach ($rows as $row) {
            $recipe = new Recipe();
            $recipe->fill($row);
            array_push($recipes, $recipe);
        }
        return $recipes;
    }
    
    public function fill($row) {
        $this->recipe_id = $row['recipe_id'];
        $this->title = $row['title'];
        $this->description = $row['description'];
        
        $this->author_id = $row['author_id'];
        $this->author = new User($row['author_id']);
        $this->rating = Rating::getRecipeRating($this->recipe_id);
        $this->prep_time  = $row['prep_time'];
        $this->cook_time  = $row['cook_time'];
        $this->serving_size = $row['serving_size'];
        $this->thumbnail = "/Images/recipe-$this->recipe_id.png";
        
        $this->instructions = Instruction::getAll($this->recipe_id);
        $this->ingredients = Ingredient::getAll($this->recipe_id);
        $this->categories  = Category::getAll($this->recipe_id);
    }
}


if (basename(__FILE__, '.php') === basename($_SERVER['SCRIPT_FILENAME'], '.php')) {
    
    if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST')  {
        parse_str(file_get_contents("php://input"), $DATA); 
        $recipe = new Recipe();
        if (isset($DATA['recipe_id'])) {
            $recipe->recipe_id = $DATA['recipe_id'];
        }
        $recipe->title = $DATA['title'];
        $recipe->description = $DATA['description'];
        $recipe->author_id = $DATA['author_id'];
        $recipe->prep_time = $DATA['prep_time'];
        $recipe->cook_time = $DATA['cook_time'];
        $recipe->serving_size = $DATA['serving_size'];
        $recipe->thumbnail = $DATA['thumbnail'];    
        $recipe->ingredients = json_decode($DATA['ingredients'], true);
        $recipe->instructions = json_decode($DATA['instructions'], true);
        $recipe->categories = json_decode($DATA['categories'], true);
        // echo gettype($recipe->ingredients);
        $recipe->save();
        echo json_encode($recipe);
        return;
    }


    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // return a single row
        if (isset($_GET['recipe_id'])) {
            $recipe = new Recipe($_GET['recipe_id']);
            echo json_encode($recipe);
        } else {
            $filterBy = null;
            $sortBy = null;
            $search = null;
            $limit = 10;
            $offset = 0;
            $user_id = null;
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
            }

            if (isset($_GET['filterBy'])) {
                $filterBy = $_GET['filterBy'];
            }
            if (isset($_GET['sortBy'])) {
                $sortBy = $_GET['sortBy'];
            }
            // get limit
            if (isset($_GET['limit'])) {
                $limit = $_GET['limit'];
            } 
            // get limit
            if (isset($_GET['offset'])) {
                $offset = $_GET['offset'];
            } 

            // user_id
            if (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
            } 
            echo json_encode(Recipe::getAll($search, $filterBy, $sortBy, $limit, $offset, $user_id));
        }

        // filterBy=category_id eq 2,descript

    }
}