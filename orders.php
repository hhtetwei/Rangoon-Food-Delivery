<?php
session_start();
include('connection.php');

if (!isset($_SESSION['Staff_ID'])) {
	echo "<script>alert('Please login to continue')
		window.location='Staff_Login.php'
		</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Orders</title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css" />
	<style>
		table td, table th {
			text-align: center;
		}
	</style>
</head>

<body>
	<?php
	include('header.php');
	?>

	<div class="container-fluid">
		<p class="display-4">Orders</p>
		<div class="p-3">
			<table id="table" style="width:100%">
				<thead>
					<tr>
						<th>#</th>
						<th>OrderID</th>
						<th>OrderDate</th>
						<th>Quantity</th>
						<th>Amount</th>
						<th>CustomerID</th>
						<th>Address</th>
						<th>Phone</th>
						<th>Payment Type</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = "SELECT * FROM orders";
					$result = mysqli_query($connection, $query);
					$size = mysqli_num_rows($result);

					for ($i = 0; $i < $size; $i++) {
						$rows = mysqli_fetch_array($result);
						$OrderID = $rows['OrderID'];

						echo "<tr>";
						echo "<td>" . ($i + 1) . "</td>";
						echo "<td>" . $rows['OrderID'] . "</td>";
						echo "<td>" . $rows['OrderDate'] . "</td>";
						echo "<td>" . $rows['TotalQuantity'] . "</td>";
						echo "<td>" . $rows['TotalAmount'] . "</td>";
						echo "<td>" . $rows['CustomerID'] . "</td>";
						echo "<td>" . $rows['DeliveryAddress'] . "</td>";
						echo "<td>" . $rows['DeliveryPhone'] . "</td>";
						echo "<td>" . $rows['PaymentType'] . "</td>";
						echo "<td>" . $rows['Status'] . "</td>";
						echo "<td>
						<a class='btn btn-success btn-sm' href='orderComplete.php?OrderID=$OrderID'>Complete</a>
						<a class='btn btn-info btn-sm' href='orderDetail.php?OrderID=$OrderID'>Details</a>
						</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#table').DataTable();
		});
	</script>

	<?php
	include('footer.php');
	?>
</body>

</html>