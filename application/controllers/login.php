<?php

/**
 * Login Controller
 * 
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 */
class Login extends CI_Controller {

    /**
     * Constructor.
     */
    function __construct() {
        
        parent::__construct();
        
        $this->load->model("User_model");
        
    }
    
    /**
     * Index.
     * 
     * @param String $page
     */
    public function index($page = "login") {

        $this->controls();
        $this->page($page);
        
    }
    
    /**
     * Controls.
     */
    private function controls() {
        
        /*
         * Check if user is already logged in.
         */
        if($this->session->userdata("email")) {
            
            if($this->User_model->isDocent()) {
                
                header("Location: " . base_url() . "index.php/docent");
                
            } else {
                
                header("Location: " . base_url() . "index.php/student");
                exit();
            
            }
            
        }
        
        /*
         * Forgot password
         */
        if(isset($_POST["submit_forgotpassword"])) {
            
            $email = $_POST["param_email"];
            
            $this->User_model->sendNewPasswordByEmail($email);
            
        }
        
        /*
         * Log in
         */
        if(isset($_POST["submit_login"])) {
            
            $email = $_POST["param_email"];
            $password = $_POST["param_password"];
            
            $this->User_model->login($email, $password);
            
        }
        
        /*
         * Register
         */
        if(isset($_POST["submit_register"])) {
            
            $email                  = $_POST["param_email"];
            $password               = $_POST["param_password"];
            $password_confirmation  = $_POST["param_password_confirmation"];
            $firstname              = $_POST["param_firstname"];
            $lastname               = $_POST["param_lastname"];
            $grade                  = $_POST["param_grade"];
            
            $this->User_model->register($email, $password, $password_confirmation, $firstname, $lastname, 0, $grade);
            
            header("Location: " . base_url() . "index.php/login");
            exit();
            
        }
    }
    
    /**
     * Render an allowed page.
     * 
     * @param String $page
     */
    public function page($page) {
        
        $allowed_pages = Array(
            
            0 => "login",
            1 => "student_register",
            2 => "student_forgotpassword"
            
        );
        
        if(!in_array($page, $allowed_pages)) {
         
            $this->session->userdata("warning", "You can't visit this page from here.");
            $page = $allowed_pages[0];
            
                
        }
            
        if(!file_exists(APPPATH. "/views/pages/" . $page . ".php")) {
                
            show_404();
                
        } else {
        
            $data["title"] = $page;
            
            $this->load->view("templates/header", $data);
            $this->load->view("pages/" . $page, $data);
            $this->load->view("templates/footer", $data);
            
        }
        
    }    

}