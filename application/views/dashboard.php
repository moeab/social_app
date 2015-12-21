<?php $this->load->view("partials/header"); ?>
<?php $session = $this->session->userdata('logged_in'); ?>
<div class="nav">
	<h1>Social App</h1>
	<p>Dashboard</p>
	<a class="btn-info btn-lg" href=<?php echo "/users/profile/" . $session['user_id'];?>>Profile</a>
	<a class="btn-info btn-lg" href="/users/log_off">Log Off</a>
</div>
<div class="hero-unit">
	<?php if ($session['user_level'] == "Admin"){ ?>
	<h1 class= "new_user">Manage Users</h1>
	<a href = "/users/add_new" class="btn-info btn-lg new_user">Add New</a>
	<?php  } else { ?>
	<h1>All Users</h1>
	<?php } ?>
	<table class="table-bordered table-striped">
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Created at</th>
		<th>User Level</th>
		<?php if ($session['user_level'] == "Admin"){ ?>
		<th>Actions</th>
		<?php  } ?>
		<?php foreach ($list as $value) { ?>
		<tr>
			<td>
				<?= $value['id'] ?>
			</td>
			<td>
				<a href= <?php echo "/users/profile/" . $value['id'] ?> >
				<?php echo $value['first_name'] . ' ' . $value['last_name']; ?>
				</a>
			</td>
			<td>
				<?= $value['email']; ?>
			</td>
			<td>
				<?= date('F jS Y', strtotime($value['created_at']));?>
			</td>
			<td>
				<?= $value['user_level'] ?>
			</td>
			<?php if ($session['user_level'] == "Admin"){ ?>
				<td>
					<a href= <?php echo "/users/edit/" . $value['id']; ?> >Edit</a> |
					<a onClick="javascript: return confirm('Are you sure you want permanently remove user?');" href=<?php echo "/users/delete/" . $value['id']; ?>>Remove</a>
				</td>
			<?php } ?>
		</tr>
		<?php } ?>
	</table>
</div>
<div class="success">
<?php 
	if ($this->session->flashdata('success')) {
		echo $this->session->flashdata('success');
	}
?>
</div>

<?php $this->load->view("partials/footer"); ?>