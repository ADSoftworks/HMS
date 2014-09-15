<?php

/**
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 */
class User_model extends CI_Model {

    private /*int*/ $id,
            /*int*/ $group_id,
         /*String*/ $email;
    
    /*
     * Getters & Setters
     */
    public function getId()         { return $this->id;         }
    public function getGroupId()    { return $this->group_id;   }
    public function getEmail()      { return $this->email;      }
    
    function __construct() {
        
        parent::__construct();
        if($this->session->userdata("email"))
            $this->initialize();
        
    }
    
    /**
     * Initializes all class variables
     */
    private function initialize() {
        
        $user = $this->getCurrentUser();
        
        $this->id =         $user["id"];
        $this->group_id =   $user["group_id"];
        $this->email =      $user["email"];
        
    }
    
    /**
     * Returns whether the user is a docent or not.
     * 
     * @return type boolean
     */
    public function isDocent() {
        
        return $this->group_id == 1 ? true : false;
        
    }
    
    /**
     * Logs the user in.
     * 
     * @param type String $email
     * @param type String $password
     */
    public function login($email, $password) {
        
        if(isset($email) &&
           isset($password)) {
            
            $sql =    "SELECT * "
                    . "FROM users "
                    . "WHERE email = :email "
                    . "LIMIT 1;";
            
            $stmt = $this->db->conn_id->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            $encrypted_password = sha1($password);
            
            if($result["password"] == $encrypted_password) {
                
                
                
                $this->session->set_userdata("email", $result["email"]);
                
                if($result["group_id"] == 0) {
                
                    $this->session->set_userdata("warning", "Welcome student!");
                    header("Location: " . base_url() . "index.php/student");
                    exit();
                    
                } else if($result["group_id"] == 1) {
                    
                    $this->session->set_userdata("warning", "Welcome teacher!");
                    header("Location: " . base_url() . "index.php/docent");
                    exit();
                    
                }
                
            } else {
                
                $this->session->set_userdata("warning", "Wrong email or password.");
            
            }
            
        } else {
            
            $this->session->set_userdata("warning", "ERROR NO INPUT");
            
        }
            
    }
    
    /**
     * Logs the user out.
     */
    public function logout() {
        
        $this->session->unset_userdata("email");
        $this->session->set_userdata("warning", "You've been successfully logged out!");
        header("Location: " . base_url() . "index.php");
        exit();
        
    }
    
