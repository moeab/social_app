<?php $this->load->view('partials/header') ?>
<?php $session = $this->session->userdata('logged_in'); ?>
<div class="nav">
	<h1>Test App</h1>
	<p>Profile</p>
	<a class="btn-info btn-lg" href="/users/dashboard">Dashboard</a>
	<a class="btn-info btn-lg" href="/users/log_off">Log Off</a>
</div>
<div class="profile">
	<h2><?php echo $user['first_name'] . ' ' . $user['last_name']; ?> </h2>
	<p>Registered at: <?php echo date('M jS Y', strtotime($user['created_at'])); ?></p>
	<p>User ID: #<?php echo $user['user_id'] ?></p>
	<p>Email address: <?php echo $user['email'] ?></p>
	<p>Description: <?php echo $user['description'] ?></p>
</div>
<div class="errors">
	<?php
		if ($this->session->flashdata('errors')){
			echo $this->session->flashdata('errors');
		}
	?>
</div>
<?php if ($session['user_id'] == $user["user_id"]) {?>
	<a href = <?php echo "/users/edit/" . $session['user_id']; ?> class="btn-info btn-lg edit">Edit Profile</a>
<?php } ?>
<div id="messages">
<?php if ($session['user_id'] != $user["user_id"]) {?>
		<form method="post" action=<?= "/messages/new_message/{$user['user_id']}" ?>>
			<label for="message">Leave a message for <?php echo $user['first_name']; ?></label>
			<textarea name="message"></textarea>
			<input class="btn-primary btn-sm" type="submit" value="post">
		</form>
<?php } ?>
	<div id="message">	
		<?php foreach ($message as $message) { ?>		
			<a href=<?= "/users/profile/{$message['from_user']}" ?> > <?php echo $message['first_name'] . ' ' . $message['last_name'] ; ?></a> wrote
			<p><?= date('M jS Y' ,strtotime($message['created_at']));?></p>
			<h4>
				<?php if ($user['user_id'] == $session['user_id'] || $session['user_id'] == $message['from_user']) { ?>
				<a class="btn btn-danger" href= <?= "/messages/delete_message/{$message['id']}/{$user['user_id']}" ?> onclick="javascript: return confirm('Are you sure you want permanently remove message and all associated comments?');">X</a>
				<?php } echo "  " . $message['message']; ?>
			</h4>
			<?php foreach ($comment as $comment) { 
				if ($comment['message_id'] ===  $message['id']){ ?>
					<div class="comments">
						<a href=<?= "/users/profile/{$comment['user_id']}/{$user['user_id']}" ?> > <?php echo $comment['first_name'] . ' ' . $comment['last_name'] ; ?></a> wrote
						<p><?= date('M jS Y' ,strtotime($comment['created_at']));?></p>
						<h5>
							<?php if ($user['user_id'] == $session['user_id'] || $session['user_id'] == $comment['user_id']) { ?>
							<a class="btn btn-danger" onclick="javascript: return confirm('Are you sure you want permanently remove comment?');" href=  <?= "/messages/delete_comment/{$comment['id']}/{$user['user_id']}" ?>>X</a>
							<?php  } echo '  ' . $comment['comment']; ?>
						</h5>
					</div>
			<?php	}
			} ?>
			<form action=<?= "/messages/comment/{$user['user_id']}/{$message['id']}" ?> method="post">
				<textarea id="comment" name="comment" placeholder = "Write a comment..."></textarea>
				<input class="btn-primary btn-sm" type="submit" value="post">
			</form>
		<?php } ?>
	</div>
</div>
<?php $this->load->view('partials/footer') ?>