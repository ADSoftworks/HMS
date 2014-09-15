<?php

class Group_model extends CI_Model {

    function __construct() {
        
        parent::__construct();
        
    }
    
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
    
    public function getAllGroups() {
        
        $sql =    "SELECT * "
                . "FROM groups;";
            
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $result ? $result : false;
        
    }
    
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