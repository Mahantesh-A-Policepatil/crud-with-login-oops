<?php
session_start();
if (!isset($_SESSION) || empty($_SESSION)) {
	header('Location: ../user/login.php');
}
include_once '../layout/header.php';
include_once "../../Controllers/ProductController.php";
?>

<?php

if (isset($_POST['submit'])) {
	ini_set('max_execution_time', '0');
	ini_set('upload_max_filesize', 1000);
	ini_set('post_max_size', 1000);
	ini_set('memory_limit', '10000M');

	echo "Hello1";
	$tmpName = $_FILES['file']['tmp_name'];
	echo "Hello2";
	$csv_data = array_map('str_getcsv', file($tmpName));
	echo "Hello3";
	array_walk($csv_data , function(&$x) use ($csv_data) {
	  $x = array_combine($csv_data[0], $x);
	});
	echo "Hello4";
	/** 
	*
	* array_shift = remove first value of array 
	* in csv file header was the first value
	* 
	*/
	array_shift($csv_data);
	echo "Hello5";

	// Print Result Data
	echo '<pre/>';
	print_r($csv_data);    
}
?>
<html>

<head>
	<title>Add Data</title>
</head>

<body>
	<div class="container" style="margin-top:100px;">
		<!-- <form id="create-product-form" name="form1" method="post" action="add.php" class="form">
			<h1 class="text-center text-info">Add Product</h1>
			<div class="form-group">
				<label for="name" class="text-info">Product Name:</label>
				<input type="text" name="name" id="name" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="quantity" class="text-info">Quantity:</label>
				<input type="text" name="quantity" id="quantity" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="price" class="text-info">Price:</label>
				<input type="text" name="price" id="price" class="form-control" required>
			</div>
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-info btn-md" value="Add">
			</div>
		</form> -->
		<div class="card-body">
				<form action="import.php" method="POST" enctype="multipart/form-data">
					
					<input type="file" name="file" accept=".csv">
					<br><br>
					<button type="submit" name="submit">Import CSV</button>
				</form>
			</div>
		</div>

	</div>
	<?php
	include '../layout/footer.php'
	?>
</body>


</html>