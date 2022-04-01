<?php
    class Lga_model extends CI_Model {
        //This function runs once the class has been initiated (its a php construct method)
        public function __construct() {
            //$this->load->database();
        }

        //Function to get the profile of a lga by Lga ID
        public function findLgaById($lga_id) {
            $query = $this->db->get_where("lgas", array('id' => $lga_id));
            return $query->result_array();
        }

        public function findLgaByStateId($state_id_to_use) {
            $query = $this->db->get_where("lgas", array('state_id' => $state_id_to_use));
            return $query->result_array();
        }

        //Function to get the profile of a lga by Lga ID
        public function findLgaBySearch($search) {
            //id	lga_number	family_planlgag_certificate_id	created_at_day	created_at_month	created_at_year	created_at	
            $this->db->like("id", $search);
            $this->db->or_like("lga_number", $search);
            $this->db->or_like("firstname", $search);
            $this->db->or_like("lastname", $search);
            $this->db->or_like("middlename", $search);
            $this->db->or_like("gender", $search);
            $this->db->or_like("phone", $search);
            $this->db->or_like("lga_of_origin", $search);
            $this->db->or_like("address", $search);
            $this->db->or_like("city", $search);
            $this->db->or_like("lga", $search);
            //query = $this->db->ge$this->db->or_like("lga", $search);
            //$t("lgas");
            $query = $this->db->get("lgas");
            return $query->result_array();
        }

        //Function to get the profile of a lga by Lga ID
        public function findLgaByFilter($input) {
            //id	lga_number	family_planlgag_certificate_id	created_at_day	created_at_month	created_at_year	created_at	

            if($input["age"] != "") {

                if($input["age"] != "65+") {
                    $age_explode = explode("-", $input["age"]);

                    $lower_age = $age_explode[0];
                    $higher_age = $age_explode[1];

                    
                } else {
                    $lower_age = 65;
                    $higher_age = 200;
                }

                $lower_year = date("Y") - $lower_age;
                $higher_year = date("Y") - $higher_age;

                $lower_date = $lower_year."-01-01";
                $higher_date = $higher_year."-01-01";

                //$this->db->where("date_of_birth >=", $lower_date);
                //$this->db->where("date_of_birth <=", $higher_date);

                $this->db->where("date_of_birth >=", $higher_date);
                $this->db->where("date_of_birth <=", $lower_date);
            }

            if($input["status"] != "") {

                if($input["status"] == "alive") {
                    $this->db->where("status", $input["status"]);
                }

                if($input["status"] == "dead") {
                    $this->db->where("status", $input["status"]);
                }
            }

            if($input["from"] != "") {
                
                $this->db->where("created_at_year >=", $input["from"]);
            }

            if($input["to"] != "") {
                
                $this->db->where("created_at_year <=", $input["to"]);
            }

            $query = $this->db->get("lgas");
            return $query->result_array();
        }

        //Function to get all the lgas of the company
        public function findLgas() {
			//$this->db->order_by("visiting_date", "asc");
            $query = $this->db->get("lgas");
            return $query->result_array();
		}

        //Funtion to check if the email exists when a user is creating an account
        public function check_email_exists_for_reg($email) {
            $query = $this->db->get_where("lgas", array("email" => $email));
            $query_rows = $query->num_rows();

            if($query_rows > 0) {
                //return true;
                echo $query_rows;
            } else {
                //return false;
                echo 0;
            }
        }
    }
?>
