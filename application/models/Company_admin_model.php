<?php
    class Company_admin_model extends CI_Model {
        //This function runs once the class has been initiated (its a php construct method)
        public function __construct() {
            //$this->load->database();
        }

        //Function to login a user
        public function login_company_admin($company_admin) {
            $email = $company_admin["email"];
            $password = $company_admin["password"];
            $company_admin_email = $this->db->get_where('users', array("email" => $email)); //get the email of the admin where the company id is the same as the company being accessed
            $company_admin_email_result = $company_admin_email->result();

            if(!empty($company_admin_email->row_array())) {
                foreach ($company_admin_email->result() as $row)
                {
                    if(password_verify($password, $row->password)) {
                        return $company_admin_email_result; //If the person's account exist, return all his/her info
                    } else {
                        return "second";
                    }
                }
            } else {
                return "first";
            }
        }

        //Function to get the Admin of a company by the Admin id (id)
        //from the company_admins table
        public function getAdminById($company_admin_id) {
            $query = $this->db->get_where("users", array('id' => $company_admin_id));
            return $query->result_array();
        }

        //Function to get the Admin of a company by the Admin id (id)
        //from the company_admins table
        public function findAdminById($company_admin_id) {
            $query = $this->db->get_where("users", array('id' => $company_admin_id));
            return $query->result_array();
        }

        //Function to get the Admins of the company
        //from the company_admins table
        public function findAllAdmins() {
            $query = $this->db->get("users");
            return $query->result_array();
        }

        //Function to create/register a new company admin account
        public function create_admin_account($new_admin_account) {

            //Encrypt the person's password using password hash
            $password_hash = password_hash($new_admin_account["password"], PASSWORD_BCRYPT);

            $new_admin_account["password"] = $password_hash;
            //Insert the new user's details into the database
            $this->db->insert('users', $new_admin_account);

            $affected_rows = $this->db->affected_rows(); //Get the no of affected rows (its 1 if the creation was successful)

            //If the insertion was successful, get the no of users in the database and return it as the user_id
            if($affected_rows > 0) {
                return $affected_rows;
            } else {
                return 0;
            }
        }

        //Function to update the admin's account role
        public function update_admin_account($account) {

            //Update it in the database
            $this->db->set('role', $account["role"]);
            $this->db->where('id', $account["company_admin_to_edit_id"]);
            $query = $this->db->update('users');

            //Return the no of affected rows (which is supposed to be 1) if it was successful
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }

        //Function to delete a company's admin's account
        public function delete_admin_account($account) {

            //Delete the account
            $this->db->where('id', $account["company_admin_to_delete_id"]);
            $this->db->delete('users');

            //Return the no of affected rows (which is supposed to be 1) if it was successful
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }


        //Function to update the admin's account email
        public function update_account_email($account) {

            //Update it in the database
            $this->db->set('email', $account["email"]);
            $this->db->where('id', $account["company_admin_id"]);
            $query = $this->db->update('users');

            //Return the no of affected rows (which is supposed to be 1) if it was successful
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }

        //Function to update the admin's account password
        public function update_account_password($account) {

            //Encrypt the person's new password using password hash
            $password_hash = password_hash($account["password"], PASSWORD_BCRYPT);

            //The new password
            $account["password"] = $password_hash;
            
            $password = $account['password'];

            //Update it in the database
            $this->db->set('password', $password);
            $this->db->where('id', $account["company_admin_id"]);
            $query = $this->db->update('users');

            //Return the no of affected rows (which is supposed to be 1) if it was successful
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }

        //Function to get the profile of a staff by Staff ID
        public function findStaff($id) {
            $query = $this->db->get_where("staffs", array('id' => $id));
            return $query->result_array();
        }

        //Function for if the user has forgotten his/her login password and needs to login
        public function company_admin_forgot_password($account) {
            $email = $account["email"]; //The login email address
            $password = $account["password"]; //The newly made password (generated with codeigniter) for the user that will be sent to his/her login email

            $new_password = password_hash($password, PASSWORD_BCRYPT); //Encrypt the new password
            
            //$user_to_update_id = $this->session->userdata["user_id"]; //The id of the user to update

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