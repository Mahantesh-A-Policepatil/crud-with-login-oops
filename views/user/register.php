<?php 
	include '../layout/header.php'
?>

<html>
<head>
	<title>Add Data</title>
</head>

<body>
<?php
	//including the database connection file
	include_once "../../Controllers/UserController.php";
	$obj = new UserController();

	if(isset($_POST['submit'])) {	
		$name = $_POST['name'];
		$email = $_POST['email'];
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
			
		// checking empty fields
		if(empty($name) || empty($email) || empty($user_name)|| empty($password)|| empty($confirm_password)) {
					
			if(empty($name)) {
				echo "<font color='red'>Name field is empty.</font><br/>";
			}
			
			if(empty($email)) {
				echo "<font color='red'>Email field is empty.</font><br/>";
			}
			
			if(empty($user_name)) {
				echo "<font color='red'>User Name field is empty.</font><br/>";
			}

			if(empty($password)) {
				echo "<font color='red'>Password field is empty.</font><br/>";
			}

			if(empty($confirm_password)) {
				echo "<font color='red'>Confirm Password field is empty.</font><br/>";
			}

			if($password !== $confirm_password) {
				echo "<font color='red'>Password and Confirm Password are not same</font><br/>";
			}
			

			//link to the previous page
			echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
		} else { 
			// if all the fields are filled (not empty) 
				
			//insert data to database	
			mysqli_query($mysqli, "INSERT INTO users(name, email, user_name, password) VALUES('$name', '$email', '$user_name', md5('$password'))")
			or die("Could not execute the insert query.");
			
			//display success message
			header('Location: ../user/login.php');
		}
	}
?>

<div class="container" style="margin-top:60px;">
	<a href="../login/login.php" class="btn btn-primary">Login</a>	
	<form id="regiserForm" name="regiserForm" method="post" action="../login/register.php" class="form">
        <h1 class="text-center text-info">Register</h1>
        <div class="form-group">
            <label for="username" class="text-info">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email" class="text-info">E-Mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="user_name" class="text-info">User Name:</label>
            <input type="text" name="user_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password" class="text-info">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
         <div class="form-group">
            <label for="confirm_password" class="text-info">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-info btn-md" value="Add">
        </div>       
    </form>
</div>
<?php
  include '../layout/footer.php'
?>
<script type="text/javascript">
	$(document).ready(function() { 
		jQuery('#regiserForm').validate({
		    rules: {
		        password: {
		        	required: true,
		            minlength: 5,
		        },
		        confirm_password: {
		        	required: true,
		            minlength: 5,
		            equalTo: "#password"
		        }
		    }
		});
	});  
</script>
</body>
</html>
