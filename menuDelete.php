<?php  
session_start();
include('connection.php');

$MenuID=$_GET['MenuID'];

$delete="DELETE FROM menu WHERE MenuID='$MenuID'";
$result=mysqli_query($connection,$delete);

if($result) {
	echo "<script>window.alert('Menu Successfully Deleted!')</script>";
	echo "<script>window.location='Menu.php'</script>";
} else {
	echo "<p>Something went wrong in Menu Delete" . mysqli_error($connection) . "</p>";
}
?>