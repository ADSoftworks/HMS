<?php

/**
 * Assignment model
 * 
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 */
class Assignment_model extends CI_Model {

    /**
     * Constructor
     */
    function __construct() {
        
        parent::__construct();
        
    }
    
    /**
     * Creates an assignment
     * 
     * @param String $param_title
     * @param String $param_description
     * @param int $param_group_id
     */
    public function create($param_title, $param_description, $param_group_id) {
        
        $sql =    "INSERT INTO assignments(title, description, group_id) "
                . "VALUES(:title, :description, :group_id);";
        
        $stmt = $this->db->conn_id->prepare($sql);
        
        $stmt->bindParam(":title", $param_title, PDO::PARAM_STR);
        $stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
        $stmt->bindParam(":group_id", $param_group_id, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    
    /**
     * Gets all assignment from a group by it's Group ID
     * 
     * @param int $param_id
     * @return Array
     */
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
    
    /**
     * Gets all assignments by their ID's.
     * 
     * @param int $param_id
     * @return Array
     */
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
    
    /**
     * Delete an assignment by it's ID.
     * 
     * @param int $param_id
     */
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