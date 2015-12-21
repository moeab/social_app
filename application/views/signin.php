<?php $this->load->view('partials/header') ?>

<div class="nav">
	<h1>Social App</h1>
	<p>Sign In</p>
	<a class="btn-info btn-lg" href="/">Home</a>
</div>
<div class="form">
	<h2>Sign In</h2>
	<form action= "/users/signin_process" method="post">
		<label for="email">Email Address</label>
		<input type="text" name="email">
		<label for="password">Password</label>
		<input type="password" name="password">
		<input class="btn-success" type="submit" value="Sign In">
	</form>
	<a href="/users/register">Don't have an account? Register</a>
</div>
<div class="errors">
	<?php
		if ($this->session->flashdata('errors')){
			echo $this->session->flashdata('errors');
		}	
	?>
</div>

<?php $this->load->view('partials/footer') ?>