<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	public function index()
	{
		if ($this->session->userdata('logged_in')){
			redirect('/users/dashboard');
		} else {
		$this->load->view('index');
		}
	}
	public function register(){
		$this->load->view('register');
	}
	public function register_process(){
		$input = $this->input->post();
		$this->load->model('user');
		$this->user->register($input);
		if (isset($input['register'])){
			redirect('/users/sign_in');
		} else {
			redirect('/users/dashboard');
		}
	}
	public function sign_in(){
		$this->load->view('signin');
	}
	public function signin_process(){
		$input = $this->input->post();
		$this->load->model('user');
		$verified = $this->user->sign_in($input);
		$this->session->set_userdata('logged_in', $verified);
		redirect('/users/dashboard');
	}
	public function dashboard(){
		$this->load->model('user');
		$list = array('list' => $this->user->fetch_all());
		$this->load->view('dashboard', $list);
	}
	public function add_new(){
		$this->load->view('new');
	}
	public function profile($id){
		$this->load->model('user');
		$this->load->model('message');
		$user = array('user' => $this->user->user_id($id), 'message' => $this->message->get_messages($id), 'comment' => $this->message->get_comments());
		$this->load->view('profile', $user);
	}
	public function edit($id){
		$this->load->model('user');
		$user = array('user' => $this->user->user_id($id));
		$this->load->view('edit', $user);
	}
	public function update($id){
		$this->load->model('user');
		$input = $this->input->post();
		if (!empty($input['user_edit'])){
			$this->user->user_update($id, $input);
		} else if (!empty($input['password_edit'])){
			$this->user->password_update($id, $input);
		} else if (!empty($input['description_edit'])){
			$this->user->description_update($id, $input);
		}
		
	}
	public function delete($id){
		$this->load->model('user');
		$this->user->remove($id);
	}
	public function log_off(){
		$this->session->sess_destroy();
		redirect('');
	}
}