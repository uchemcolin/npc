<?php
    class Parent_model extends CI_Model {
        //This function runs once the class has been initiated (its a php construct method)
        public function __construct() {
            //$this->load->database();
        }

        //Function to get the profile of a parent by Parent ID
        public function findParentById($parent_id) {
            $query = $this->db->get_where("parents", array('id' => $parent_id));
            return $query->result_array();
        }

        public function findParentByChildId($child_id) {
            $query = $this->db->get_where("parents", array('child_id' => $child_id));
            return $query->result_array();
        }

        public function findParentByAdultId($adult_id) {
            $query = $this->db->get_where("parents", array('adult_id' => $adult_id));
            return $query->result_array();
        }

        //Function to get the profile of a parent by Parent ID
        public function findParentBySearch($search) {
            $this->db->like("id", $search);
            $this->db->or_like("nin_number", $search);
            $this->db->or_like("firstname", $search);
            $this->db->or_like("lastname", $search);
            $this->db->or_like("middlename", $search);
            $this->db->or_like("gender", $search);
            $this->db->or_like("phone", $search);
            $this->db->or_like("state_of_origin", $search);
            $this->db->or_like("address", $search);
			$this->db->or_like("city", $search);
			$this->db->or_like("state", $search);
            //$query = $this->db->get("parents");
            $query = $this->db->get("nins");
            return $query->result_array();
        }

        //Function to get all the parents of the company
        public function findParents() {
			//$this->db->order_by("visiting_date", "asc");
            $query = $this->db->get("parents");
            return $query->result_array();
		}

        //Funtion to check if the email exists when a user is creating an account
        public function check_email_exists_for_reg($email) {
            $query = $this->db->get_where("parents", array("email" => $email));
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
