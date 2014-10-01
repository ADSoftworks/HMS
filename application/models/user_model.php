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
                
                $truefax = Array("An Akepa is a small Hawaiian bird whose name means “agile”, for they’re commonly found foraging on branches.",
                    "Weighing in only at 10 grams and being only four inches long they’re amongst the smallest birds in Hawaii.",
                    "A forest bird, the Akepa is found only in high elevated rainforests.",
                    "Akepa are known for their unusual cross-bill with the upper overlapping the lower to one side. ",
                    "James Cook was the first non-polynesian explorer to discover the species on his third voyage. ",
                    "The Akepa primarily feeds on caterpillars found in leaf buds; which it opens with its specialized bill. ",
                    "Akepa are a highly endangered species, due to Hawaii’s high rate of invasive species. ",
                    "The Akepa has three known subspecies. Speculation exists as to whether or not they’re actually distinct species. ",
                    "Akepa are part of the finch family, specifically a group of honeycreeper native only to Hawaii. ",
                    "To ensure that unique birds like the Akepa don’t go extinct please support your local wildlife conservation efforts. Awareness can go a long way! ");
                
                $random = mt_rand(0, (count($truefax) - 1));
                
//                echo $random;
                
//                die(var_dump($random));
                
                $this->session->set_userdata("warning", "| <strong>Akepa fact: </strong>" . $truefax[$random]);
                if ($result["group_id"] == 0) {
                    
                    header("Location: " . base_url() . "index.php/student");
                    
                } else if ($result["group_id"] == 1) {
                    
                    header("Location: " . base_url() . "index.php/docent");
                    
                }
                
                exit();
                
//                if($result["group_id"] == 0) {
//                
//                    $this->session->set_userdata("warning", "Welcome student!");
//                    header("Location: " . base_url() . "index.php/student");
//                    exit();
//                    
//                } else if($result["group_id"] == 1) {
//                    
//                    $this->session->set_userdata("warning", "Welcome teacher!");
//                    header("Location: " . base_url() . "index.php/docent");
//                    exit();
//                    
//                }
                
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
    
    /**
     * Authenticates the current user.
     * 
     * @param String $password
     * @return boolean
     */
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
     * Checks if a user's passwords match and if the user already exists
     * if not it will register it into the database.
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
                exit (0);

            } else {

                if($this->exists($email)) {

                    $this->session->set_userdata("warning", "Account already exists.");
                    exit (0);

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

//                    if($stmt->errorCode() != 0) {
//
//                        $errors = $stmt->errorInfo();
//                        die($errors[2]);
//
//                    }
                    
                    $this->session->set_userdata("warning", "Account successfully created!");

                }

            }

        }
    
    }
    
    /**
     * Gets all the users.
     * 
     * @return Array
     */
    public function getAllUsers() {
        
        $sql =    "SELECT * "
                . "FROM users;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }

    /**
     * Deletes a user by it's ID.
     * 
     * @param int $param_id
     */
    public function deleteById($param_id) {
        
        $sql =    "DELETE FROM users "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
 
    /**
     * Gets user by it's ID.
     * 
     * @param int $param_id
     * @return Array
     */
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

    /**
     * Gets the grade of a user.
     *
     * @param int $param_id
     */
    public function getGradeById ($param_id) {

        $sql = "SELECT grade "
             . "FROM users "
             . "WHERE id = :id "
             . "LIMIT 1;";

        $stmt = $this->db->conn_id->prepare ($sql);
        $stmt->bindParam (":id", $param_id, PDO::PARAM_INT);
        $stmt->execute ();

        $result = $stmt->fetch (PDO::FETCH_ASSOC);
        $stmt->closeCursor ();

        return $result ? $result["grade"] : false;

    }

    /**
     * Updates the grades of a user by the user's ID.
     * 
     * @param int $param_id
     * @param int $param_grade
     */
    public function updateGradeById($param_id, $param_grade) {
        
        $sql =    "UPDATE users "
                . "SET grade = :grade "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":grade", $param_grade, PDO::PARAM_INT);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    
    /**
     * Updates a user by it's ID.
     * 
     * @param int $param_id
     * @param String $param_email
     * @param String $firstname
     * @param String $lastname
     * @param int $param_group_id
     * @param int $param_grade
     */
    public function updateById($param_id, $param_email, $firstname, $lastname, $param_group_id, $param_grade) {
        
        //capitalize first and lastname
        $firstname  = ucfirst($firstname);
        $lastname   = ucfirst($lastname);
        
        $sql =    "UPDATE users "
                . "SET email = :email, firstname = :firstname, lastname = :lastname, group_id = :group_id, grade = :grade "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $stmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
        $stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":group_id", $param_group_id, PDO::PARAM_INT);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->bindParam(":grade", $param_grade, PDO::PARAM_INT);
        $stmt->execute();
        
    }

    /**
     * Gets a user's ID by the user's email address.
     * 
     * @param String $param_email
     * @return int
     */
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
    
    /**
     * Gets the user that's currently 
     * logged in by it's email address.
     * 
     * @return Array
     */
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