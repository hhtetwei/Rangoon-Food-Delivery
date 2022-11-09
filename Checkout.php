<?php
session_start();
include('connection.php');
if (!isset($_SESSION['CustomerID'])) {
	echo "<script>alert('Please login to continue')
		window.location='Customer_Login.php'
		</script>";
}
include('AutoID_Functions.php');
include('Shopping_Cart_Functions.php');
$CustomerID = $_SESSION['CustomerID'];
$query = "SELECT * FROM customer WHERE CustomerID='$CustomerID'";
$ret = mysqli_query($connection, $query);
$rows = mysqli_fetch_array($ret);
if (isset($_POST['btnSave'])) {
   $txtDeliveryPhone;
   $txtDeliveryAddress;
   if ($_POST['rdoAddress'] == "SameAddress") {
      $txtDeliveryPhone = $rows['Phone'];
      $txtDeliveryAddress = $rows['Address'];
   } else {
      $txtDeliveryPhone = $_POST['txtPhone'];
      $txtDeliveryAddress = $_POST['txtAddress'];
   }
   $txtInvoiceNo = $_POST['txtInvoiceNo'];
   $txtInvoiceDate = $_POST['txtInvoiceDate'];
   $CustomerID = $_SESSION['CustomerID'];
   $txtDirection = $_POST['txtDirection'];
   $txtTotalQty = $_POST['txtTotalQty'];
   $txtTotalAmount = $_POST['txtTotalAmount'];
   $txtVAT = $_POST['txtVAT'];
   $txtDeliveryCost = $_POST['txtDeliveryCost'];
   $txtGrandTotal = $_POST['txtGrandTotal'];
   $rdoPaymentType = $_POST['rdoPaymentType'];
   $txtCardNo = $_POST['txtCardNo'];
   $Status = "Pending";
   $Insert1 = "INSERT INTO orders (OrderID,OrderDate,CustomerID,DeliveryAddress,DeliveryPhone,TotalQuantity,TotalAmount,VAT,GrandTotal,PaymentType,CardNo,Direction,Status) VALUES ('$txtInvoiceNo','$txtInvoiceDate','$CustomerID','$txtDeliveryAddress','$txtDeliveryPhone','$txtTotalQty','$txtTotalAmount','$txtVAT','$txtGrandTotal','$rdoPaymentType','$txtCardNo','$txtDirection','$Status')";
   $ret = mysqli_query($connection, $Insert1); //----------Save Data into Order Details---------------------------------- $size=count($_SESSION['ShoppingCart_Functions']); for($i=0;$i<$size;$i++)
   if ($ret) {
      $size = count($_SESSION['ShoppingCart_Functions']);
      for ($i = 0; $i < $size; $i++) {
         $MenuID = $_SESSION['ShoppingCart_Functions'][$i]['MenuID'];
         $Price = $_SESSION['ShoppingCart_Functions'][$i]['Price'];
         $Quantity = $_SESSION['ShoppingCart_Functions'][$i]['Quantity'];
         $Insert2 = "INSERT INTO orderdetails(OrderID,MenuID,Price,Quantity)VALUES('$txtInvoiceNo','$MenuID','$Price','$Quantity')";
         $ret = mysqli_query($connection, $Insert2);
      }
   }
   if ($ret) {
      // unset($_SESSION['ShoppingCart_Functions']);
      // echo "<script>window.alert('SUCCESS : Order Successfully Saved.')</script>";
      echo "<script>window.location='summary.php'</script>";
   } else {
      echo "<p>Error : Something went wrong in Order" . mysqli_error($connection) . "</p>";
   }
}
?>
<!DOCTYPE html>

<html>

