<?php  
session_start();
include('connection.php');

$OrderID=$_GET['OrderID'];

$update="UPDATE orders SET Status='Complete' WHERE OrderID='$OrderID'";
$result=mysqli_query($connection,$update);

if($result) {
	echo "<script>window.alert('Order Successfully Completed!')</script>";
	echo "<script>window.location='orders.php'</script>";
} else {
	echo "<p>Something went wrong in Order Completion" . mysqli_error($connection) . "</p>";
}
?>