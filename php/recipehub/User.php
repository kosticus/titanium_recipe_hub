<?php

/*


*/


$_username; $_password;
if (isset($_SERVER['PHP_AUTH_USER'])) {
    $_username = $_SERVER['PHP_AUTH_USER'];
    $_password = $_SERVER['PHP_AUTH_PW'];
}
            
            




/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once  __DIR__.'/DB.php';

class Auth1 {    
    public $email;
    public $salt;
    public $success;
    
    public function __construct() {
        $this->success = false;
    }
}

class Auth2 {
    public $user_id;
    public $email;
    public $success;
    
    public function __construct() {
        $this->success = false;
    }
}


class User  {
    public $user_id;
    public $email;
    public $password_salt;
    public $password_hash;

    
    public function __construct($id=null) {
        if ($id !== null) {
           $this->getById($id); 
           return;
        }
    }
    
    public static function authenticatePart1($email) {
        $sql = "SELECT user_id, email, password_salt, password_hash ".
               "FROM recipe_user ".
               "WHERE email = :email;";
        $conn = DBHelper::getPDODB();
        // build filter
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':email' => $email));
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
        $conn = null;
        
        $auth = new Auth1();
        $user = new User;
        if ($row != null) {
            $user->fill($row);
            $auth->success = true;
            $auth->email = $user->email;
            $auth->salt = $user->password_salt;        
            return $auth;
        } else {
            $auth->success = false;
            return $auth;
        }
        
        
        
    }
    
    public static function authenticatePart2($email, $hash) {
        $sql = "SELECT user_id, email, password_salt, password_hash ".
               "FROM recipe_user ".
               "WHERE email = :email and password_hash = :hash;";
        $conn = DBHelper::getPDODB();
        // build filter
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':email' => $email, ':hash'=>$hash));
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
        $conn = null;
        
        $user = new User;
        $auth = new Auth2();
        if ($row != null) {
            $user->fill($row);
            $auth->success = true;
            $auth->email = $user->email;
            $auth->user_id = $user->user_id;        
        } else {
            $auth->success = false;
            return $auth;
        }
        return $auth;
    }
    
    public function save() {
        
        $conn = DBHelper::getConnection();
        if (isset($this->user_id)) {
            $sql = "UPDATE recipe_user SET password_salt = ?, password_hash = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssi', $this->password_salt, $this->password_hash, $this->user_id);
            $stmt->execute();
        } else {
            $sql = "INSERT INTO recipe_user (email, password_salt, password_hash) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $this->email, $this->password_salt, $this->password_hash);
            $stmt->execute();
            $this->user_id = $stmt->insert_id;
        }
        $conn = null;
        
    }
    

    
    public function getById($id) {
        $query = "SELECT * FROM recipe_user WHERE user_id = :user_id";
        $params = array(':user_id' => $id);
        DBHelper::getById($query, $params, $this);
    }
    
    public function fill($row) {
        $this->user_id = $row['user_id'];
        $this->email = $row['email'];
        $this->password_salt = $row['password_salt'];
        $this->password_hash = $row['password_hash'];
    }
    
}

if (basename(__FILE__, '.php') === basename($_SERVER['SCRIPT_FILENAME'], '.php'))
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
        $user = new User;
        $user->email = $_username;
        $user->password_salt = $_POST['password_salt'];
        $user->password_hash = $_password;
        $user->save();

        echo json_encode($user);
    } 

    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $user = new User;
        //
        parse_str(file_get_contents("php://input"),$PUT); 
        $user->user_id = $PUT['user_id'];
        $user->email = $_username;
        $user->password_salt = $PUT['password_salt'];
        $user->password_hash = $_password;
        
        $user->save();

        echo json_encode($user);
    } 

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['user_id'])) {
            $user = new User($_GET['user_id']);
            echo json_encode($user);
        } 
        
        
        if (isset($_GET['auth'])) {
            $email = $_GET['auth'];
            echo json_encode(User::authenticatePart1($email));
        } else {
            if (!empty($_username) && !empty($_password)) {
                echo json_encode(User::authenticatePart2($_username, $_password));
            }           
        }
        
        
    }
}