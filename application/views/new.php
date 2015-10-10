<?php $this->load->view('partials/header') ?>
<div class="nav">
	<h1>Test App</h1>
	<p>Add User</p>
	<a class="btn-info btn-lg" href="">profile</a>
	<a class="btn-info btn-lg" href="/users/log_off">Log off</a>
</div>
<div class="form">
	<h2 id="new-usr">Add a new user</h2>
	<form action="/users/register_process" method="post">
		<label for="email">Email Address</label>
		<input type="text" name="email">
		<label for="first_name">First Name</label>
		<input type="text" name="first_name">
		<label for="last_name">Last Name</label>
		<input type="text" name="last_name">
		<label for="password">Password</label>
		<input type="password" name="password">
		<label for="password_conf">Password Confirmation</label>
		<input type="Password" name="password_conf">
		<input type="hidden" name="admin_register" value="TRUE">
		<input class="btn-success" type="submit" value="Register">
	</form>
</div>
<div class="errors">
	<?php
		if ($this->session->flashdata('errors')){
			echo $this->session->flashdata('errors');
		}
	?>
</div>
<a id="dashboard_btn" class="btn-primary btn-sm" href="/users/dashboard">Return to Dashboard</a>
<?php $this->load->view('partials/footer') ?>