    public function authenticateCurrentUser($password) {
        
        $user = $this->session->userdata("email");
        
        if($user) {
            
            $sql =    "SELECT password "
                    . "FROM users "
                    . "WHERE email = :email "
                    . "LIMIT 1;";
            
            $stmt = $this->db->conn_id->prepare($sql);
            $stmt->bindParam(":email", $user, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            if($result["password"] == sha1($password)) {
                
                return true;
                
            }
            
            $this->session->set_userdata("warning", "The old password does not match.");
            return false;
            
        }
        
    }
    
    /**
     * Changes the password of a user in the database.
     * 
     * @param type String $email
     * @param type String $password
     */
    public function changePasswordByEmail($email, $password) {
        
        if(isset($email) &&
           isset($password)) {
        
            $encrypted_password = sha1($password);

            $sql =    "UPDATE users "
                    . "SET password = :password "
                    . "WHERE email = :email;";

            $stmt = $this->db->conn_id->prepare($sql);
            $stmt->bindParam(":password", $encrypted_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
        
            $this->session->set_userdata("warning", "Your password was successfully changed!");
            
       } else {
       
       $this->session->set_userdata("warning", "Could not change your password.");
        
       }
       
    }
    
    /**
     * Sends the email a random new password.
     * 
     * @param type String $email
     */
    public function sendNewPasswordByEmail($email) {
        
//        die(var_dump($email));
        
        if(isset($email)) {
        
            $new_pass = substr(md5(rand(0, 100)), 0, 8);

            if($this->exists($email)) {

                $this->changePasswordByEmail($email, $new_pass);

                $subject = "Vergeten wachtwoord";
                $message = "Hallo, uw nieuwe wachtwoord is: " . $new_pass;
                $headers = 'From: ' . MASTER_EMAIL . "\r\n" .
                            'Reply-To: ' . MASTER_EMAIL. '' . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                mail($email, $subject, $message, $headers);

                $this->session->set_userdata("warning", "Your new password has been sent!");

            } else {
                
                $this->session->set_userdata("warning", "There is no account found with this email address.");
                
            }

        }
        
    }
    
    /**
     * Returns whether the email address is already in use
     * by another user.
     * 
     * @param type String $email
     * @return type Boolean
     */
    public function exists($email) {
        
        if(isset($email)) {
            
            $sql =    "SELECT email "
                    . "FROM users "
                    . "WHERE email = :email "
                    . "LIMIT 1;";

            $stmt = $this->db->conn_id->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            return $result ? true : false;

        }
        
    }
    
    /**
     * Register a user into the database.
     * 
     * @param type $email
     * @param null $password
     * @param null $password_confirmation
     * @param type $firstname
     * @param type $lastname
     * @param type $group_id
     */
    public function register($email, $password, $password_confirmation, $firstname, $lastname, $group_id, $grade) {
        
        if(isset($email) && 
           isset($firstname) &&
           isset($lastname) &&
           isset($password) &&
           isset($password_confirmation) &&
           isset($group_id) &&
           isset($grade)) {
            
            if($password != $password_confirmation) {

                $this->session->set_userdata("warning", "The passwords do not match.");

            } else {

                if($this->exists($email)) {

                    $this->session->set_userdata("warning", "Account already exists.");

                } else {
                    
                    //capitalize the first letter of the names
                    $firstname  = ucfirst($firstname);
                    $lastname   = ucfirst($lastname);

                    $encrypted_password = sha1($password);

                    //empty them out just to be sure,
                    $password = null;
                    $password_confirmation = null;

                    $sql =    "INSERT INTO users(email, password, firstname, lastname, group_id, grade)"
                            . "VALUES(:email, :password, :firstname, :lastname, :group_id, :grade);";
                    
                    $stmt = $this->db->conn_id->prepare($sql);
                    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                    $stmt->bindParam(":password", $encrypted_password, PDO::PARAM_STR);
                    $stmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
                    $stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
                    $stmt->bindParam(":group_id", $group_id, PDO::PARAM_INT);
                    $stmt->bindParam(":grade", $grade, PDO::PARAM_INT);
                    $stmt->execute();

                    if($stmt->errorCode() != 0) {
                        
                        $errors = $stmt->errorInfo();
                        die($errors[2]);
                        
                    }
                    
                    $this->session->set_userdata("warning", "Account successfully created!");

                }

            }

        }
    
    }
    
    public function getAllUsers() {
        
        $sql =    "SELECT * "
                . "FROM users;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result;
        
    }

    public function deleteById($param_id) {
        
        $sql =    "DELETE FROM users "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
 
    public function getUserById($param_id) {
        
        $sql =    "SELECT * "
                . "FROM users "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result;
        
    }
    
    public function updateById($param_id, $param_email, $firstname, $lastname, $param_group_id) {
        
//        $param_password = sha1($param_password);
        
        $sql =    "UPDATE users "
                . "SET email = :email, firstname = :firstname, lastname = :lastname, group_id = :group_id "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $stmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
        $stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":group_id", $param_group_id, PDO::PARAM_INT);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }

    public function getIdByEmail($param_email) {
        
        $sql =    "SELECT id "
                . "FROM users "
                . "WHERE email = :email "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result["id"];
        
    }
    
    public function getCurrentUser() {
        
        $email = $this->session->userdata("email");
        
        $sql =    "SELECT * "
                . "FROM users "
                . "WHERE email = :email "
                . "LIMIT 1";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC); 
        $stmt->closeCursor();
        
        return $result;
        
    }
    
}