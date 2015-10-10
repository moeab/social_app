<?php
class User extends CI_model {
	public function fetch_all(){
		$query = "SELECT users.id, first_name, last_name, email, password, description, 
					users.created_at, users.updated_at, user_level FROM users 
				JOIN permissions ON user_id = users.id;";
		return $this->db->query($query)->result_array();
	}
	public function fetch_one($email){
		$query = "SELECT * FROM users WHERE email = ?;";
		return $this->db->query($query, $email)->row_array();
	}
	public function user_id($id){
		$query = "SELECT * FROM users JOIN permissions ON user_id = users.id WHERE users.id = ?;";
		return $this->db->query($query, $id)->row_array();
	}
	public function register($value){
		$query = "INSERT INTO users (email, first_name, last_name, password, created_at, updated_at) VALUES (?,?,?,?, NOW(), NOW());";
		$fetch_perms = "SELECT id FROM permissions;";
		$perms_query = "INSERT INTO permissions (user_id, user_level) VALUES (?, ?);";
		$this->load->library("form_validation");
		$config = array(
			   	array(
                     'field'   => 'email', 
                     'label'   => 'Email Address', 
                     'rules'   => 'required|valid_email|is_unique[users.email]|xss_clean'
                  	),
               	array(
                     'field'   => 'first_name', 
                     'label'   => 'First Name', 
                     'rules'   => 'required|xss_clean'
                  	),
               	array(
                     'field'   => 'last_name', 
                     'label'   => 'Last Name', 
                     'rules'   => 'required|xss_clean'
                  	),
               	array(
                     'field'   => 'password', 
                     'label'   => 'Password', 
                     'rules'   => 'required|xss_clean|min_length[8]'
                 	),
              	 array(
                     'field'   => 'password_conf', 
                     'label'   => 'Password Confirmation', 
                     'rules'   => 'required|matches[password]|xss_clean'
                  	)
            	);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
			if (isset($value['register'])) {
				redirect('/users/register');
			} else {
				redirect('/users/add_new');
			}
		} else {
			$value['password'] = md5($value['password']);
			$user = $this->db->query($query, $value);
			$fetch_user = $this->user->fetch_one($value['email']);
			$perms_check = $this->db->query($fetch_perms)->row_array();
			$admin = array($fetch_user['id'], 'Admin');
			$normal = array($fetch_user['id'], 'Normal');
			if ($perms_check == NULL){
				$this->db->query($perms_query, $admin);
			} else {
				$this->db->query($perms_query, $normal);
			}
		}
	}
	public function sign_in($input){
		$query = "SELECT * FROM users JOIN permissions ON user_id = users.id WHERE email = ?";
		$input['password'] = md5($input['password']);
		$query_run = $this->db->query($query, $input['email'])->row_array();
		if ($query_run == NULL || $input['password'] !== $query_run['password']){
			$this->session->set_flashdata('errors', '<p>Email/Password Combination is incorrect</p>');
			redirect('/users/sign_in');
		} else {
			return $query_run;
		}
	}
	public function user_update($id, $input){
		$user_info = array($input['email'], $input['first_name'], $input['last_name']);
		$this->load->library("form_validation");
		$config = array(
			   	array(
                     'field'   => 'email', 
                     'label'   => 'Email Address', 
                     'rules'   => 'required|valid_email|xss_clean'
                  	),
               	array(
                     'field'   => 'first_name', 
                     'label'   => 'First Name', 
                     'rules'   => 'required|xss_clean'
                  	),
               	array(
                     'field'   => 'last_name', 
                     'label'   => 'Last Name', 
                     'rules'   => 'required|xss_clean'
                  	),
            	);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect("/users/edit/{$id}");
		} else {
			$query = "UPDATE users SET email = ?, first_name = ?, last_name = ? WHERE users.id = {$id};";
			$this->db->query($query, $user_info);
			if (!empty($input['user_level'])){
				$permission = $input['user_level'];
				$perm_query = "UPDATE permissions SET user_level = '{$permission}' WHERE user_id = {$id};";
				$this->db->query($perm_query);
			}
			redirect('/users/dashboard');
		}
	}
	public function password_update($id, $input){
		$query = "SELECT * FROM users WHERE users.id = {$id}";
		$query_run = $this->db->query($query)->row_array();
		$this->load->library("form_validation");
		$config = array(
		   		array(
                 'field'   => 'current_password', 
                 'label'   => 'Current Password', 
                 'rules'   => 'required|xss_clean'
              	),
           		array(
                 'field'   => 'new_password', 
                 'label'   => 'New Password', 
                 'rules'   => 'required|xss_clean|min_length[8]'
              	),
           		array(
                 'field'   => 'password_conf', 
                 'label'   => 'Password Confirmation', 
                 'rules'   => 'required|xss_clean|matches[new_password]'
              	),
        	);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect("/users/edit/{$id}");
		} else {
			$input['current_password'] = md5($input['current_password']);
			$input['new_password'] = md5($input['new_password']);
			if($input['current_password'] !== $query_run['password']){
				$this->session->set_flashdata('errors', '<p>Please enter the correct current password</p>');
				redirect("/users/edit/{$id}");
			} else {
				$query = "UPDATE users SET password = '{$input['new_password']}' WHERE users.id = {$id};";
				$this->db->query($query);
				$this->session->set_flashdata('success', '<p>Password has been successfully changed for ' . $query_run['first_name'] . ' ' .  $query_run['last_name'] .'</p>');
				redirect('/users/dashboard');
			}
		}
	}
	public function description_update($id, $input){
		$query = "UPDATE users SET description = '{$input['description']}' WHERE users.id = {$id};";
		$this->db->query($query);
		redirect("/users/profile/{$id}");
	}
	public function remove($id){
		$user_query = "DELETE FROM users WHERE id = ?;";
		$perm_query = " DELETE FROM permissions WHERE user_id = ?;";
		$this->db->query($user_query, $id);
		$this->db->query($perm_query, $id);
		redirect('/users/dashboard');
	}
}

?>