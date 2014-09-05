<?php

class Admin extends CI_Controller {

    function __construct() {
        
        parent::__construct();
        
        $this->authenticate();
        
        $this->load->model("User_model");
        $this->load->model("Group_model");
        
    }
    
    public function index($page = "admin_panel") {
        
        $this->controls();
        $this->page($page);
        
    }
    
    public function logout() {
        
        $this->session->unset_userdata("admin");
        header("Location: " . base_url() . "index.php");
        
    }
    
    private function authenticate() {
        
        if(!$this->session->userdata("admin")) {
           
            header("Location: " . base_url() . "index.php/adminlogin");
            
        }
        
    }
    
    private function controls() {
        
        $this->authenticate();
        
        if(isset($_POST["submit_search"])) {
            
            $email = $_POST["param_email"];
            
            if($this->User_model->exists($email)) {
            
                $user_id = $this->User_model->getIdByEmail($email);

                header("Location: " . base_url() . "index.php/admin/search/" . $user_id);
                exit();

            } else {
                
                $this->session->set_userdata("warning", "Dit account bestaat niet.");
                
            }
            
        }
        
        if(isset($_POST["createdocent_submit"])) {
            
            $email = $_POST["param_email"];
            $password = $_POST["param_password"];
            
            $this->User_model->register($email, $password, $password, 1);
            
        }
        
    }
    
    public function search($param_id) {
        
        $user = $this->User_model->getUserById($param_id);
        
        $data["user"] = $user;
        
        $this->load->view("templates/header.php");
        $this->load->view("pages/admin_userprofile.php", $data);
        $this->load->view("templates/footer.php");
        
    }
    
    public function deleteuser($param_id) {
        
        $this->User_model->deleteById($param_id);
        $this->session->set_userdata("warning", "Account is succesvol verwijderd.");
        header("Location: " . base_url() . "index.php/admin");
        exit();
        
    }
    
    public function deleteGroup($param_id) {
        
        $this->Group_model->deleteById($param_id);
        $this->session->set_userdata("warning", "Groep is succesvol verwijderd.");
        header("Location: " . base_url() . "index.php/admin");
        exit();
        
    }
    
    public function edituser($param_id) {
        
        if(isset($_POST["submit_edit"])) {
            
            $email = $_POST["param_email"];
            $password = $_POST["param_password"];
            $group_id = $_POST["param_group_id"];
            
            $this->User_model->updateById($param_id, $email, $password, $group_id);
            
            $this->session->set_userdata("warning", "Account succesvol aangepast!");
            
        }
        
        $data["param_id"] = $param_id;
        
        $this->load->view("templates/header.php");
        $this->load->view("pages/admin_edituser.php", $data);
        $this->load->view("templates/footer.php");
        
    }

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
            
            $this->load->view("templates/header.php");
            $this->load->view("pages/" . $page . ".php");
            $this->load->view("templates/footer.php");
            
        }
        
    }
    
}