<?php

/**
 * AdminLogin Controller
 * 
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 */
class AdminLogin extends CI_Controller {

    /**
     * Constructor.
     */
    function __construct() {
        
        parent::__construct();
        
    }
    
    /**
     * Index.
     * 
     * @param String $page
     */
    public function index($page = "admin_login") {
        
        $this->controls();
        $this->page($page);
        
    }
    
    /**
     * Controls
     */
    private function controls() {
        
        /*
         * If logged in as admin, skip this controller.
         */
        if($this->session->userdata("admin")) {
            
            header("Location: " . base_url() . "index.php/admin");
            
        }
        
        /*
         * If trying to log in.
         */
        if(isset($_POST["submit_login"])) {
            
            if(sha1($_POST["param_password"]) == sha1(ADMIN_PASSWORD)) {
                
                $this->session->set_userdata("admin", "thisisasecret");
                $this->session->set_userdata("warning", "You're running HMS Version: " . VERSION . " Build: " . BIRD_BUILD);
                header("Location: " . base_url() . "index.php/admin");
                exit();
                
            }
            
        }
        
    }

    /**
     * Render a page.
     * 
     * @param String $page
     */
    public function page($page) {
        
        $allowed_pages = array(
            
            0 => "admin_login"
            
        );
        
        if(!in_array($page, $allowed_pages)) {
            
            $page = $allowed_pages[0];
            $this->session->set_userdata("warning", "You cannot visit this page from here.");
            
        }
        
        if(!file_exists(APPPATH . "views/pages/" . $page . ".php")) {
            
            $this->show_404();
            
        } else {
            
            $this->load->view("templates/header.php");
            $this->load->view("pages/" . $page . ".php");
            $this->load->view("templates/footer.php");
            
        }
        
    }
    
}