<?php

class DocentSignupLogin extends CI_Controller {

    function __construct () {
        
        parent::__construct ();

        $this->load->model ("Admin_model");

        $this->controls ();
        $this->page ();
        
    }

    public function index () {

        $this->controls ();

    }
    
    private function controls () {
        
        //Check if already logged in
        if ($this->session->userdata ("docent-signup"))
            header (base_url () . "index.php/docentsignup");

        /*
         * Check if the user is trying to sign in
         */
        if (isset ($_POST["login_submit"]) ) {

            if (isset ($_POST["login_password"]) ) {

                $input_passcode = $_POST["login_password"];
                $passcode = $this->Admin_model->getPasscode ();

                if ($input_passcode == $passcode) {

                    $this->session->set_userdata ("docent-signup", true);
                    $this->session->set_userdata ("warning", "Successfully logged in.");
                    header ("Location: " . base_url() . "index.php/docentsignup");
                    exit (0);

                } else {

                    $this->session->set_userdata ("warning", "Incorrect passcode.");

                }

            }

        }

    }

    /**
     * Renders an allowed page.
     * 
     * @param String $page
     */
    public function page($page = "docent_signup_login") {
        
        $allowed_pages = array(
          
            0 => "docent_signup_login"
            
        );
        
        if( !in_array($page, $allowed_pages)) {
            
            $page = $allowed_pages[0];
            $this->session->set_userdata
                    ("warning", "You cannot visit this page from here.");
            
        }
            
        if( ! file_exists(APPPATH . "views/pages/" . $page . ".php")) {

            show_404();

        } else {

            $this->load->view("templates/header.php");
            $this->load->view("pages/" .  $page . ".php");
            $this->load->view("templates/footer.php");
                   
        }
            
        
        
    }
    
}