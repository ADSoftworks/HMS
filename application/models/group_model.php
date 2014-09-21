<?php

/**
 * Group model
 * 
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 */
class Group_model extends CI_Model {

    /**
     * Constructor
     */
    function __construct() {
        
        parent::__construct();
        
    }
    
    /**
     * Checks if a group exists by it's name and returns it.
     * 
     * @param String $param_name
     * @return Array
     */
    private function existsByName($param_name) {
        
        $sql =    "SELECT name "
                . "FROM groups "
                . "WHERE name = :name;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result : false;
        
    }
    
    /**
     * Update a group's name and description by it's ID.
     * 
     * @param int $param_id
     * @param String $param_name
     * @param String $param_description
     */
    public function updateNameAndDescriptionById($param_id, $param_name, $param_description) {
        
        $sql =    "UPDATE group "
                . "SET name = : name, description = :description "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    
    /**
     * Create a group
     * 
     * @param String $param_name
     * @param String $param_description
     */
    public function create($param_name, $param_description) {
        
        $author_id = $this->User_model->getId();
        
        if( ! $this->existsByName($param_name)) {
        
            $code = substr(sha1(rand(0, 2147000)), 0, 6);
            
            $sql =    "INSERT INTO groups(name, description, docent_id, code) "
                    . "VALUES(:name, :description, :docent_id, :code);";

            $stmt = $this->db->conn_id->prepare($sql);
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
            $stmt->bindParam(":docent_id", $author_id, PDO::PARAM_INT);
            $stmt->bindParam(":code", $code, PDO::PARAM_INT);
            $stmt->execute();

        }
        
    }
    
    /**
     * Delete a group by it's ID.
     * 
     * @param int $param_id
     */
    public function deleteById($param_id) {
        
        $sql =    "DELETE FROM groups "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $sql =    "DELETE FROM assignments "
                . "WHERE group_id = :id ";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    
    /**
     * Gets all groups.
     * 
     * @return Array
     */
    public function getAllGroups() {
        
        $sql =    "SELECT * "
                . "FROM groups;";
            
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result ? $result : false;
        
    }
    
    /**
     * Gets all members of a group by the group ID
     * 
     * @param int $param_id
     * @return Array
     */
    public function getAllMembersById($param_id) {
        
        $sql =    "SELECT student_ids "
                . "FROM groups "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }
    
    /**
     * STUDENT ONLY METHOD.
     * Returns all groups where the STUDENT user is in.
     * 
     * @return Array
     */
    public function getAllGroupsFromUser() {
        
        $email = $this->User_model->getEmail();
        
        if($email) {
            
            $sql =    "SELECT * "
                    . "FROM groups;";
            
            $stmt = $this->db->conn_id->prepare($sql);
            $stmt->bindParam(":id", $this->User_model->getId(), PDO::PARAM_INT);
            $stmt->execute();
            
            $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            if($groups) {
            
                $id = $this->User_model->getId();

                $final_groups = array();

                foreach($groups as $group) {

                    if(isset($group["student_ids"])) {
                        
                        $student_ids = unserialize($group["student_ids"]);

                        if(in_array($id, $student_ids)) {

                            array_push($final_groups, $group);

                        }
                    
                    }

                }

                return $final_groups ? $final_groups : false;
            
            }
        
        }
        
    }
        
    /**
     * DOCENT ONLY METHOD
     * 
     * Returns all grpups made by a user
     * by his ID.
     * 
     * @return Array
     */
    public function getAllAuthoredGroupsFromUser() {
        
        $id = $this->User_model->getId();
            
        $sql =    "SELECT * "
                . "FROM groups "
                . "WHERE docent_id = :id;";

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }

    /**
     * Gets a group by it's ID.
     * 
     * @param int $param_id
     * @return Array
     */
    public function getGroupById($param_id) {
        
        $sql =    "SELECT * "
                . "FROM groups "
                . "WHERE id = :id;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }
    
    /**
     * Checks if a user is a member of a group by it's group id
     * and the users id.
     * 
     * @param int $param_id
     * @param int $param_user_id
     * @return boolean
     */
    public function isMemberOfGroupById($param_id, $param_user_id) {
        
        $sql =    "SELECT student_ids "
                . "FROM groups "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        if($result) {
        
            $students = unserialize($result["student_ids"]);

            return in_array($param_user_id, $students) ? true : false;

        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * Updates the members of a group by the group's ID.
     * 
     * @param int $group_id
     * @param Array $members
     */
    public function updateMembers($group_id, $members) {
        
        $members = serialize($members);
        
        $sql =    "UPDATE groups "
                . "SET student_ids = :members "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":members", $members, PDO::PARAM_STR);
        $stmt->bindParam(":id", $group_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    
    /**
     * To leave a group
     * 
     * @param int $group_id
     * @param int $student_id
     */
    public function leave($group_id, $student_id) {
        
        if( ! $this->isMemberOfGroupById($group_id, $student_id)) {
            
            $this->session->set_userdata("warning", "You are no part of this group.");
            header("Location: " . base_url() . "index.php/student");
            
        } else {
            
            $array = $this->getAllMembersById($group_id);
            $students = unserialize($array["student_ids"]);
            
            $pos = array_search($student_id, $students);
            unset($students[$pos]);
            
            $this->updateMembers($group_id, $students);
            
        }
        
    }
    
    /**
     * To join a group by it's group code.
     * 
     * @param String $param_code
     */
    public function join($param_code) {
        
        if($this->existsByCode($param_code)) {
            
            $group = $this->getByCode($param_code);
            $id = $this->User_model->getId();
            
            if( ! isset($group["student_ids"])) {
              
                $student_ids = array();
                
            } else {
                
                $student_ids = unserialize($group["student_ids"]);
                
            }
            
            if(in_array($id, $student_ids)) {

                $this->session->set_userdata("warning", "You are already a part of this group");

            } else {

                array_push($student_ids, $id);

                $sql =    "UPDATE groups "
                        . "SET student_ids = :student_ids "
                        . "WHERE code = :code;";

                $stmt = $this->db->conn_id->prepare($sql);
                $stmt->bindParam(":student_ids", serialize($student_ids), PDO::PARAM_STR);
                $stmt->bindParam(":code", $param_code, PDO::PARAM_STR);
                $stmt->execute();

                $this->session->set_userdata("warning", "You are now a part of this group.");

            }
                
            } else {
            
            $this->session->set_userdata("warning", "This group does not exist.");
            
        }
        
    }
    
    /**
     * checks if a group exists by it's code.
     * 
     * @param String $param_code
     * @return Array
     */
    private function existsByCode($param_code) {
        
        $sql =    "SELECT id "
                . "FROM groups "
                . "WHERE code = :code "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":code", $param_code, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? true : false;
        
    }
    
    /**
     * Checks if a room exists by it's ID.
     * 
     * @param String $param_code
     * @return Array
     */
    private function getByCode($param_code) {
        
        $sql =    "SELECT * "
                . "FROM groups "
                . "WHERE code = :code "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":code", $param_code, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }
    
}