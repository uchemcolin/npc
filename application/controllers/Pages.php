<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

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
        $this->load->model("user_model");
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('user_agent');
        $this->load->helper('html');
        $this->load->helper('security');
        $this->load->library('email');
        //$this->load->helper('ajax');

        //Set the timezone of the site to Africa/Lagos
        date_default_timezone_set("Africa/Lagos");
    }

    public function root() {
        echo $_SERVER["DOCUMENT_ROOT"];
    }

	public function index()
	{
        $data = array(
            "title" => "KMS :: Home"
        );

        $this->load->view('pages/inc/header', $data);
        $this->load->view("pages/inc/navbar", $data);
        $this->load->view('pages/index');
        $this->load->view('pages/inc/footer');
    }

    public function about()
	{
        $data = array(
            "title" => "KMS :: About"
        );

        $this->load->view('pages/inc/header', $data);
        $this->load->view("pages/inc/navbar", $data);
        $this->load->view('pages/about');
        $this->load->view('pages/inc/footer');
    }

    public function services()
	{
        $data = array(
            "title" => "KMS :: Services"
        );

        $this->load->view('pages/inc/header', $data);
        $this->load->view("pages/inc/navbar", $data);
        $this->load->view('pages/services');
        $this->load->view('pages/inc/footer');
    }

    public function contact()
	{
        $data = array(
            "title" => "KMS :: Contact"
        );

        $this->load->view('pages/inc/header', $data);
        $this->load->view("pages/inc/navbar", $data);
        $this->load->view('pages/contact');
        $this->load->view('pages/inc/footer');
    }
}