<?php

/**
 * Student Controller
 * 
 * @author Bob Desaunois <bobdesaunois@gmail.com>
 */
class Student extends CI_controller {
    
    /*
     * Constructor.
     */
    function __construct() {
        
        parent::__construct();
        
        $this->load->model("User_model");
        $this->load->model("Group_model");
        $this->load->model("Assignment_model");
        $this->load->model("Homework_model");
        $this->load->model("Admin_model");
        
        $this->authenticate();
        
    }
    
    /*
     * Index.
     */
    public function index($page = "student_group_overview") {
        
        $this->controls();
        $this->page($page);
        
    } 
    
    /**
     * Controls
     */
    public function controls() {
        
        //Authenticate the user
        $this->authenticate();
        
        /*
         * Change password
         */
        if(isset($_POST["submit_changepassword"])) {
            
            $email = $this->session->userdata("email");
            $oldpassword = $_POST["param_oldpassword"];
            $newpassword = $_POST["param_newpassword"];
            
            if($this->User_model->authenticateCurrentUser($oldpassword)) {
            
                $this->User_model->changePasswordByEmail($email, $newpassword);
            
            }
            
        }
        
        /*
         * Change grade
         */
        if(isset($_POST["submit_grade"])) {
            
            $id     = $this->User_model->getIdByEmail($this->session->userdata("email"));
            $grade  = $_POST["param_grade"];
            
            $this->User_model->updateGradeById($id, $grade);
            $this->session->set_userdata("warning", "Your grade has been changed.");
            header("Location: " . base_url() . "index.php/student/index/student_settings");
            exit(0);
            
            
        }
        
        /*
         * Join a group
         */
        if(isset($_POST["submit_joingroup"])) {
            
            $groupcode = $_POST["param_groupcode"];
            
            $this->Group_model->join($groupcode);
            
        }
        
    }
    
    /**
     * Authenticate the user.
     */
    private function authenticate() {
        
        if(!$this->session->userdata("email")) {
         
            header("Location: " . base_url() . "index.php/login");
            exit();
            
        }
        
        if($this->User_model->isDocent()) {
            
            $this->session->set_userdata("warning", "You are no student.");
            header("Location: " . base_url() . "index.php/docent");
            exit();
            
        }
        
    }
    
    /**
     * Fetch the profile of a group.
     * 
     * @param int $param_id
     */
    public function groupProfile($param_id) {
        
//        CONTROLS
//        CONTROLS END
        
        if( ! file_exists(APPPATH . "views/pages/student_group_profile.php")) {
            
            show_404();
            
        } else {
            
            //Get target group
            $data["group"] = $this->Group_model->getGroupById($param_id);
            
            //Get the user
            $me = $this->User_model->getIdByEmail($this->session->userdata("email"));
            
            //If the group wasn't found
            if( ! $data["group"]) {
                
                $this->session->set_userdata("warning", "This group does not exist.");
                header("Location: " . base_url() . "index.php/student");
                exit(0);
                
            } else {
                
                //Check if the user is a part of the group
                if( ! $this->Group_model->isMemberOfGroupById($param_id, $me)) {
                
                    $this->session->set_userdata("warning", "You are no part of this group.");
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
    
    /**
     * Fetch the profile of an assignment.
     * 
     * @param int $param_id
     */
    public function assignmentProfile($param_id) {
        
        //CONTROLS
        if(isset($_POST["submit_homework"])) {
            
            /**
             * @TODO CATCH ALL POSSIBLE ERRORS HERE.
             */
            if($_FILES["homework"]["error"] > 0) {
                
                $this->session->set_userdata("warning", "That file is too big!");
                header("Location: " . base_url() . "index.php/student/assignmentprofile/" . $param_id);
                exit();
                
            } else {
                
                $forbiddenExtensions = 
                    array("exe", "php", "sql", "sh", "js", "html", 
                    "css", "cs", "asp", "jar", "jsp", "cpp");

                $temp = explode(".", $_FILES["homework"]["name"]);
                $extension = end($temp);

                if(in_array($extension, $forbiddenExtensions)) {

                    $this->session->set_userdata("warning", "This is a forbidden extension.");
                    /*
                     * @TODO Create a security log that someone tried to do this.
                     */

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
                        
                        $this->session->set_userdata("warning", "Homework successfully uploaded!");

                    }
                    
                }
                    
            }
            
        }
        
        //CONTROLS END
        
        if(isset($param_id)) {
        
            if(! file_exists(APPPATH . "views/pages/student_assignment_profile.php")) {

                show_404();

            } else {
                
                $user_id = $this->User_model->getIdByEmail ($this->session->userdata("email"));

                $assignment = $this->Assignment_model->getAssignmentById($param_id);
                $user_grade = $this->User_model->getGradeById ($user_id);

                if ( (int) $assignment["grade"] != 0
                  && (int) $assignment["grade"] != (int) $usergrade) {

                    $this->session->set_userdata ("warning", "Your grade is not allowed to partake in this assignment.");
                    header ("Location: " . base_url () . "index.php/student");
                    exit (0);

                }

                $data["homework"] = $this->Homework_model->getHomeworkByAssignmentIdAndUserId($param_id, $user_id);

                if($data["assignment"] = $assignment) {
                
                    $this->load->view("templates/header.php");
                    $this->load->view("pages/student_assignment_profile.php", $data);
                    $this->load->view("templates/footer.php");

                } else {
                    
                    $this->session->set_userdata("warning", "There is no assignment with this id.");
                    header("Location: " . base_url() . "index.php");
                    
                }

            }

        }
        
    }
    
    /**
     * Log the student out
     */
    public function logout() {
        
        $this->User_model->logout();
        
    }
    
    /**
     * Render an allowed page.
     * 
     * @param String $page
     */
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
            
            
            $id = $this->User_model->getIdByEmail($this->session->userdata("email"));
            $user = $this->User_model->getUserById($id);
            
            $data["user"] = $user;
            
            $this->load->view("templates/header.php");
            $this->load->view("pages/" . $page . ".php", $data);
            $this->load->view("templates/footer.php");
        
        }
        
    }

}