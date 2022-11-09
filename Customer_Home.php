<?php  
session_start(); //Session Declare

?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer Home</title>
</head>
<body>
<form action="#" method="post">

<h3>Welcome  <?php echo $_SESSION['CustomerName'] ?></h3>	

</form>
</body>
</html>