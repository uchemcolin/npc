<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_admins extends CI_Controller {

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
        $this->load->model("user_model");
        $this->load->model("state_model");
        $this->load->model("lga_model");
        $this->load->model("ward_model");
        $this->load->model("citizen_model");

        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('user_agent');
        $this->load->helper('html');
        $this->load->helper('security');
        $this->load->helper('string');
        $this->load->library('email');
        $this->load->helper('cookie');
        //$this->load->helper('ajax');

        //Set the timezone of the site to Africa/Lagos
        date_default_timezone_set("Africa/Lagos");

        //If the user is not logged in, redirect to login page
        if(!$this->session->tempdata("npc_company_admin_id")) {

            redirect("users/login");
        } else {
            //
		}
    }

    //The index page
	public function index()
	{
        //redirect back to login page
        //it should be the index page for npc for now
        //redirect("users/login");
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");

        $company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        $citizens = $this->citizen_model->findCitizens();

		$company_name = "NPC";

        $data = array(
            "title" => "$company_name",
            "company_name" => $company_name,
            "company_admin" => $company_admin,
			"citizens" => $citizens,
			//"childs" => $childs
        );

        $this->load->view('company_admin/inc/header', $data);
        $this->load->view("company_admin/inc/left_panel", $data);
        $this->load->view("company_admin/inc/right_panel", $data);
        $this->load->view('company_admin/index');
        $this->load->view('company_admin/inc/footer');
    }

	//The citizens page
	public function citizens()
	{
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");
		$company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        $citizens = $this->citizen_model->findCitizens();
		
		$company_name = "NPC";

		$data = array(
			"title" => "$company_name",
			"company_name" => $company_name,
			"company_admin" => $company_admin,
			"citizens" => $citizens
		);

        $this->load->view('company_admin/inc/header', $data);
        $this->load->view("company_admin/inc/left_panel", $data);
        $this->load->view("company_admin/inc/right_panel", $data);
		$this->load->view('company_admin/citizens', $data);
        $this->load->view('company_admin/inc/footer');
    }

    public function add_citizen() {
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");
		$company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        $company_name = "NPC";

        //$all_states = $this->state_model->findStates();

        //$ward = $this->ward_model->findWardByLgaId($lga_id_to_use);

        $wards = $this->ward_model->findWards();

        $data = array(
            "title" => "$company_name",
            "company_name" => $company_name,
			"company_admin" => $company_admin,
            //"state" => $state,
            //"lga" => $lga,
            "wards" => $wards
        );

        $this->load->view('company_admin/inc/header', $data);
        $this->load->view("company_admin/inc/left_panel", $data);
        $this->load->view("company_admin/inc/right_panel", $data);
		$this->load->view('company_admin/add_citizen_form', $data);
		$this->load->view('company_admin/inc/footer');
	}
	
	//Create a new citizen
    public function create_citizen()
	{
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");
		$company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        $company_name = "NPC";
        
        $check_spam = $this->input->post("check_spam");

        $name = ucwords($this->input->post('name'));
        $gender = ucfirst($this->input->post('gender'));
		$address = ucwords($this->input->post('address'));
		$phone = $this->input->post('phone');
        $ward_id = $this->input->post('ward_id');

        //If there is no form input, redirect to add_staffs()
        if(empty($this->input->post(NULL, TRUE) /* returns all POST items with XSS filter */)) {
            redirect("company_admins/add_citizen");
        }

        //Check for spam
        if($check_spam != "" || (!empty($check_spam))) {
            $this->session->set_flashdata("check_spam",
                "Spam are not allowed on this website");
            redirect("company_admins/add_citizen");
        }

        $this->form_validation->set_rules(
            'name', 'Name',
            'required|min_length[1]|max_length[100]',
            array(
                    'required'      => 'You have not provided the %s.',
                    'min_length[1]'     => '%s should be at least 1 character long.',
                    'max_length[100]'     => '%s should be at most 100 characters long.'
            )
        );

        $this->form_validation->set_rules(
            'gender', 'Gender',
            'required|min_length[1]|max_length[6]',
            array(
                    'required'      => 'You have not provided the %s.',
                    'min_length[1]'     => '%s should be at least 1 character long.',
                    'max_length[6]'     => '%s should be at most 6 characters long.'
            )
        );

        $this->form_validation->set_rules(
            'address', 'Address',
            'required|min_length[1]|max_length[255]',
            array(
                    'required'      => 'You have not provided the %s.',
                    'min_length[1]'     => '%s should be at least 1 character long.',
                    'max_length[255]'     => '%s should be at most 255 characters long.'
            )
		);

		$this->form_validation->set_rules(
			'phone', 'Phone Number',
			'required|callback_checkPhone',
			array(
					'required'      => 'You have not provided the %s.'
			)
		);

        $this->form_validation->set_rules(
            'ward_id', 'Ward',
            'required|min_length[1]|max_length[11]',
            array(
                    'required'      => 'You have not provided the %s.',
                    'min_length[1]'     => '%s should be at least 1 character long.',
                    'max_length[11]'     => '%s should be at most 11 characters long.'
            )
		);

        if($this->form_validation->run() == FALSE) {
            $data = array(
                "title" => "$company_name",
                "company_name" => $company_name,
                "company_admin" => $company_admin
            );

            $this->load->view('company_admin/inc/header', $data);
            $this->load->view("company_admin/inc/left_panel", $data);
            $this->load->view("company_admin/inc/right_panel", $data);
            $this->load->view('company_admin/add_citizen_form');
            $this->load->view('company_admin/inc/footer');

        } else {

			$this->db->trans_start(); //start transactions

            $citizen = array(
				'name' => ucwords($name),
				'gender' => $gender,
				'address' => $address,
				'phone' => $phone,
				'ward_id' => $ward_id,
                'created_at'=> date("Y-m-d")
            );

            $add_citizen_no = $this->citizen_model->create_citizen($citizen);

            if($add_citizen_no != 0) {

                $this->db->trans_complete(); //end transaction

				$this->session->set_flashdata("success",
				"The citizen has been successfully added.");
				
				redirect("company_admins/citizens");
                
            } else {
                $this->session->set_flashdata("error",
                "There was an error adding the citizen. Please try again.");

                redirect("company_admins/add_citizen");
            }
        }
	}

    public function adults_stats()
	{
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");
		$company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        //$search = "";

        //if($this->input->post("search")) {
        //if there is input, run this
        if(!$this->input->post(NULL, TRUE)) {

			$adults = array();
			$input = array();
            $age = "";
            $status = "";
            $from = "";
            $to = "";

            $men_in_abuja = 0;
            $men_in_anambra = 0;
            $men_in_lagos = 0;
            $men_in_kaduna = 0;
            $men_in_taraba = 0;
            $men_in_rivers = 0;

            $women_in_abuja = 0;
            $women_in_anambra = 0;
            $women_in_lagos = 0;
            $women_in_kaduna = 0;
            $women_in_taraba = 0;
            $women_in_rivers = 0;

			
        } else {
			$age = $this->input->post("age");
            $status = $this->input->post("status");
			$from = $this->input->post("from");
			$to = $this->input->post("to");
			
			$input = array(
                "age" => $age,
                "status" => $status,
                "from" => $from,
                "to" => $to
            );

            
            
            if(($from != "" && $to == "" ) || ($from == "" && $to != "" )) {
                $this->session->set_flashdata("error",
                    "Please both from and to dates should be provided.");
    
                    redirect("company_admins/adults_stats");
            } else {
                if($from > $to) {
                    $this->session->set_flashdata("error",
                    "Please from date should be lesser than or equal to the to date.");
    
                    redirect("company_admins/adults_stats");
                }
            }

            $men_in_abuja = 0;
            $men_in_anambra = 0;
            $men_in_lagos = 0;
            $men_in_kaduna = 0;
            $men_in_taraba = 0;
            $men_in_rivers = 0;

            $women_in_abuja = 0;
            $women_in_anambra = 0;
            $women_in_lagos = 0;
            $women_in_kaduna = 0;
            $women_in_taraba = 0;
            $women_in_rivers = 0;

            //return var_dump($input);

			//$adults = $this->adult_model->findApprovedAdults();
            //$adults = $this->nin_model->findNinBySearch($input);
            $adults = $this->nin_model->findNinByFilter($input);

            //return var_dump($this->db->last_query());

            foreach($adults as $adult) {

                if($adult["state"] == "Abuja") {
                    if($adult["gender"] == "Male") {
                        $men_in_abuja++;
                    }

                    if($adult["gender"] == "Female") {
                        $women_in_abuja++;
                    }
                }

                if($adult["state"] == "Anambra State") {
                    if($adult["gender"] == "Male") {
                        $men_in_anambra++;
                    }

                    if($adult["gender"] == "Female") {
                        $women_in_anambra++;
                    }
                }

                if($adult["state"] == "Lagos State") {
                    if($adult["gender"] == "Male") {
                        $men_in_lagos++;
                    }

                    if($adult["gender"] == "Female") {
                        $women_in_lagos++;
                    }
                }

                if($adult["state"] == "Kaduna State") {
                    if($adult["gender"] == "Male") {
                        $men_in_kaduna++;
                    }

                    if($adult["gender"] == "Female") {
                        $women_in_kaduna++;
                    }
                }

                if($adult["state"] == "Taraba State") {
                    if($adult["gender"] == "Male") {
                        $men_in_taraba++;
                    }

                    if($adult["gender"] == "Female") {
                        $women_in_taraba++;
                    }
                }

                if($adult["state"] == "Rivers State") {
                    if($adult["gender"] == "Male") {
                        $men_in_rivers++;
                    }

                    if($adult["gender"] == "Female") {
                        $women_in_rivers++;
                    }
                }
            }

            //return var_dump("no search");
		}
		
		$company_name = "NPC";

		$data = array(
			"title" => "$company_name",
			"company_name" => $company_name,
			"company_admin" => $company_admin,
			"input" => $input,
			"adults" => $adults,
            "age" => $age,
            "status" => $status,
            "from" => $from,
            "to" => $to,
            "men_in_abuja" => $men_in_abuja,
            "men_in_anambra" => $men_in_anambra,
            "men_in_lagos" => $men_in_lagos,
            "men_in_kaduna" => $men_in_kaduna,
            "men_in_taraba" => $men_in_taraba,
            "men_in_rivers" => $men_in_rivers,
            "women_in_abuja" => $women_in_abuja,
            "women_in_anambra" => $women_in_anambra,
            "women_in_lagos" => $women_in_lagos,
            "women_in_kaduna" => $women_in_kaduna,
            "women_in_taraba" => $women_in_taraba,
            "women_in_rivers" => $women_in_rivers
			/*"month" => $month,
			"year" => $year*/
			//"search" => $search
		);

        $this->load->view('company_admin/inc/header', $data);
        $this->load->view("company_admin/inc/left_panel", $data);
        $this->load->view("company_admin/inc/right_panel", $data);
		$this->load->view('company_admin/adults_stats', $data);
        $this->load->view('company_admin/inc/footer');
    }

    //The adults page
	public function childs()
	{
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");
		$company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        //$search = "";

        //if($this->input->post("search")) {
        //if there is input, run this
        if(!$this->input->post(NULL, TRUE)) {

			$childs = array();
			$input = array();
            $search = "";
            $month = "";
			$year = "";

			
        } else {
			$search = $this->input->post("search");
            $month = $this->input->post("month");
			$year = $this->input->post("year");
			$status = "approved";
			
			$input = array(
                "search" => $search,
                /*"month" => $month,
                "year" => $year,
                "status" => $status*/
			);

			//$adults = $this->adult_model->findApprovedAdults();
            //$adults = $this->nin_model->findNinBySearch($input);
            $childs = $this->child_model->findChildBySearch($search);

            //return var_dump("no search");
            //return var_dump($this->db->last_query());
		}
		
		$company_name = "NPC";

		$data = array(
			"title" => "$company_name",
			"company_name" => $company_name,
			"company_admin" => $company_admin,
			"input" => $input,
			"childs" => $childs,
			"search" => $search,
			/*"month" => $month,
			"year" => $year*/
			//"search" => $search
		);

        $this->load->view('company_admin/inc/header', $data);
        $this->load->view("company_admin/inc/left_panel", $data);
        $this->load->view("company_admin/inc/right_panel", $data);
		$this->load->view('company_admin/childs', $data);
        $this->load->view('company_admin/inc/footer');
    }

    public function childs_stats()
	{
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");
		$company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        //$search = "";

        //if($this->input->post("search")) {
        //if there is input, run this
        if(!$this->input->post(NULL, TRUE)) {

			$childs = array();
			$input = array();
            $age = "";
            $status = "";
            $from = "";
            $to = "";

            $boys_in_abuja = 0;
            $boys_in_anambra = 0;
            $boys_in_lagos = 0;
            $boys_in_kaduna = 0;
            $boys_in_taraba = 0;
            $boys_in_rivers = 0;

            $girls_in_abuja = 0;
            $girls_in_anambra = 0;
            $girls_in_lagos = 0;
            $girls_in_kaduna = 0;
            $girls_in_taraba = 0;
            $girls_in_rivers = 0;

			
        } else {
			$age = $this->input->post("age");
            $status = $this->input->post("status");
			$from = $this->input->post("from");
			$to = $this->input->post("to");
			
			$input = array(
                "age" => $age,
                "status" => $status,
                "from" => $from,
                "to" => $to
            );
            
            if(($from != "" && $to == "" ) || ($from == "" && $to != "" )) {
                $this->session->set_flashdata("error",
                    "Please both from and to dates should be provided.");
    
                    redirect("company_admins/adults_stats");
            } else {
                if($from > $to) {
                    $this->session->set_flashdata("error",
                    "Please from date should be lesser than or equal to the to date.");
    
                    redirect("company_admins/childs_stats");
                }
            }

            $boys_in_abuja = 0;
            $boys_in_anambra = 0;
            $boys_in_lagos = 0;
            $boys_in_kaduna = 0;
            $boys_in_taraba = 0;
            $boys_in_rivers = 0;

            $girls_in_abuja = 0;
            $girls_in_anambra = 0;
            $girls_in_lagos = 0;
            $girls_in_kaduna = 0;
            $girls_in_taraba = 0;
            $girls_in_rivers = 0;

			//$adults = $this->adult_model->findApprovedAdults();
            //$adults = $this->nin_model->findNinBySearch($input);
            $childs = $this->child_model->findChildByFilter($input);

            //return var_dump($this->db->last_query());

            foreach($childs as $child) {

                if($child["state"] == "Abuja") {
                    if($child["gender"] == "Male") {
                        $boys_in_abuja++;
                    }

                    if($child["gender"] == "Female") {
                        $girls_in_abuja++;
                    }
                }

                if($child["state"] == "Anambra State") {
                    if($child["gender"] == "Male") {
                        $boys_in_anambra++;
                    }

                    if($child["gender"] == "Female") {
                        $girls_in_anambra++;
                    }
                }

                if($child["state"] == "Lagos State") {
                    if($child["gender"] == "Male") {
                        $boys_in_lagos++;
                    }

                    if($boys["gender"] == "Female") {
                        $girls_in_lagos++;
                    }
                }

                if($child["state"] == "Kaduna State") {
                    if($child["gender"] == "Male") {
                        $boys_in_kaduna++;
                    }

                    if($child["gender"] == "Female") {
                        $girls_in_kaduna++;
                    }
                }

                if($child["state"] == "Taraba State") {
                    if($child["gender"] == "Male") {
                        $boys_in_taraba++;
                    }

                    if($child["gender"] == "Female") {
                        $girls_in_taraba++;
                    }
                }

                if($child["state"] == "Rivers State") {
                    if($child["gender"] == "Male") {
                        $boys_in_rivers++;
                    }

                    if($child["gender"] == "Female") {
                        $girls_in_rivers++;
                    }
                }
            }

            //return var_dump("no search");
		}
		
		$company_name = "NPC";

		$data = array(
			"title" => "$company_name",
			"company_name" => $company_name,
			"company_admin" => $company_admin,
			"input" => $input,
			"childs" => $childs,
            "age" => $age,
            "status" => $status,
            "from" => $from,
            "to" => $to,
            "boys_in_abuja" => $boys_in_abuja,
            "boys_in_anambra" => $boys_in_anambra,
            "boys_in_lagos" => $boys_in_lagos,
            "boys_in_kaduna" => $boys_in_kaduna,
            "boys_in_taraba" => $boys_in_taraba,
            "boys_in_rivers" => $boys_in_rivers,
            "girls_in_abuja" => $girls_in_abuja,
            "girls_in_anambra" => $girls_in_anambra,
            "girls_in_lagos" => $girls_in_lagos,
            "girls_in_kaduna" => $girls_in_kaduna,
            "girls_in_taraba" => $girls_in_taraba,
            "girls_in_rivers" => $girls_in_rivers
			/*"month" => $month,
			"year" => $year*/
			//"search" => $search
		);

        $this->load->view('company_admin/inc/header', $data);
        $this->load->view("company_admin/inc/left_panel", $data);
        $this->load->view("company_admin/inc/right_panel", $data);
		$this->load->view('company_admin/childs_stats', $data);
        $this->load->view('company_admin/inc/footer');
    }

    //The page to view the full details of the admin
    public function account() {
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");

        $company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        $company_name = "NPC";

        $data = array(
            "title" => "$company_name",
            "company_name" => $company_name,
            "company_admin" => $company_admin
        );

        $this->load->view('company_admin/inc/header', $data);
        $this->load->view("company_admin/inc/left_panel", $data);
        $this->load->view("company_admin/inc/right_panel", $data);
        $this->load->view('company_admin/account');
        $this->load->view('company_admin/inc/footer');
    }

    //The page to view the full details of the admin
    public function edit_account() {
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");

        $company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        $company_name = "NPC";

        $data = array(
            "title" => "$company_name",
            "company_name" => $company_name,
            "company_admin" => $company_admin
        );

        $this->load->view('company_admin/inc/header', $data);
        $this->load->view("company_admin/inc/left_panel", $data);
        $this->load->view("company_admin/inc/right_panel", $data);
        $this->load->view('company_admin/edit_account');
        $this->load->view('company_admin/inc/footer');
    }

    //Update the email of the user
    public function update_account_email()
	{   
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");

        //get current admin details
        $company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        //get all the company's admins
        $company_admins = $this->company_admin_model->findAllAdmins();

        $company_name = "NPC";

        $check_spam = $this->input->post("check_spam");

        $email = $this->input->post('email');

        //if(empty($username) || empty($email) || empty($password))

        if($check_spam != "" || (!empty($check_spam))) {
            $this->session->set_flashdata("check_spam",
                "Spam are not allowed on this website");
            redirect("company_admins/edit_account");
        }

        $this->form_validation->set_rules(
            'email', 'Email', 
            'required|valid_email|min_length[1]|max_length[50]',
        array(
                'required'      => 'You have not provided %s.',
                'valid_email'     => 'Please provide a valid %s.',
                'min_length[1]'     => 'Your %s should be at least 1 character long.',
                'max_length[50]'     => 'Your %s should be at most 50 characters long.'
        ));

        if($this->form_validation->run() == FALSE) {

            $data = array(
                "title" => "$company_name",
                "company_name" => $company_name,
                "company_admin" => $company_admin
            );

            $this->load->view('company_admin/inc/header', $data);
            $this->load->view("company_admin/inc/left_panel", $data);
            $this->load->view("company_admin/inc/right_panel", $data);
            $this->load->view('company_admin/edit_account', $data);
            $this->load->view('company_admin/inc/footer');
        } else {

            foreach($company_admins as $comp_admins) {
                //if an admin account with the email already exists
                //terminate the script and tell the person it already exists
                //by redirecting to the admin edit_account page and displaying the message there
                if($comp_admins["email"] == $email) {
                    $this->session->set_flashdata("error",
                    "An account with that email already exists, please use another email.");

                    redirect("company_admins/edit_account");
                }
            }
            
            $account = array(
                'email' => $email,
                'company_admin_id' => $company_admin_id
            );

            //Update company admin account email
            $update_account_email = $this->company_admin_model->update_account_email($account);
            
            //if it was not successful, let the person know
            if($update_account_email == 0) {
                $this->session->set_flashdata("error",
                "There was an error updating your account. Please try again.");

                redirect("company_admins/edit_account");
            } else {
                
                //Logout any currently logged in user and login the newly registered account
                //$this->session->sess_destroy();

                //Send a mail to the email
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
        
                $this->email->from('npc@gmail.com', 'NPC');
                //$user_email = $this->session->userdata("email");
                $this->email->to($email);

                //$user_email = $this->session->userdata("email");

                $npc_company_start_year = 2020;

                if($npc_company_start_year == date("Y")) {
                    $year = date("Y");
                } else {
                    $year = $npc_company_start_year." - ".date("Y");
                }
        
                $message = "<h3><center>National Population Commission</center></h3>
                            <p>Hello, your email has been changed to $email. Thanks.</p>
                            <p>
                                <center>Copyright © NPC $year</center>
                            </p>";
        
                $this->email->subject('Your account email has been changed');
                //$this->email->message('<h1>Testing the email class.</h1>');
                $this->email->message($message);

                $this->email->send();
        
                /*if(!$this->email->send()) {
                    //echo "it didn't send";
                    echo $this->email->print_debugger();
                } else {
                    echo "message sent";
                }*/

                $this->session->set_flashdata("success",
                "Your email has been successfully updated.");

                redirect("company_admins/account");
            }
        }
    }

    //Update passowrd of the user
    public function update_account_password()
	{
        $company_admin_id = $this->session->tempdata("npc_company_admin_id");

        //get current admin details
        $company_admin = $this->company_admin_model->findAdminById($company_admin_id);

        //get all the company's admins
        $company_admins = $this->company_admin_model->findAllAdmins();

        $company_name = "NPC";

        $check_spam = $this->input->post("check_spam");

        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_new_password = $this->input->post('confirm_new_password');

        //if(empty($username) || empty($email) || empty($password))

        if($check_spam != "" || (!empty($check_spam))) {
            $this->session->set_flashdata("check_spam",
                "Spam are not allowed on this website");
            redirect("company_admins/edit_account");
        }

        $this->form_validation->set_rules(
            'old_password', 'Old Password',
            'required|min_length[6]|max_length[30]|callback_check_account_old_password',
            array(
                'required'     => 'Please enter your %s',
                'min_length[6]'     => 'Your %s should be at least 6 characters long.',
                'max_length[30]'     => 'Your %s should be at most 30 characters long.'
            )
        );

        $this->form_validation->set_rules(
            'new_password', 'New Password',
            'required|min_length[6]|max_length[30]',
            array(
                    'required'     => 'Please enter your %s',
                    'min_length[6]'     => 'Your %s should be at least 6 characters long.',
                    'max_length[30]'     => 'Your %s should be at most 30 characters long.'
            )
        );

        $this->form_validation->set_rules('confirm_new_password', 'New Password Confirmation', 'matches[new_password]',
        array(
                'required'      => 'You have not provided your %s.',
                'matches[password]'     => 'Your %s does not match your passowrd.'
        ));

        if($this->form_validation->run() == FALSE) {
    
            $data = array(
                "title" => "$company_name",
                "company_name" => $company_name,
                "company_admin" => $company_admin
            );

            $this->load->view('company_admin/inc/header', $data);
            $this->load->view("company_admin/inc/left_panel", $data);
            $this->load->view("company_admin/inc/right_panel", $data);
            $this->load->view('company_admin/edit_account', $data);
            $this->load->view('company_admin/inc/footer');
        } else {
            

            $account = array(
                'password' => $new_password,
                'company_admin_id' => $company_admin_id
            );

            $update_account_password = $this->company_admin_model->update_account_password($account);
            
            if($update_account_password == 0) {
                $this->session->set_flashdata("error",
                "There was an error updating your account. Please try again.");

                redirect("company_admins/edit_account");
            } else {
                

                //Logout any currently logged in user and login the newly registered account
                //$this->session->sess_destroy();

                $this->session->set_flashdata("success",
                "Your password has been successfully updated.");

                redirect("company_admins/edit_account");
            }
        }
    }

    //Logout the currently loggedin admin/editor/viewer
    public function logout() {

        $this->session->set_flashdata("success",
            "You have successfully logged out.");

            $this->session->sess_destroy();
        
        redirect("users/login");
    }

    //edit user/student function to check if phone is a valid nigerian own
    public function checkPhone($phone) {
        $this->form_validation->set_message("checkPhone", "Please enter a valid phone number e.g 08181156157");

        //$phone = $this->input->post("phone");
        //$result = $this->user_model->check($email);

        //preg_match('/^[0]{1}[7-9]{1}[0-1]{1}[0-9]{8}', $phone)
        if((preg_match('/^[0]{1}[7-9]{1}[0-1]{1}[0-9]{8}/', $phone)) && (strlen($phone) == 11)) {
            //return true;
            //echo $result;
            return true;
        } else {
            //return false;
            //echo 0;
            return false;
        }
    }
}
