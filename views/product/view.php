<?php
session_start();
if (!isset($_SESSION) || empty($_SESSION)) {
	header('Location: ../user/login.php');
}

include_once "../../Controllers/ProductController.php";
$obj = new ProductController();
$result = $obj->index($_SESSION['id']);
?>

<html>

<head>
	<title>Homepage</title>
</head>

<body>
	<?php
	include '../layout/header.php'
	?>
	<div class="container" style="margin-top:100px;">
		<a href="add.php" class="btn btn-primary">Add New Product</a>
		<table width='80%' border=0 class="table table-dark">
			<tr bgcolor='#CCCCCC'>
				<td>Name</td>
				<td>Quantity</td>
				<td>Price (Rs)</td>
				<td>Actions</td>
			</tr>
			<?php
			if (!empty($result)) {
				foreach ($result as $row) {
					//print_r($row); exit;	
					echo "<tr>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['quantity'] . "</td>";
					echo "<td>" . "&#x20B9; " . $row['price'] . "</td>";
					echo "<td><a href=\"edit.php?id=$row[id]\" class='btn btn-success'>Edit</a>  
					<a href=\"delete.php?id=$row[id]\" class='btn btn-danger' onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
				}
			}
			?>
		</table>
	</div>
	<?php
	include '../layout/footer.php';
	//}
	?>
</body>

</html>