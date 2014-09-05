<?php

class AdminLogin extends CI_Controller {

    function __construct() {
        
        parent::__construct();
        
    }
    
    public function index($page = "admin_login") {
        
        $this->controls();
        $this->page($page);
        
    }
    
    private function controls() {
        
        if($this->session->userdata("admin")) {
            
            header("Location: " . base_url() . "index.php/admin");
            
        }
        
        if(isset($_POST["submit_login"])) {
            
            if(sha1($_POST["param_password"]) == sha1(ADMIN_PASSWORD)) {
                
                $this->session->set_userdata("admin", "thisisasecret");
                header("Location: " . base_url() . "index.php/admin");
                exit();
                
            }
            
        }
        
    }

    public function page($page) {
        
        $allowed_pages = array(
            
            0 => "admin_login"
            
        );
        
        if(!in_array($page, $allowed_pages)) {
            
            $page = $allowed_pages[0];
            $this->session->set_userdata("warning", "Deze pagina kan u niet vanaf hier bezoeken.");
            
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