<?php
session_start();
include('connection.php');

if (!isset($_SESSION['CustomerID'])) {
	echo "<script>alert('Please login to continue')
		window.location='Customer_Login.php'
		</script>";
}

include('Shopping_Cart_Functions.php');

if (isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];

	if ($action === "buy") {
		$MenuID = $_REQUEST['MenuID'];
		$Quantity = $_REQUEST['txtBuyQuantity'];
		AddtoCart($MenuID, $Quantity);
	} else if ($action === "remove") {
		$MenuID = $_REQUEST['MenuID'];
		RemoveMenu($MenuID);
	} else {
		ClearAll();
	}
} else {
	$action = "";
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Shopping Cart</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<style>
		thead th {
			font-size: 15px;
			padding: 5px !important;
			height: 30px;
			text-align: center;
		}

		tbody td {
			text-align: center;
		}

		.summary p {
			margin: 3px;
		}
	</style>
</head>

<body>
	<?php
	include('header.php');
	?>
	<div class="container-fluid p-4">
		<form>
			<h3 style="font-weight: 400;" class="mb-4">Shopping Cart</h3>
			<?php
			if (!isset($_SESSION['ShoppingCart_Functions'])) {
				echo "<h3 class='text-center'>Your shopping cart is empty!</h3>";
				echo "<a class='btn btn-primary' href='index.php'>Back to homepage</a>";
			} else {
			?>
				<table class="table">
					<thead class="thead-light">
						<tr>
							<th>MenuID</th>
							<th>MenuName</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Sub-Total</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$size = count($_SESSION['ShoppingCart_Functions']);

						for ($i = 0; $i < $size; $i++) {
							$MenuID = $_SESSION['ShoppingCart_Functions'][$i]['MenuID'];
							$MenuName = $_SESSION['ShoppingCart_Functions'][$i]['MenuName'];
							$Image = $_SESSION['ShoppingCart_Functions'][$i]['Image'];
							$Price = $_SESSION['ShoppingCart_Functions'][$i]['Price'];
							$Quantity = $_SESSION['ShoppingCart_Functions'][$i]['Quantity'];
							$SubTotal = $Price * $Quantity;

							echo "<tr>";
							echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['MenuID'] . "</td>";
							echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['MenuName'] . "</td>";
							echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['Price'] . " MMK</td>";
							echo "<td>" . $_SESSION['ShoppingCart_Functions'][$i]['Quantity'] . " pcs</td>";
							echo "<td>" . $SubTotal . " MMK </td>";
							echo "<td><img src='$Image' class='img-fluid' width='100'/></td>";
							echo "<td><a class='btn btn-danger btn-sm' href='Shopping_Cart.php?action=remove&MenuID=$MenuID'>Remove</a></td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
				<div class="d-flex justify-content-end">
					<div class="summary">
						<p>Total Quantity : <b><?php echo CalculateTotalQuantity() ?> pcs</b></p>
						<p>Total Amount : <b><?php echo CalculateTotalAmount() ?> MMK</b></p>
						<p>Gov Tax (VAT): <b><?php echo CalculateVAT() ?> MMK</b></p>
						<p>Grand Total : <b><?php echo CalculateTotalAmount() + CalculateVAT() ?> MMK</b></p>
					</div>
				</div>
				<hr>
				<div class="d-flex">
					<a href="index.php" class="btn btn-primary mr-auto">Continue Shopping</a>
					<a href="Shopping_Cart.php?action=clearall" class="btn btn-primary mr-2">Clear All</a>
					<a href="Checkout.php" class="btn btn-primary">Checkout Now</a>
				</div>
			<?php
			}
			?>
		</form>
	</div>
	<?php
	include('footer.php');
	?>
</body>

</html>