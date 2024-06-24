<!doctype html>
<?php
include_once '../layout/header.php';
include_once "../../Controllers/UserController.php";
$obj = new UserController();
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
  <title>Signin Template for Bootstrap</title>
  <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">
</head>

<body>
  <?php

  if (isset($_POST['submit'])) {
    $response = $obj->validate($_POST);
    if ($response["error_code"] == 401) {
      echo $response["message"];
      echo "<br/>";
      echo "<a href='login.php'>Go back</a>";
    } else {
      print_r($_POST['username']);
      $row = $obj->authenticate($_POST['username'], md5($_POST['password']));
      //print_r($row);  exit;     
      // $row = mysqli_fetch_assoc($result);

      if (is_array($row) && !empty($row)) {
        session_start();
        $validuser = $row['user_name'];
        $_SESSION['valid'] = $validuser;
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        //print_r($_SESSION); exit;
      } else {
        unset($_SESSION);
        echo "Invalid username or password.";
        echo "<br/>";
        echo "<a href='login.php'>Go back</a>";
      }

      if (isset($_SESSION['valid'])) {
        header('Location: ../product/view.php');
      }
    }
  } else {

  ?>
    <h1 class="text-center text-info" style="margin-top:120px;">Login</h1>
    <div class="container" style="border: 4px solid black; padding:20px;">
      <form id="login-form" name="form1" class="form" action="" method="post">

        <div class="form-group">
          <label for="username" class="text-info">User Name:</label>
          <input type="text" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
          <label for="password" class="text-info">Password:</label>
          <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">

        </div>
      </form>
    </div>
    <span class="text-center text-info" style="color:black; margin-left:700px; margin-top:50px">Not Registered..?
      <a href="register.php">Register</a>
    </span>
  <?php
  }
  include '../layout/footer.php'
  ?>
</body>

<script>
// just for the demos, avoids form submit
// jQuery.validator.setDefaults({
//   debug: true,
//   success: "valid"
// });

$( "#login-form").validate({
  rules: {
    username: {
      required: true
    },
    password: {
      required: true
    }
  },
  messages: {
    username: "Please enter Uer Name",
    password: "Please enter Password"
    
  }
});
</script>

</html>