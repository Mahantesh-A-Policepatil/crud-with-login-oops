<?php
session_start();
if (!isset($_SESSION) || empty($_SESSION)) {
	header('Location: ../user/login.php');
}
include_once "../../Controllers/ProductController.php";
$obj = new ProductController();

//including the database connection file
//include("../config/connection.php");
//getting id of the data from url
$id = $_GET['id'];
//deleting the row from table
//$result=mysqli_query($mysqli, "DELETE FROM products WHERE id=$id");
$result = $obj->delete($id);
//redirecting to the display page (view.php in our case)
header("Location: view.php");
