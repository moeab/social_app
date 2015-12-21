<?php $this->load->view('/partials/header'); ?>
<div class="nav">
	<h1>Social App</h1>
	<p>Edit Profile</p>
	<a href = "/users/dashboard" class="btn-info btn-lg" href="">Dashboard</a>
	<a href= "/users/log_off"class="btn-info btn-lg" href="">Log off</a>
</div>
<div class="header">
	<?php
		$session = $this->session->userdata('logged_in');
		if ($session['user_level'] == "Admin" && $user['user_id'] != $session['user_id']){ 
	?>
	<h1>Edit user #<?php echo $user['user_id']; ?></h1>
	<?php 	
		} else { 
	?>
	<h1>Edit your profile</h1>
	<?php } ?>
</div>
<div id="user_form" class="edit_form">
	<h3>Edit information</h3>
	<form method="post" action=<?= "/users/update/{$user['user_id']}" ?>>
		<label for="email">Email Address</label>
		<input type="text" name="email" value=<?= $user['email'] ?>>
		<label for="first_name">First Name</label>
		<input type="text" name="first_name" value=<?= $user['first_name'] ?>>
		<label for="last_name">Last Name</label>
		<input type="text" name="last_name" value=<?= $user['last_name'] ?>>
		<?php
			if ($session['user_level'] == "Admin" && $user['user_id'] != $session['user_id']){ 
		?>
		<label for="user_level">User Level</label>
		<select name="user_level">
			<option value="Admin">Admin</option>
			<option value="Normal" selected>Normal</option>
		</select>
		<?php } ?>
		<input class='btn-primary btn-sm' type="submit" value="Save">
		<input type="hidden" name="user_edit" value="TRUE">
	</form>
</div>
<div class="errors">
	<?php
		if ($this->session->flashdata('errors')){
			echo $this->session->flashdata('errors');
		}
	?>
</div>
<div class="edit_form">
	<h3>Change Password</h3>
	<form method="post" action= <?= "/users/update/{$user['user_id']}" ?>>
		<label for="current_password">Current Password</label>
		<input type="password" name="current_password">
		<label for="new_password">New Password</label>
		<input type="password" name="new_password">
		<label for="password-conf">Password Confiramtion</label>
		<input type="password" name="password_conf">
		<input class='btn-primary btn-sm' type="submit" value="Update Password">
		<input type="hidden" name="password_edit" value="TRUE">
	</form>
</div>
<?php if ($user['user_id'] == $session['user_id']){ ?>
	<div id="description">
		<form method="post" action=<?= "/users/update/{$user['user_id']}"?>>
			<label for="description">Edit/Add Description (Optional)</label>
			<textarea name="description" value<?= $user['description']?>><?= $user['description']?></textarea>
			<input class="btn-primary btn-sm" type="submit" value="Save">
			<input type="hidden" name="description_edit" value="TRUE">
		</form>
	</div>
<?php } 
$this->load->view('/partials/footer'); ?>