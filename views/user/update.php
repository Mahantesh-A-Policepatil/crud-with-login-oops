<?php
session_start();
if (!isset($_SESSION) || empty($_SESSION)) {
	header('Location: ../user/login.php');
}

// including the database connection file
include_once "../../Controllers/UserController.php";
$obj = new UserController();

if (isset($_POST['update_user'])) {
	$id = $_POST['id'];

	$name = $_POST['name'];
	$email = $_POST['email'];
	$user_name = $_POST['user_name'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	// checking empty fields
	if (empty($name) || empty($email) || empty($user_name) || empty($password) || empty($confirm_password)) {

		if (empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}

		if (empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}

		if (empty($user_name)) {
			echo "<font color='red'>User Name field is empty.</font><br/>";
		}

		// if(empty($password)) {
		// 	echo "<font color='red'>Password field is empty.</font><br/>";
		// }

		if ($password != "" && empty($confirm_password)) {
			echo "<font color='red'>Confirm Password field is empty.</font><br/>";
		}

		if ($password !== $confirm_password) {
			echo "<font color='red'>Password and Confirm Password are not same</font><br/>";
		}


		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else {
		//updating the table
		// $result = mysqli_query($mysqli, "UPDATE users SET name='$name', email='$email', user_name='$user_name' , password=md5('$password') WHERE id=$id");
		$obj->update($name, $email, $user_name, md5($password), $id);

		//redirectig to the display page. In our case, it is view.php
		header("Location: ../product/view.php");
	}
}

//getting id from url
$id = $_SESSION['id'];

//selecting data associated with this particular id
//$result = mysqli_query($mysqli, "SELECT * FROM users WHERE id=$id");
$result =  $obj->show($id);

$name = $result['name'];
$email = $result['email'];
$user_name = $result['user_name'];

?>
<html>

<head>
	<title>Edit Data</title>
</head>

<body>
	<?php
	include '../layout/header.php'
	?>
	<div class="container" style="margin-top:60px;">
		<form id="updateUserProfile" name="updateUserProfile" method="post" action="../user/update.php" class="form">
			<h1 class="text-center text-info">Update User Profile</h1>

			<div class="form-group">
				<label for="username" class="text-info">Name:</label>
				<input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
				<input type="hidden" name="id" value=<?php echo $_SESSION['id']; ?>>
			</div>
			<div class="form-group">
				<label for="email" class="text-info">E-Mail:</label>
				<input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
			</div>
			<div class="form-group">
				<label for="user_name" class="text-info">User Name:</label>
				<input type="text" name="user_name" class="form-control" value="<?php echo $user_name; ?>" required>
			</div>
			<div class="form-group">
				<label for="password" class="text-info">Password:</label>
				<input type="password" id="password" name="password" class="form-control">
			</div>
			<div class="form-group">
				<label for="confirm_password" class="text-info">Confirm Password:</label>
				<input type="password" id="confirm_password" name="confirm_password" class="form-control">
			</div>
			<div class="form-group">
				<input type="submit" name="update_user" class="btn btn-info btn-md" value="Update">
			</div>
		</form>

	</div>
	<?php
	include '../layout/footer.php'
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			jQuery('#updateUserProfile').validate({
				rules: {
					password: {
						required: false,
						minlength: 5,
					},
					confirm_password: {
						required: function(element) {
							return $("#password").val() != '';
						},
						minlength: 5,
						equalTo: "#password"
					}
				}
			});
		});
	</script>
</body>

</html>