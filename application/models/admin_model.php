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
    
    public function getPasscode () {

        $sql = "SELECT passcode FROM settings LIMIT 1;";

        $stmt = $this->db->conn_id->prepare ($sql);
        $stmt->execute ();
        $result = $stmt->fetch (PDO::FETCH_ASSOC);

        return $result["passcode"];

    }

    public function setPasscode ($param_passcode) {

        $sql = "UPDATE settings SET passcode = :passcode LIMIT 1";

        $stmt = $this->db->conn_id->prepare ($sql);
        $stmt->bindParam (":passcode", $param_passcode, PDO::PARAM_INT);
        $stmt->execute ();

    }
    
}
