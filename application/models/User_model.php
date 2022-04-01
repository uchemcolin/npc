<?php
    class User_model extends CI_Model {
        //This function runs once the class has been initiated (its a php construct method)
        public function __construct() {
            //$this->load->database();
        }

        //Function to create/register a new user
        public function create_user($user) {

            //Encrypt the person's password using password hash
            $password_hash = password_hash($user["password"], PASSWORD_BCRYPT);

            $user["password"] = $password_hash;
            //Insert the new user's details into the database
            $this->db->insert('users', $user);

            $affected_rows = $this->db->affected_rows(); //Get the no of affected rows (its 1 if the creation was successful)

            //If the insertion was successful, get the no of users in the database and return it as the user_id
            if($affected_rows > 0) {
                return $affected_rows;
            } else {
                return 0;
            }
        }

        //Funtion to check if the email exists when a user is creating an account
        public function check_email_exists_for_reg($email) {
            $query = $this->db->get_where("users", array("email" => $email));
            $query_rows = $query->num_rows();

            if($query_rows > 0) {
                //return true;
                echo $query_rows;
            } else {
                //return false;
                echo 0;
            }
        }

        //Funtion to check if the old password exists when a user is updating his/her login password from his/her profile
        public function check_old_password_exists($old_password) {
            $old_password = $old_password; //The old password as supplied by the user
            $user_info = $this->db->get_where('users', array("id" => $this->session->userdata["user_id"])); //Get the user's info
            $user_info_result = $user_info->result();

            

            if(!empty($user_info->row_array())) {
                foreach ($user_info->result() as $row)
                {
                    if(password_verify($old_password, $row->password)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

        //Function to login a user
        public function login_user($user) {
            $email = $user["email"];
            $password = $user["password"];
            $user_email = $this->db->get_where('users', array("email" => $email));
            $user_email_result = $user_email->result();

            if(!empty($user_email->row_array())) {
                foreach ($user_email->result() as $row)
                {
                    if(password_verify($password, $row->password)) {
                        return $user_email_result; //If the person's account exist, return all his/her info
                    } else {
                        return "second";
                    }
                }
            } else {
                return "first";
            }
        }

        //Function to get the no of referrals someone has (or no of people he/she has referred to register and probably play this game)
        public function get_no_of_users() {
            $query = $this->db->get_where("users");
            return $query->num_rows();
        }

        //Function to get all the profiles of users/it students in NNPC
        public function getAllProfiles() {
            $query = $this->db->get("users");
            return $query->result_array();
        }

        //Function to get the profile of a user/student
        public function getProfile($id) {
            $query = $this->db->get_where("users", array('id' => $id));
            return $query->result_array();
        }

        //Function to get the profile of a user/student by email
        public function getProfileEmail($email) {
            $query = $this->db->get_where("users", array('email' => $email));
            return $query->result_array();
        }

        //Function to update the user's email
        public function update_user_email($user) {

            //The new email
            $email = $user['email'];

            $user_to_update_id = $this->session->userdata["user_id"]; //The id of the user to update

            //Update it in the database
            $this->db->set('email', $email);
            $this->db->where('id', $user_to_update_id);
            $query = $this->db->update('users');

            //Return the no of affected rows (which is supposed to be 1) if it was successful
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }

        //Function to update the user's password
        public function update_user_password($user) {

            //Encrypt the person's new password using password hash
            $password_hash = password_hash($user["password"], PASSWORD_BCRYPT);

            //The new password
            $user["password"] = $password_hash;
            
            $password = $user['password'];

            $user_to_update_id = $this->session->userdata["user_id"]; //The id of the user to update

            //Update it in the database
            $this->db->set('password', $password);
            $this->db->where('id', $user_to_update_id);
            $query = $this->db->update('users');

            //Return the no of affected rows (which is supposed to be 1) if it was successful
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }

        //Function for if the user has forgotten his/her login password and needs to login
        public function forgot_password($user) {
            $email = $user["email"]; //The login email address
            $password = $user["new_password"]; //The newly made password (generated with codeigniter) for the user that will be sent to his/her login email

            $new_password = password_hash($new_password, PASSWORD_BCRYPT); //Encrypt the new password
            
            $user_to_update_id = $this->session->userdata["user_id"]; //The id of the user to update

            //Set the password to the newly created one
            $this->db->set('password', $new_password);
            $this->db->where('email', $email);
            $query = $this->db->update('users');

            //Return the no of affected rows (which is supposed to be 1) if it was successful
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }
    }
?>