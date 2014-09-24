<?php

class DocentSignup extends CI_Controller {

    public function __construct () {

        parent::__construct ();

        $this->load->model ("User_model");

    }

    private function controls () {

        /*
         * Check if logged in.
         */
        if ( ! $this->session->userdata ("docent-signup")) {

            header ("Location: " . base_url () . "index.php/docentsignuplogin");
            exit (0);

        }

        /*
         * Check if user is trying to create an account
         */
        if (isset ($_POST["submit_register"])) {

            $param_email               = $_POST["param_email"];
            $param_firstname           = $_POST["param_firstname"];
            $param_lastname            = $_POST["param_lastname"];
            $param_password            = $_POST["param_password"];
            $param_password_confirm    = $_POST["param_password_confirmation"];

            //If all fields are filled in
            if (isset ($param_email)
             && isset ($param_firstname)
             && isset ($param_lastname)
             && isset ($param_password)
             && isset ($param_password_confirm)) {

                //If passwords don't match; exit
                if ( ! $param_password == $param_password_confirm) {

                    $this->session->set_userdata ("warning", "Your passwords did not match.");
                    header ("Location: " . base_url () . "index.php/docentsignup");
                    exit (0);

                }

                //Register the account
                $this->User_model->register ($param_email, $param_password, $param_password_confirm, $param_firstname, $param_lastname, 1, 0);

                //Notify the user of our success.
                $this->session->set_userdata ("warning", "Your account was created, you can now log in.");
                header ("Location: " . base_url () . "index.php");
                exit (0);

            }

        }

    }

    public function index () {

        $this->controls ();

        $this->load->view ("templates/header.php");
        $this->load->view ("pages/docent_register.php");
        $this->load->view ("templates/header.php");


    }

}