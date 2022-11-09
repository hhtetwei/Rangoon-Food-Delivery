<?php  
session_start(); //Session Declare
include('connection.php');
include('Shopping_Cart_Functions.php');
include('AutoID_Functions.php');

$OrderID=$_GET['OrderID'];
$CustomerID=$_SESSION['CustomerID'];

//Single Group------------------------------------------------------------
$query1="SELECT ord.*, c.CustomerID,c.CustomerName
		FROM orders ord,customer c
		WHERE ord.CustomerID='$CustomerID'
		AND ord.CustomerID=c.CustomerID
		AND ord.OrderID='$OrderID'
		";
$result1=mysqli_query($connection,$query1);
$row1=mysqli_fetch_array($result1);
//Repeat Group------------------------------------------------------------
$query2="SELECT ord.*, ordd.*, m.MenuID,m.MenuName
		FROM orders ord,orderdetails ordd,menu m
		WHERE ord.OrderID=ordd.OrderID
		AND ordd.MenuID=m.MenuID
		AND ordd.OrderID='$OrderID'
		";
$result2=mysqli_query($connection,$query2);
$count=mysqli_num_rows($result2);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer Order Details :</title>
</head>
<body>
<form action="Order_Details.php" method="post">
<fieldset>
<legend>Order Details for : <?php echo $OrderID ?></legend>

<table align="center" border="1" cellpadding="5px" cellspacing="5px">
<tr>
	<td>OrderID</td>
	<td>
		: <b><?php echo $row1['OrderID']  ?></b>
	</td>
<tr>
	<td>Order Date</td>
	<td>
		: <b><?php echo $row1['OrderDate']  ?></b>
	</td>
	<td>Report Date</td>
	<td>
		: <b><?php echo date('Y-M-d')  ?></b>
	</td>
</tr>
<tr>
	<td>Customer Name</td>
	<td>
		: <b><?php echo $row1['CustomerName']  ?></b>
	</td>
	<td>Deliver Address</td>
	<td>
		: <b><?php echo $row1['DeliveryAddress'] . ' | ' . $row1['DeliveryPhone']  ?></b>
	</td>
</tr>
<tr>
	<td colspan="4">
	<table border="1" width="100%">
	<tr>
		<th>#</th>
		<th>MenuID</th>
		<th>MenuName</th>
		<th>Price</th>
		<th>Quantity</th>
		<th>Sub-Total</th>
	</tr>
	<?php  
	for($i=0;$i<$count;$i++) 
	{ 
		$row2=mysqli_fetch_array($result2);

		echo "<tr>";	
		echo "<td>" . ($i+1) . "</td>";
		echo "<td>" . $row2['MenuID'] . "</td>";
		echo "<td>" . $row2['MenuName'] . "</td>";
		echo "<td>" . $row2['Price'] . "</td>";
		echo "<td>" . $row2['Quantity'] . "</td>";
		echo "<td>" . $row2['Price'] * $row2['Quantity'] . "</td>";
		echo "</tr>";	
	}
	?>
	</table>
	</td>
</tr>
<tr>
	<td colspan="4" align="right">

	<p>TotalQuantity : <b><?php echo $row1['TotalQuantity'] ?></b> pcs</p>
	<p>TotalAmount : <b><?php echo $row1['TotalAmount'] ?></b> MMK</p>
	<p>VAT(5%) : <b><?php echo $row1['VAT'] ?></b> MMK</p>
	<p>GrandTotal : <b><?php echo $row1['GrandTotal'] ?></b> MMK</p>
	
	</td>
</tr>
<tr>
	<td colspan="4" align="right">
	<!---Print--->
	<script>var pfHeaderImgUrl = '';var pfHeaderTagline = 'Order%20Report';var pfdisableClickToDel = 0;var pfHideImages = 0;var pfImageDisplayStyle = 'right';var pfDisablePDF = 0;var pfDisableEmail = 0;var pfDisablePrint = 0;var pfCustomCSS = '';var pfBtVersion='1';(function(){var js, pf;pf = document.createElement('script');pf.type = 'text/javascript';if('https:' == document.location.protocol){js='https://pf-cdn.printfriendly.com/ssl/main.js'}else{js='http://cdn.printfriendly.com/printfriendly.js'}pf.src=js;document.getElementsByTagName('head')[0].appendChild(pf)})();</script>
	<a href="http://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onClick="window.print();return false;" title="Printer Friendly and PDF"><img style="border:none;-webkit-box-shadow:none;box-shadow:none;" src="http://cdn.printfriendly.com/button-print-grnw20.png" alt="Print Friendly and PDF"/></a>
	<!---Print--->
	</td>
</tr>
</table>

</fieldset>	

</form>
</body>
</html>