<head>
   <title>Checkout (Payment)</title>
   <script type="text/javascript">
      function ShowAddress() {
         document.getElementById('OtherAddress').style.display = "block";
         document.getElementById('customer-info').style.display = "none";
      }

      function HideAddress() {
         document.getElementById('OtherAddress').style.display = "none";
         document.getElementById('customer-info').style.display = "block";
      }

      function ShowPayment() {
         document.getElementById('PaymentArea').style.display = "block";
      }

      function HidePayment() {
         document.getElementById('PaymentArea').style.display = "none";
      }

      function GetDeliveryCost() {
         var e = document.getElementById('cboTownship');
         var result = e.options[e.selectedIndex].value;
         document.getElementById('txtDeliveryCost').value = result;
         var TotalAmt = document.getElementById('txtTotalAmount').value;
         var VAT = document.getElementById('txtVAT').value;
         document.getElementById('txtGrandTotal').value = Number(result) + Number(TotalAmt) + Number(VAT);
      }
   </script>
   <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
   <script src="bootstrap/js/bootstrap.min.js"></script>
   <style>
      body {
         padding: 0;
         margin: 0;
      }

      .row {
         margin: 0 !important;
      }

      td:nth-child(3) {
         padding-left: 50px;
      }

      .shopping-cart thead th {
         font-size: 15px;
         padding: 5px !important;
         height: 30px;
         text-align: center;
      }

      .shopping-cart tbody td {
         text-align: center;
      }
   </style>
</head>

