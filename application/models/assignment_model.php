<?php

class Assignment_model extends CI_Model {

    function __construct() {
        
        parent::__construct();
        
    }
    
    public function create($param_title, $param_description, $param_group_id) {
        
        $sql =    "INSERT INTO assignments(title, description, group_id) "
                . "VALUES(:title, :description, :group_id);";
        
        $stmt = $this->db->conn_id->prepare($sql);
        
        $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
        $stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
        $stmt->bindParam(":group_id", $param_group_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }

    public function getAllAssignmentsFromGroupById($param_id) {
        
        $sql =    "SELECT * "
                . "FROM assignments "
                . "WHERE group_id = :id";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }
    
    public function getAssignmentById($param_id) {
        
        $sql =    "SELECT * "
                . "FROM assignments "
                . "WHERE id = :id "
                . "LIMIT 1";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        return $result ? $result : false;
        
    }
    
    public function deleteById($param_id) {
        
        $sql =    "DELETE "
                . "FROM assignments "
                . "WHERE id = :id "
                . "LIMIT 1";
        
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
       
    
}