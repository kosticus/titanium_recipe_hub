<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once  __DIR__.'/DB.php';

class RecipeRating {
    public $count;
    public $avg;
    public $recipe_id;
    
};
class Rating  {
    public $user_id;
    public $recipe_id;
    public $rating;

    
    public function __construct($id=null) {
        if ($id !== null) {
           $this->getById($id); 
           return;
        }
    }
    
    public function save() {
        $conn = DBHelper::getConnection();
        
        $recipe = Rating::getRating($this->recipe_id, $this->user_id);
        
        if ($recipe !== null) {
            $sql = "UPDATE recipe_rating SET rating = ? WHERE recipe_id = ? AND user_id = ?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iii', $this->rating, $this->recipe_id, $this->user_id);
            $stmt->execute();
        } else {
            $sql = "INSERT INTO recipe_rating (rating,recipe_id,user_id) VALUES (?,?,?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iii', $this->rating, $this->recipe_id, $this->user_id);
            $stmt->execute();
            
        }        
        $conn = null;
    }
    
    public static function getRating($recipe_id, $user_id) {
        $query = " SELECT * ".
                 " FROM recipe_rating ".
                 " WHERE recipe_id = :recipe_id and user_id = :user_id; ";
        $params = array(":recipe_id"=>$recipe_id, ":user_id"=>$user_id);
        
        $db = DBHelper::getPDODB();
        // prepare the statement and bind parameters
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        

        // get the single row
        $row = $stmt->fetch();

        // close connection
        $db = null; 
        
        if (empty($row)) {
            return null;
        }
        
        
        $rating = new Rating;
        $rating->rating = $row['rating'];
        $rating->recipe_id = $row['recipe_id'];
        $rating->user_id = $row['user_id'];
        
        
        
        return $rating;
    }
    
    public static function getRecipeRating($recipe_id) {
        $query = "SELECT count(*) as count, avg(rating) as avg FROM recipe_rating WHERE recipe_id = :recipe_id; ";
        $params = array(":recipe_id"=>$recipe_id);
        
        $db = DBHelper::getPDODB();
        // prepare the statement and bind parameters
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        // get the single row
        $row = $stmt->fetch();
        
        $rating = new RecipeRating;
        $rating->avg = $row['avg'];
        $rating->count = $row['count'];
        $rating->recipe_id = $recipe_id;
        // close connection
        $db = null; 
        return $rating;
    }

    
    public static function getAll($user_id) {
        
        $sql = "SELECT * FROM recipe_rating WHERE user_id = :user_id ; ";
        $conn = DBHelper::getPDODB();
        // build filter
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':user_id' => $user_id));

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $ratings = array();
        foreach ($rows as $row) {
            $rating = new Rating();
            $rating->fill($row);
            array_push($ratings, $rating);
        }
        return $ratings;
    }
    
    public function fill($row) {
        $this->user_id = $row['user_id'];
        $this->rating = $row['rating'];
        $this->recipe_id = $row['recipe_id'];
    }
    
}

if (basename(__FILE__, '.php') === basename($_SERVER['SCRIPT_FILENAME'], '.php'))
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
        try
        {
            $rating = new Rating();
            $rating->user_id = $_POST['user_id'];
            $rating->rating = $_POST['rating'];
            $rating->recipe_id = $_POST['recipe_id'];
            $rating->save(); 
            echo json_encode(Rating::getRecipeRating($rating->recipe_id));
        } catch (Exception $ex) {
            echo '{}';
        }
        

        
    } 
    

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      echo json_encode(Rating::getAll($_GET['user_id']));

    }
}