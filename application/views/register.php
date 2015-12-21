<?php $this->load->view('partials/header') ?>
<div class="nav">
	<h1>Social App</h1>
	<p>Registration</p>
	<a class="btn-info btn-lg" href="/">Home</a>
	<a class="btn-info btn-lg" href="/users/sign_in">Sign In</a>
</div>
<div class="form">
	<h2>Register</h2>
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
		<input type="hidden" name="register" value="TRUE">
		<input class="btn-success" type="submit" value="Register">
	</form>
	<a href="/users/sign_in">Already have an account? Sign In</a>
</div>
<div class="errors">
	<?php
		if ($this->session->flashdata('errors')){
			echo $this->session->flashdata('errors');
		}
	?>
</div>
<?php $this->load->view('partials/footer') ?>