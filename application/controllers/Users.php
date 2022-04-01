<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    function __construct() {
        parent::__construct();
		$this->load->model("company_admin_model");
        $this->load->library('form_validation');
        $this->load->helper('html');
        $this->load->helper('cookie');
        $this->load->model("user_model");

        //$this->load->helper('ajax');

        //Set the timezone of the site to Africa/Lagos
        date_default_timezone_set("Africa/Lagos");

        //If there is currently a logged in user
        //redirect him/her to the admin/index controller/function
        /*if(!$this->session->has_userdata("supervisor_id")) {
            redirect("pages/login_2");
        }*/
    }

	//The index page
	public function index()
	{
        //Only admins are expected to access the website
        //once the site loads
        if(!$this->session->tempdata("npc_company_admin_id")) {
            redirect("users/login");

            //return var_dump("company_admin_id: ".$this->session->userdata("company_admin_id"));
        }

        $company_name = "NPC";

        $data = array(
            "title" => "$company_name",
            "company_name" => $company_name
        );

        $this->load->view('user/inc/header', $data);
        $this->load->view("user/inc/navbar", $data);
        $this->load->view('user/index');
        $this->load->view('user/inc/footer');
    }

    //The login page form
	public function login()
	{
        if($this->session->tempdata("npc_company_admin_id")) {
            redirect("users/index");
        }

        $company_name = "NPC";

        $data = array(
            "title" => "$company_name",
            "company_name" => $company_name
        );

        $this->load->view('user/inc/header', $data);
        $this->load->view("user/inc/navbar", $data);
        $this->load->view('user/login');
        $this->load->view('user/inc/footer');
    }

    //The function to login admin
	public function login_company_admin()
	{

        if($this->session->tempdata("npc_company_admin_id")) {;
            redirect("company_admins/index");

            //return var_dump("company_admin_id: ".$this->session->userdata("company_admin_id"));
        } else {
            $company_name = "NPC";

            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email',
            array(
                    'required'      => 'You have not provided %s.',
                    'valid_email'     => 'Please provide a valid %s.'
            ));

            $this->form_validation->set_rules(
                'password', 'Password',
                'required|min_length[6]|max_length[30]',
                array(
                        'required'      => 'You have not provided %s.',
                        'min_length[6]'     => 'Your %s should be at least 6 characters long.',
                        'max_length[30]'     => 'Your %s should be at most 30 characters long.'
                )
            );

            if($this->form_validation->run() == FALSE) {
                $data = array(
                    "title" => "$company_name",
                    "company_name" => $company_name
                );

                $this->load->view('user/inc/header', $data);
                $this->load->view("user/inc/navbar", $data);
                $this->load->view('user/login');
                $this->load->view('user/inc/footer');
            } else {
                $company_admin = array(
                    'email' => $email,
                    'password' => $password
                );

                $company_admin_query = $this->company_admin_model->login_company_admin($company_admin);

                //return var_dump($company_admin_query);

                if($company_admin_query == "first" || $company_admin_query == "second") {
                    $this->session->set_flashdata("error",
                    "Login failed! Email or password is invalid");

                    //return var_dump($company_admin_query." email or password wrong");

                    redirect("users/login");
                } else {

                    //echo $user_query->username;
                    foreach($company_admin_query as $row) {
                        $company_admin_id = $row->id;

                        $userdata = array(
                            //'company_admin_id' => $row->id,
                            'company_admin_email'  => $row->email,
                            'created_at' => $row->created_at,
                            'logged_in' => TRUE
                        );
                    }

                    //Set the company_admin_id session to expire in 1day time
                    $this->session->set_tempdata('npc_company_admin_id', $company_admin_id, 86400);
        
                    $this->session->set_userdata($userdata);

                    $this->session->set_flashdata("success",
                    "You have successfully logged in ");

                    //return var_dump($company_admin_query);

                    //redirect("company_admins/index");

                    redirect("company_admins/index");

                    //return var_dump($company_admin_query);
                    //return var_dump($userdata);
                    //return var_dump("company admin query: ".$company_admin_query["company_admin_email"]);
                }
            }
        }
    }

    //When a company admin/editor/viewer account forgets his/her password
    //He should fill this form
    public function forgot_password()
	{
        //If there is currently a logged in company admin
        //redirect him/her to the admin/index controller/function
        if($this->session->tempdata("npc_company_admin_id")) {;
            redirect("company_admins/index");

            //return var_dump("company_admin_id: ".$this->session->userdata("company_admin_id"));
        }

        $company_name = "NPC";

        $data = array(
            "title" => "$company_name",
            "company_name" => $company_name
        );

        $this->load->view('user/inc/header', $data);
        $this->load->view("user/inc/navbar", $data);
        $this->load->view('user/forgot_password');
        $this->load->view('user/inc/footer');
    }

    //Generate a new password for the suer and send it to his/her email
    public function send_password()
	{
        //If there is currently a logged in company admin
        //redirect him/her to the company_admins/index controller/function
        if($this->session->tempdata("npc_company_admin_id")) {
            redirect("company_admins/index");

            //return var_dump("company_admin_id: ".$this->session->userdata("company_admin_id"));
        }

        $company_name = "NPC";

        //reset password of the company's admin/editor/viewer account and send them an email
        $email = $this->input->post('email');
        
        //$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]',
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email',
        array(
                'required'      => 'You have not provided your %s.',
                'valid_email'     => 'Please provide a valid %s.'
        ));

        if($this->form_validation->run() == FALSE) {
            $data = array(
                "title" => "$company_name",
                "company_name" => $company_name
            );
    
            $this->load->view('user/inc/header', $data);
            $this->load->view("user/inc/navbar", $data);
            $this->load->view('user/forgot_password');
            $this->load->view('user/inc/footer');
        } else {
            //Generate a new password for the account to use and login
            $password = random_string('alnum', 10);

            //$new_password_hash = password_hash($password, PASSWORD_BCRYPT);

            $account = array(
                'email' => $email,
                //'password' => $new_password_hash
                'password' => $password
            );

            $account_forgot_password = $this->company_admin_model->company_admin_forgot_password($account);

            if($account_forgot_password != 0) {
                $config = Array(
                    'protocol' => 'smtp',
                    //'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => 587,
                    'smtp_user' => 'npctest495@gmail.com',
                    'smtp_pass' => 'npctesttemplemorris',
                    'mailtype'  => 'html',
                    'smtp_crypto' => 'tls',
                    'charset'   => 'utf-8'
                );
        
                $this->email->initialize($config);
        
                $this->email->set_newline("\r\n");
                //$this->load->library('email', $config);
        
                $this->email->from('npctest495@gmail.com', 'NPC');
                $this->email->to($email);

                $vr_company_start_year = 2020;

                if($vr_company_start_year == date("Y")) {
                    $year = date("Y");
                } else {
                    $year = $vr_company_start_year." - ".date("Y");
                }
        
                $message = "<h3><center>Your New Password</center></h3>
                            <p>Here's your new password:</p>
                            <p>
                                Email: $email
                                <br/>
                                Password: $password
                                <br/>
                                Company Name: $company_name
                            </p>
                            <p>
                                You can use it to login and update your password from your account to whatever you'd like or
                                 you can continue to use this one if you like
                            </p>
                            <p><a href='".base_url()."users/login'>Login</a> to your account</p>
                            <p>Copyright © NPC $year";
        
                $this->email->subject("NPC: Password Recovery");
                //$this->email->message('<h1>Testing the email class.</h1>');
                $this->email->message($message);

                //$this->email->send();
        
                if(!$this->email->send()) {
                    //echo "it didn't send";
                    //echo $this->email->print_debugger();
                    $this->session->set_flashdata("password_not_sent",
                    "There was an error, please retry");
                } else {
                    $this->session->set_flashdata("password_sent",
                    "A new password has been sent to your email. Please login to check it");
                }

                redirect("users/forgot_password");
            } else {
                $this->session->set_flashdata("password_not_sent",
                "There was an error, please retry");

                redirect("users/forgot_password");
            }
        }
	}
}