<body>
   <?php
   include('header.php');
   ?>
   <form action="Checkout.php" method="post">
      <div class="container-fluid p-4">
         <p class="display-4">Checkout</p>
         <div class="row border border-dark p-3">
            <div class="col" style="border-right: 1px solid black;">
               <div class="customer-detail">
                  <h3 style="font-weight: 400;" class="mb-4">Customer detail</h3>
                  <input type="radio" name="rdoAddress" value="SameAddress" onclick="HideAddress()" checked /> Same address
                  <input class="ml-2" type="radio" name="rdoAddress" value="OtherAddress" onclick="ShowAddress()" /> Other address
                  <hr>
                  <div id="OtherAddress" style="display: none;">
                     <label class="m-0">Phone No</label> 
                     <input type="text" class="form-control mb-2" name="txtPhone" placeholder="+95------------" />
                     <label class="m-0">Address</label> 
                     <textarea class="form-control" name="txtAddress"></textarea>
                  </div>
                  <div id="customer-info">
                     <table cellpadding="5px">
                        <tr>
                           <td>Customer name</td>
                           <td>: <?php echo $rows['CustomerName'] ?></td>
                        </tr>
                        <tr>
                           <td>Email</td>
                           <td>: <?php echo $rows['Email'] ?></td>
                        </tr>
                        <tr>
                           <td>Phone</td>
                           <td>: <?php echo $rows['Phone'] ?></td>
                        </tr>
                        <tr>
                           <td>Address</td>
                           <td>: <?php echo $rows['Address'] ?></td>
                        </tr>
                     </table> 
                  </div>
                  <div>
                     <label>Direction</label>
                     <textarea class="form-control" name="txtDirection" rows="5"></textarea> 
                  </div>
               </div>
            </div>
            <div class="col">
               <div class="checkout-info">
                  <h3 style="font-weight: 400;" class="mb-2">Checkout infomation</h3>
                  <table cellpadding="5px">
                     <tr>
                        <td>Invoice no.</td>
                        <td>
                           <input class="form-control" type="text" name="txtInvoiceNo" value="<?php echo AutoID('Orders', 'OrderID', 'ORD-', 6) ?>" readonly />
                        </td>
                        <td>Invoice date</td>
                        <td>
                           <input class="form-control" type="text" name="txtInvoiceDate" value="<?php echo date('Y-m-d') ?>" readonly />
                        </td>
                     </tr>
                     <tr>
                        <td>Total quantity</td>
                        <td>
                           <input class="form-control" type="text" name="txtTotalQty" value="<?php echo CalculateTotalQuantity() ?>" readonly />
                        </td>
                        <td>Total amount</td>
                        <td>
                           <input class="form-control" type="text" name="txtTotalAmount" id="txtTotalAmount" value="<?php echo CalculateTotalAmount() ?>" readonly />
                        </td>
                     </tr>
                     <tr>
                        <td></td>
                        <td></td> 
                        <td>VAT(5%)</td>
                        <td>
                           <input class="form-control" type="text" name="txtVAT" id="txtVAT" value="<?php echo CalculateVAT() ?>" readonly />
                        </td> 
                     </tr>
                     <tr>
                        <td>Choose township</td>
                        <td>
                           <select class="form-control" name="cboTownship" id="cboTownship" onchange="GetDeliveryCost()">
                              <option>---</option>
                              <?php
                              $Tsp_Query = "SELECT * FROM townships";
                              $Tsp_Ret = mysqli_query($connection, $Tsp_Query);
                              $Tsp_Count = mysqli_num_rows($Tsp_Ret);
                              for ($i = 0; $i < $Tsp_Count; $i++) {
                                 $rows = mysqli_fetch_array($Tsp_Ret);
                                 $TownshipID = $rows['TownshipID'];
                                 $TownshipName = $rows['TownshipName'];
                                 $DeliveryCost = $rows['DeliveryCost'];
                                 echo "<option value='$DeliveryCost'>$TownshipName - $DeliveryCost (MMK)</option>";
                              }
                              ?>
                           </select>
                        </td>
                        <td>Delivery cost</td>
                        <td>
                           <input class="form-control" type="text" name="txtDeliveryCost" id="txtDeliveryCost" value="0" readonly />
                        </td>
                     </tr>
                     <tr>
                        <td></td>
                        <td></td>
                        <td>Grand total</td>
                        <td>
                           <input class="form-control" type="text" name="txtGrandTotal" id="txtGrandTotal" value="0" readonly />
                        </td>
                     </tr>
                  </table>
                  <div>
                     <p>Choose payment type</p>
                     <span>
                        <input type="radio" name="rdoPaymentType" value="COD" checked onclick="HidePayment()" />
                        <img src="image/COD.png" width="35px" height="35px" />
                     </span>
                     <span>
                        <input type="radio" name="rdoPaymentType" value="VISA" onclick="ShowPayment()" />
                        <img src="image/VISA.png" width="50px" height="35px" />
                     </span>
                     <span>
                        <input type="radio" name="rdoPaymentType" value="MPU" onclick="ShowPayment()" />
                        <img src="image/MPU.png" width="50px" height="25px" />
                     </span>
                     <span>
                        <input type="radio" name="rdoPaymentType" value="KBZPAY" />
                        <img src="image/KBZPAY.png" width="35px" height="35px" />
                     </span>
                  </div>
                  <div id="PaymentArea" class="PaymentArea mt-3" style="display: none;">
                     <label>Card no.</label>
                     <input class="form-control" type="text" name="txtCardNo" placeholder="---- ---- ---- ----" />
                     <label>Expires</label>
                     <div class="d-flex">
                        <select class="form-control mr-3" name="cboMonth">
                           <option>Month</option>
                           <option>January</option>
                        </select>
                        <select class="form-control" name="cboYear">
                           <option>Year</option>
                           <option>2020</option>
                        </select>
                     </div>
                  </div>
                  <input class="btn btn-primary d-flex ml-auto mt-3" type="submit" name="btnSave" value="Save" />
               </div>
            </div>
         </div>
         <div class="shopping-cart border border-dark p-3 mt-4">
            <h3 style="font-weight: 400;" class="mb-4">Shopping Cart</h3>
            <table class="table">
               <thead class="thead-light">
                  <tr>
                     <th>Image</th>
                     <th>Product ID</th>
                     <th>Product name</th>
                     <th>Price <small>(MMK)</small></th>
                     <th>Quantity <small>(pcs)</small></th>
                     <th>Sub-Total <small>(MMK)</small></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $size = count($_SESSION['ShoppingCart_Functions']);
                  for ($i = 0; $i < $size; $i++) {
                     $Image = $_SESSION['ShoppingCart_Functions'][$i]['Image'];
                     $MenuID = $_SESSION['ShoppingCart_Functions'][$i]['MenuID'];
                     $MenuName = $_SESSION['ShoppingCart_Functions'][$i]['MenuName'];
                     $Price = $_SESSION['ShoppingCart_Functions'][$i]['Price'];
                     $Quantity = $_SESSION['ShoppingCart_Functions'][$i]['Quantity'];
                     $SubTotal = $Price * $Quantity;
                     echo "<tr>";
                     echo "<td><img src='$Image' class='img-fluid' width='100px' height='100px' /></td>";
                     echo "<td>$MenuID</td>";
                     echo "<td>$MenuName</td>";
                     echo "<td>$Price</td>";
                     echo "<td>$Quantity</td>";
                     echo "<td>$SubTotal</td>";
                     echo "</tr>";
                  }
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </form>
   <?php
   include('footer.php');
   ?>
</body>

</html>