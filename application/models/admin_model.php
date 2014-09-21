<?php

/**
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 */
class Admin_model extends CI_Model {
    
    /**
     * Constructor
     */
    public function __construct() {
        
        parent::__construct();
        
    }
    
//    public function getFileSizeLimit() {
//        
//        $sql = "SELECT filesizelimit FROM admin;";
//        
//        $stmt = $this->db->conn_id->prepare($sql);
//        $stmt->execute();
//        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        
//        return $result["filesizelimit"];
//        
//    }
//    
//    public function setFileSizeLimit($limit) {
//        
//        $sql = "UPDATE admin SET filesizelimit = :limit WHERE id = 1";
//        
//        $stmt = $this->db->conn_id->prepare($sql);
//        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
//        $stmt->execute();
//        
//    }
    
}
