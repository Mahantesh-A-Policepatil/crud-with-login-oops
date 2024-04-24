<?php
session_start();
if (!isset($_SESSION) || empty($_SESSION)) {
	header('Location: ../user/login.php');
}
include_once '../layout/header.php';
include_once "../../Controllers/ProductController.php";
$obj = new ProductController();

if (isset($_POST['update'])) {
	$id = $_POST['id'];

	$name = $_POST['name'];
	$quantity = $_POST['quantity'];
	$price = $_POST['price'];

	// checking empty fields
	if (empty($name) || empty($quantity) || empty($price)) {

		if (empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}

		if (empty($quantity)) {
			echo "<font color='red'>Quantity field is empty.</font><br/>";
		}

		if (empty($price)) {
			echo "<font color='red'>Price field is empty.</font><br/>";
		}
	} else {
		//updating the table
		// $result = mysqli_query($mysqli, "UPDATE products SET name='$name', quantity='$quantity', price='$price' WHERE id=$id");

		$obj->update($id, $name, $quantity, $price);

		//redirectig to the display page. In our case, it is view.php
		header("Location: ../product/view.php");
	}
}

//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
//$result = mysqli_query($mysqli, "SELECT * FROM products WHERE id=$id");
$result = $obj->edit($id);
$name = '';
$quantity = '';
$price = '';
$name = $result['name'];
$quantity = $result['quantity'];
$price = $result['price'];

?>
<html>

<head>
	<title>Edit Data</title>
</head>

<body>

	<div class="container" style="margin-top:100px;">
		<form name="form1" method="post" action="../product/edit.php" class="form">
			<h1 class="text-center text-info">Update Product</h1>
			<div class="form-group">
				<label for="name" class="text-info">Product Name:</label>
				<input type="text" name="name" value="<?php echo $name; ?>" class="form-control" required>
				<input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
			</div>
			<div class="form-group">
				<label for="quantity" class="text-info">Quantity:</label>
				<input type="text" name="quantity" value="<?php echo $quantity; ?>" class="form-control" required>
			</div>
			<div class="form-group">
				<label for="price" class="text-info">Proce:</label>
				<input type="text" name="price" value="<?php echo $price; ?>" class="form-control" required>
			</div>
			<div class="form-group">
				<input type="submit" name="update" class="btn btn-info btn-md" value="Update">
			</div>
		</form>

	</div>
	<?php
	include '../layout/footer.php'
	?>
</body>

</html>