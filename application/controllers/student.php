<?php

class Student extends CI_controller {

    function __construct() {
        
        parent::__construct();
        
        $this->load->model("User_model");
        $this->load->model("Group_model");
        $this->load->model("Assignment_model");
        $this->load->model("Homework_model");
        
        $this->authenticate();
        
    }
    
    public function index($page = "student_group_overview") {
        
        $this->controls();
        $this->page($page);
        
    }
    
    public function controls() {
        
        $this->authenticate();
        
        if(isset($_POST["submit_changepassword"])) {
            
            $email = $this->session->userdata("email");
            $oldpassword = $_POST["param_oldpassword"];
            $newpassword = $_POST["param_newpassword"];
            
            if($this->User_model->authenticateCurrentUser($oldpassword)) {
            
                $this->User_model->changePasswordByEmail($email, $newpassword);
            
            }
            
        }
        
        if(isset($_POST["submit_joingroup"])) {
            
            $groupcode = $_POST["param_groupcode"];
            
            $this->Group_model->join($groupcode);
            
        }
        
    }
    
    private function authenticate() {
        
        if(!$this->session->userdata("email")) {
         
            header("Location: " . base_url() . "index.php/login");
            exit();
            
        }
        
        if($this->User_model->isDocent()) {
            
            $this->session->set_userdata("warning", "U bent geen student.");
            header("Location: " . base_url() . "index.php/docent");
            exit();
            
        }
        
    }
    
    public function groupProfile($param_id) {
        
//        CONTROLS
//        CONTROLS END
        
        if( ! file_exists(APPPATH . "views/pages/student_group_profile.php")) {
            
            show_404();
            
        } else {
            
            $data["group"] = $this->Group_model->getGroupById($param_id);
            
            $me = $this->User_model->getIdByEmail($this->session->userdata("email"));
            
            if( ! $data["group"]) {
                
                $this->session->set_userdata("warning", "Deze groep bestaat niet.");
                header("Location: " . base_url() . "index.php/student");
                exit(0);
                
            } else {
            
                if( ! $this->Group_model->isMemberOfGroupById($param_id, $me)) {
                
                    $this->session->set_userdata("warning", "U maakt geen deel uit van deze groep.");
                    header("Location: " . base_url() . "index.php/student");
                    exit(0);
                    
                } else {

                    $this->load->view("templates/header.php");
                    $this->load->view("pages/student_group_profile.php", $data);
                    $this->load->view("templates/footer.php");

                }
                
            }
            
        }
        
    }
    
    public function assignmentProfile($param_id) {
        
        //CONTROLS
        if(isset($_POST["submit_homework"])) {
            
            if($_FILES["homework"]["error"] > 0) {

                $this->session->set_userdata("warning", "FATAL ERROR: " . $_FILES["homework"]["error"]);

            } else {
            
                $forbiddenExtensions = 
                    array("php", "sql", "sh", "js", "html", 
                    "css", "cs", "asp", "jar", "jsp");

                $temp = explode(".", $_FILES["homework"]["name"]);
                $extension = end($temp);

                if(in_array($extension, $forbiddenExtensions)) {

                    $this->session->set_userdata("warning", "Dit is een verboden extensie, you interesting little hacker ;)");

                } else {

                    $prefix = substr(md5(rand(0, 100)), 0, 8);
                    move_uploaded_file($_FILES["homework"]["tmp_name"],
                    "./assets/uploads/" . $prefix . "_" . $_FILES["homework"]["name"]);

                    if(file_exists("./assets/uploads/" . $prefix . "_" . $_FILES["homework"]["name"])) {

                        //WE'VE GOT HIM
                        $user_id = $this->User_model->getIdByEmail($this->session->userdata("email"));
                        
                        $assignment = $this->Assignment_model->getAssignmentById($param_id);
                        
                        $this->Homework_model->create(
                                $prefix . "_" . $_FILES["homework"]["name"], 
                                $user_id, 
                                $assignment["group_id"], 
                                $assignment["id"]);
                        
                        $this->session->set_userdata("warning", "Huiswerk successvol ingeleverd!");

                    }
                    
                }
                    
            }
            
        }
        
        //CONTROLS END
        
        if(isset($param_id)) {
        
            if(! file_exists(APPPATH . "views/pages/student_assignment_profile.php")) {

                show_404();

            } else {
                
                $user_id = $this->User_model->getIdByEmail($this->session->userdata("email"));
                
                $data["assignment"] = $this->Assignment_model->getAssignmentById($param_id);
                $data["homework"] = $this->Homework_model->getHomeworkByAssignmentIdAndUserId($param_id, $user_id);
                
                $this->load->view("templates/header.php");
                $this->load->view("pages/student_assignment_profile.php", $data);
                $this->load->view("templates/footer.php");

            }

        }
        
    }
    
    public function logout() {
        
        $this->User_model->logout();
        
    }
    
    public function page($page) {
        
        $allowed_pages = array(
          
            0 => "student_group_overview",
            1 => "student_settings"
            
        );
        
        if(!in_array($page, $allowed_pages)) {
            
            $this->session->set_userdata("warning", "U kunt deze pagina vanaf hier niet bezoeken.");
            $page = $allowed_pages[0];
            
        }
        
        if(!file_exists(APPPATH . "views/pages/". $page . ".php"))
                $this->show_404();
        else {
            
            $this->load->view("templates/header.php");
            $this->load->view("pages/" . $page . ".php");
            $this->load->view("templates/footer.php");
        
        }
        
    }

}