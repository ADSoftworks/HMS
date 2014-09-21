<?php

/**
 * Admin Controller
 * 
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 */
class Admin extends CI_Controller {

    private $filesizelimit;
    
    /**
     * Constructor
     */
    function __construct() {
        
        parent::__construct();
        
        $this->authenticate();
        
        $this->load->model("User_model");
        $this->load->model("Group_model");
        $this->load->model("Admin_model");
        
    }
    
    /**
     * Index
     * 
     * @param String $page
     */
    public function index($page = "admin_panel") {
        
        $this->controls();
        
        $this->page($page);
        
    }
    
    /**
     * Logs the admin out.
     */
    public function logout() {
        
        $this->session->unset_userdata("admin");
        header("Location: " . base_url() . "index.php");
        
    }
    
    /**
     * Authenitcates the admin to ensure we're dealing with an admin.
     */
    private function authenticate() {
        
        if(!$this->session->userdata("admin")) {
           
            header("Location: " . base_url() . "index.php/adminlogin");
            
        }
        
    }
    
    /**
     * Controls
     */
    private function controls() {
        
        $this->authenticate();
        
        /*
         * If Admin searches for an account
         */
        if(isset($_POST["submit_search"])) {
            
            $email = $_POST["param_email"];
            
            if($this->User_model->exists($email)) {
            
                $user_id = $this->User_model->getIdByEmail($email);

                header("Location: " . base_url() . "index.php/admin/search/" . $user_id);
                exit();

            } else {
                
                $this->session->set_userdata("warning", "This account does not exist.");
                
            }
            
        }
        
        /*
         * If admin creates a teacher account.
         */
        if(isset($_POST["createdocent_submit"])) {
            
            $email      = $_POST["param_email"];
            $password   = $_POST["param_password"];
            $firstname  = $_POST["param_firstname"];
            $lastname   = $_POST["param_lastname"];
            
            $this->User_model->register($email, $password, $password, $firstname, $lastname, 1, 0);
            
        }
        
    }
    
    /**
     * Searches for a user by it's ID.
     * 
     * @param int $param_id
     */
    public function search($param_id) {
        
        $user = $this->User_model->getUserById($param_id);
        
        $data["user"] = $user;
        
        $this->load->view("templates/header.php");
        $this->load->view("pages/admin_userprofile.php", $data);
        $this->load->view("templates/footer.php");
        
    }
    
    /**
     * Deletes a user by it's ID.
     * 
     * @param int $param_id
     */
    public function deleteuser($param_id) {
        
        $this->User_model->deleteById($param_id);
        $this->session->set_userdata("warning", "Account successfully deleted.");
        header("Location: " . base_url() . "index.php/admin");
        exit();
        
    }
    
    /**
     * Deletes a group by it's ID.
     * 
     * @param int $param_id
     */
    public function deleteGroup($param_id) {
        
        $this->Group_model->deleteById($param_id);
        $this->session->set_userdata("warning", "Group successfully deleted.");
        header("Location: " . base_url() . "index.php/admin");
        exit();
        
    }
    
    /**
     * Edits a user's information and renders the edit page.
     * 
     * @param int $param_id
     */
    public function edituser($param_id) {
        
        if(isset($_POST["submit_edit"])) {
            
            $email      = $_POST["param_email"];
            $password   = $_POST["param_password"];
            $group_id   = $_POST["param_group_id"];
            $firstname  = $_POST["param_firstname"];
            $lastname   = $_POST["param_lastname"];
            $grade      = $_POST["param_grade"];
            
            $id = $this->User_model->getIdByEmail($email);
            $user = $this->User_model->getUserById($id);
            
            if($user["password"] != $password) 
                $this->User_model->changePasswordByEmail($email, $password);
                
                $this->User_model->updateById($param_id, $email, $firstname, $lastname, $group_id, $grade);
                $this->session->set_userdata("warning", "Account edited!");
            
            
        }
        
        $data["param_id"] = $param_id;
        
        $this->load->view("templates/header.php");
        $this->load->view("pages/admin_edituser.php", $data);
        $this->load->view("templates/footer.php");
        
    }

    /**
     * Renders a page
     * 
     * @param String $page
     */
    public function page($page) {
        
        $allowed_pages = array(
          
            0 => "admin_panel",
            1 => "admin_userprofile"
            
        );
        
        if(!in_array($page, $allowed_pages)) {
            
            $page = $allowed_pages[0];
            
        }
        
        if(!file_exists(APPPATH . "views/pages/" . $page . ".php")) {
            
            $this->show_404();
            
        } else {
            
            $data["filesizelimit"] = $this->filesizelimit;
            
            $this->load->view("templates/header.php", $data);
            $this->load->view("pages/" . $page . ".php", $data);
            $this->load->view("templates/footer.php", $data);
            
        }
        
    }
    
}