<?php
class Message extends CI_model {
	public function new_message($values){
		$query = "INSERT INTO messages (message, created_at, updated_at, user_id, from_user) VALUES (?, NOW(), NOW(), ?, ?);";
		if (empty($values['message'])){
			$this->session->set_flashdata('errors', '<p>Message cannot be blank</p>');
			redirect("/users/profile/{$values['id']}");
		} else {
			$this->db->query($query, $values);
			redirect("/users/profile/{$values['id']}");
		}
	}
	public function get_messages($id){
		$query = "SELECT message, messages.created_at, users.first_name, users.last_name, from_user, messages.id  FROM messages JOIN users ON from_user = users.id WHERE user_id = {$id}";
		return $this->db->query($query)->result_array();
	}
	public function comment($user, $message_id, $comment){
		$query = "INSERT INTO comments (user_id, message_id, comment, created_at, updated_at) VALUES (?, ? , ?, NOW(), NOW());";
		$values = array($user, $message_id, $comment);
		if (empty($comment)){
			$this->session->set_flashdata('errors', '<p>Comment cannot be blank</p>');
			redirect("/users/profile/{$user}");
		} else {
			$this->db->query($query, $values);
			redirect("/users/profile/{$user}");
		}
	}
	public function get_comments(){
		$query = "SELECT comments.id, comment, comments.created_at, message_id, first_name, last_name, user_id FROM comments JOIN users ON user_id = users.id ORDER BY comments.created_at ASC;";
		return $this->db->query($query)->result_array();

	}
	public function delete_message($message_id){
		$query = "DELETE FROM messages WHERE messages.id = {$message_id};";
		$comments_delete =  "DELETE FROM comments WHERE message_id = {$message_id};";
		$this->db->query($comments_delete);
		return $this->db->query($query);
	}
	public function delete_comment($comment_id){
		$query = "DELETE FROM comments WHERE comments.id = {$comment_id};";
		return $this->db->query($query);
	}
}
?>