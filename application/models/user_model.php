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
                
                    $this->session->set_userdata("warning", "Welkom, student!");
                    header("Location: " . base_url() . "index.php/student");
                    exit();
                    
                } else if($result["group_id"] == 1) {
                    
                    $this->session->set_userdata("warning", "Welkom docent, fijne werkdag!");
                    header("Location: " . base_url() . "index.php/docent");
                    exit();
                    
                }
                
            } else {
                
                $this->session->set_userdata("warning", "Foutief email of wachtwoord.");
            
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
        $this->session->set_userdata("warning", "U bent succesvol uitgelogd!");
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
            
            $this->session->set_userdata("warning", "Het oude wachtwoord komt niet overeen.");
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
        
            $this->session->set_userdata("warning", "Uw wachtwoord is succesvol aangepast!");
            
       } else {
       
       $this->session->set_userdata("warning", "Uw wachtwoord kon niet worden veranderd.");
        
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

                $this->session->set_userdata("warning", "Uw nieuwe wachtwoord is verstuurd!");

            } else {
                
                $this->session->set_userdata("warning", "Er is geen account bekend met dat email adres.");
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
     * @param type String $email
     * @param type String $password
     * @param type String $password_confirmation
     */
    public function register($email, $password, $password_confirmation, $group_id) {
        
        if(isset($email) && 
           isset($password) &&
           isset($password_confirmation) &&
           isset($group_id)) {
            
            if($password != $password_confirmation) {

                $this->session->set_userdata("warning", "De wachtwoorden komen niet overeen.");

            } else {

                if($this->exists($email)) {

                    $this->session->set_userdata("warning", "Account bestaat al.");

                } else {

                    $encrypted_password = sha1($password);

                    //empty them out just to be sure,
                    $password = null;
                    $password_confirmation = null;

                    $sql =    "INSERT INTO users(email, password, group_id)"
                            . "VALUES(:email, :password, :group_id);";

                    $stmt = $this->db->conn_id->prepare($sql);
                    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                    $stmt->bindParam(":password", $encrypted_password, PDO::PARAM_STR);
                    $stmt->bindParam(":group_id", $group_id, PDO::PARAM_INT);
                    $stmt->execute();

                    $this->session->set_userdata("warning", "Account succesvol aangemaakt!");

                }

            }

        }
    
    }
    
    public function getAllUsers() {
        
        $sql =    "SELECT id, email, group_id "
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
    
    public function updateById($param_id, $param_email, $param_password, $param_group_id) {
        
        $param_password = sha1($param_password);
        
        $sql =    "UPDATE users "
                . "SET email = :email, password = :password, group_id = :group_id "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
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