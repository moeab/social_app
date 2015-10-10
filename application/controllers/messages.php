<?php
class Messages extends CI_controller {
	public function new_message($id){
		$input = $this->input->post();
		$this->load->model('message');
		$session = $this->session->userdata('logged_in');
		$values = array('message' => $input['message'], 'id' => $id, 'session' => $session['user_id']);
		$this->message->new_message($values);
	}
	public function comment($user, $message_id){
		$this->load->model('message');
		$comment = $this->input->post('comment');
		$this->message->comment($user, $message_id, $comment);

	}
	public function delete_message($message_id, $view_user){
		$this->load->model('message');
		$this->message->delete_message($message_id);
		redirect("/users/profile/{$view_user}");
	}
	public function delete_comment($comment_id, $view_user){
		$this->load->model('message');
		$this->message->delete_comment($comment_id);
		redirect("/users/profile/{$view_user}");
	}
}
?>