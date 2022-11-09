<?php
session_start();
include('connection.php');

if (!isset($_SESSION['Staff_ID'])) {
	echo "<script>alert('Please login to continue')
		window.location='Staff_Login.php'
		</script>";
}
include('Shopping_Cart_Functions.php');
include('AutoID_Functions.php');

$OrderID = $_GET['OrderID'];

$query1 = "SELECT * FROM orders WHERE OrderID='$OrderID'";
$result1 = mysqli_query($connection, $query1);
$row1 = mysqli_fetch_array($result1);

$CustomerID = $row1['CustomerID'];
$query2 = "SELECT * FROM customer WHERE CustomerID='$CustomerID'";
$result2 = mysqli_query($connection, $query2);
$row2 = mysqli_fetch_array($result2);

$query3 = "SELECT ord.*, ordd.*, m.MenuID,m.MenuName
		FROM orders ord,orderdetails ordd,menu m
		WHERE ord.OrderID=ordd.OrderID
		AND ordd.MenuID=m.MenuID
		AND ordd.OrderID='$OrderID'
		";
$result3 = mysqli_query($connection, $query3);
$count = mysqli_num_rows($result3);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Order Detail</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>
        .item-table > thead > tr> th {
            border: 1px solid black;
        }
        .item-table > tbody > tr> td {
            border: 1px solid black;
        }
        .item-table > thead {
            background-color:#f4511e;
            color: white;
        }
    </style>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div class="container-fluid">
        <p class="display-4">Order detail</p>
        <div class="row">
            <div class="col-6 offset-md-3">
                <div class="p-3">
                    <div class="row">
                        <div class="col-6">
                            <h5>Invoice to</h5>
                            <hr>
                            <table class="table table-borderless w-50 table-sm">
                                <tr>
                                    <td><b>Name</b></td>
                                    <td><?php echo $row2['CustomerName'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>Mobile</b></td>
                                    <td><?php echo $row1['DeliveryPhone'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>Address</b></td>
                                    <td><?php echo $row1['DeliveryAddress'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <h5>Order detail</h5>
                            <hr>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><b>Order ID</b></td>
                                    <td><?php echo $row1['OrderID'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>Order date</b></td>
                                    <td><?php echo $row1['OrderDate'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>Delivery date</b></td>
                                    <td><?php echo date('Y-M-d') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <table class="table item-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Item Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < $count; $i++) {
                                    $row3 = mysqli_fetch_array($result3);

                                    echo "<tr>";
                                    echo "<td>" . $row3['MenuName'] . "</td>";
                                    echo "<td>" . $row3['Quantity'] . "</td>";
                                    echo "<td>" . $row3['Price'] . "</td>";
                                    echo "<td>" . $row3['Price'] * $row3['Quantity'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                                <tr>
                                    <td colspan="3" style="text-align: right;">Sub total</td>
                                    <td><?php echo $row1['TotalAmount'] ?> MMK</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right;">VAT(5%)</td>
                                    <td><?php echo $row1['VAT'] ?> MMK</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right;">Grand total</td>
                                    <td><?php echo $row1['GrandTotal'] ?> MMK</td>
                                </tr>
                            </tbody>

                        </table>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" onclick="window.print()">Print</button>
                            <!-- <script>
                                var pfHeaderImgUrl = '';
                                var pfHeaderTagline = 'Order%20Report';
                                var pfdisableClickToDel = 0;
                                var pfHideImages = 0;
                                var pfImageDisplayStyle = 'right';
                                var pfDisablePDF = 0;
                                var pfDisableEmail = 0;
                                var pfDisablePrint = 0;
                                var pfCustomCSS = '';
                                var pfBtVersion = '1';
                                (function() {
                                    var js, pf;
                                    pf = document.createElement('script');
                                    pf.type = 'text/javascript';
                                    if ('https:' == document.location.protocol) {
                                        js = 'https://pf-cdn.printfriendly.com/ssl/main.js'
                                    } else {
                                        js = 'http://cdn.printfriendly.com/printfriendly.js'
                                    }
                                    pf.src = js;
                                    document.getElementsByTagName('head')[0].appendChild(pf)
                                })();
                            </script>
                            <a href="http://www.printfriendly.com" style="color:#6D9F00;text-decoration:none;" class="printfriendly" onClick="window.print();return false;" title="Printer Friendly and PDF"><img style="border:none;-webkit-box-shadow:none;box-shadow:none;" src="http://cdn.printfriendly.com/button-print-grnw20.png" alt="Print Friendly and PDF" /></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
    ?>
</body>

</html>