<?php

class Homework_model extends CI_Model {

    function __construct() {
        
        parent::__construct();
        
    }

    public function updateStatusById($param_id, $param_status) {
        
        $sql =    "UPDATE homework "
                . "SET status = :status "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);
        $stmt->execute();
        
    }
    
    public function deleteById($param_id) {
        
        $sql =    "DELETE FROM homework "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    
    public function getById($param_id) {
        
        $sql =    "SELECT * "
                . "FROM homework "
                . "WHERE id = :id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
            
    }
    
    public function getAllHomeworkByAssignmentId($param_id) {
        
        $sql =    "SELECT users.email, users.firstname, users.lastname, homework.status, homework.file_source, homework.id "
                . "FROM homework "
                . "RIGHT  JOIN users ON homework.user_id = users.id "
                . "WHERE homework.assignment_id = :assignment_id;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":assignment_id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }
    
    public function getAllHomeworkByAssignmentIdAndUserId($param_id) {
        
        $sql =    "SELECT users.email, homework.status, homework.file_source, homework.id "
                . "FROM homework "
                . "INNER JOIN users ON homework.user_id = users.id "
                . "WHERE homework.assignment_id = :assignment_id;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":assignment_id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }
    
    public function getHomeworkByAssignmentIdAndUserId($param_id, $param_user_id) {
        
//        die(var_dump($param_user_id));
        
        $sql =    "SELECT * "
                . "FROM homework "
                . "WHERE assignment_id = :assignment_id "
                . "AND user_id = :user_id "
                . "LIMIT 1;";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":assignment_id", $param_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $param_user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
            
    }
    
    public function create($param_file_source, $param_user_id, 
            $param_group_id, $param_assignment_id) {
        
        
        $status = "pending";

        $sql = "INSERT INTO homework(file_source, status, "
                . "user_id, group_id, assignment_id) "
                . "VALUES(:file_source, :status, :user_id, "
                . ":group_id, :assignment_id);";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":file_source", $param_file_source, PDO::PARAM_STR);
        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $param_user_id, PDO::PARAM_INT);
        $stmt->bindParam(":group_id", $param_group_id, PDO::PARAM_INT);
        $stmt->bindParam(":assignment_id", $param_assignment_id, PDO::PARAM_INT);
        
        $stmt->execute();
        
    }
    
}