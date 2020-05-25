<html>
<?php
	require_once('auth.php');
?>
<head>
<title>
POS
</title>
 <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">

  <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">


<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />

<!-- tcal is a datepicker
there is an <input type="date"> form element, but youcan't enforce the format, it is dependent on browser settings
so an imported javascript code is a good compromise, I guess
-->

<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script>
<script language="javascript">
function Clickheretoprint()
{
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";
      disp_setting+="scrollbars=yes,width=700, height=400, left=100, top=25";
  var content_vlue = document.getElementById("content").innerHTML;

  var docprint=window.open("","",disp_setting);
   docprint.document.open();
   docprint.document.write('</head><body onLoad="self.print()" style="width: 700px; font-size:11px; font-family:arial; font-weight:normal;">');
   docprint.document.write(content_vlue);
   docprint.document.close();
   docprint.focus();
}
</script>


</head>
<?php
function createRandomPassword() {
	$chars = "003232303232023232023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 7) {

		$num = rand() % 33;

		$tmp = substr($chars, $num, 1);

		$pass = $pass . $tmp;

		$i++;

	}
	return $pass;
}
$finalcode='RS-'.createRandomPassword();
?>
<body>
<?php include('navfixed.php');?>
<div class="container-fluid">
      <div class="row-fluid">
	<div class="span2">
          <div class="well sidebar-nav">
              <ul class="nav nav-list">
              <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Главное меню </a></li>
			<li><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Продажи</a></li>
			<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Позиции</a></li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Ингредиенты</a></li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Закупки</a></li>
			<li class="active"><a href="salesreport.php?d1=0&d2=0"><i class="icon-bar-chart icon-2x"></i> Статистика</a></li>

					<br><br><br><br><br><br>
			<li>
			 <div class="hero-unit-clock">

			<form name="clock">
			<font color="white">Время: <br></font>&nbsp;<input style="width:150px;" type="submit" class="trans" name="face" value="">
			</form>
			  </div>
			</li>

				</ul>
          </div><!--/.well -->
        </div><!--/span-->
	<div class="span10">
	<div class="contentheader">
			<i class="icon-bar-chart"></i> Статистика
			</div>
			<ul class="breadcrumb">
			<li><a href="index.php">Главное меню</a></li> /
			<li class="active">Статистика</li>
			</ul>

<div style="margin-top: -19px; margin-bottom: 21px;">
<a  href="index.php"><button class="btn btn-default btn-large" style="float: none;"><i class="icon icon-circle-arrow-left icon-large"></i> Назад</button></a>
<button  style="float:right;" class="btn btn-success btn-mini"><a href="javascript:Clickheretoprint()"> Печать</button></a>

</div>
<form action="salesreport.php" method="get">
<center><strong>От: <input type="text" style="width: 223px; padding:14px;" name="d1" class="tcal" value="" autocomplete="off" /> До: <input type="text" style="width: 223px; padding:14px;" name="d2" class="tcal" value="" autocomplete="off" />
 <button class="btn btn-info" style="width: 123px; height:35px; margin-top:-8px;margin-left:8px;" type="submit"><i class="icon icon-search icon-large"></i> Искать</button>
</strong></center>
</form>
<div class="content" id="content">
<div style="font-weight:bold; text-align:center;font-size:14px;margin-bottom: 15px;">
Статистика от&nbsp;<?php echo $_GET['d1'] ?>&nbsp;до&nbsp;<?php echo $_GET['d2'] ?>
</div>
<table class="table table-bordered" id="resultTable" data-responsive="table" style="text-align: left;">
	<thead>
		<tr>
			<th width="13%"> № реализации </th>
			<th width="8%"> Дата продажи </th>
			<th width="15%"> Кассир </th>
			<th width="15%"> Код чека </th>
			<th width="13%"> Сумма (бар) </th>
			<th width="13%"> Сумма (кухня) </th>
			<th width="16%"> Общая сумма </th>
		</tr>
	</thead>
	<tbody>

			<?php
				include('../connect.php');
				$d1=$_GET['d1'];
				$d2=$_GET['d2'];
				$result = $db->prepare("SELECT * FROM sales WHERE date BETWEEN :a AND :b ORDER by transaction_id DESC ");
				$result->bindParam(':a', $d1);
				$result->bindParam(':b', $d2);
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
			?>
			<tr class="record">
			<td>№<?php echo $row['transaction_id']; ?></td>
			<td><?php echo $row['date']; ?></td>
			<td><?php echo $row['cashier']; ?></td>
			<td><?php $thisInvoice = $row['invoice_number']; echo $thisInvoice;?></td>
			<td><?php
			//this column has to get the amount of only products that have kitchen = 0 in the products.db

			$barAmountOfThisInvoiceQuery = $db->prepare("SELECT SUM(bar_sale.amount) FROM ( SELECT sold_items.product_name, amount, date, kitchen, invoice FROM sold_items, products WHERE sold_items.product_name = products.product_name AND kitchen = 0) AS bar_sale WHERE invoice = :inv");
			$barAmountOfThisInvoiceQuery->bindParam(':inv', $thisInvoice);
			$barAmountOfThisInvoiceQuery->execute();
			for($i=0; $rows = $barAmountOfThisInvoiceQuery->fetch(); $i++){
				$barAmount=$rows['SUM(bar_sale.amount)'];
				echo formatMoney($barAmount, true);
			}
			?></td>
			<td><?php
			//this column has to get the amount of those products with kitchen = 1
			$kitchenAmountOfThisInvoiceQuery = $db->prepare("SELECT SUM(kitchen_sale.amount) FROM ( SELECT sold_items.product_name, amount, date, kitchen, invoice FROM sold_items, products WHERE sold_items.product_name = products.product_name AND kitchen = 1) AS kitchen_sale WHERE invoice = :inv");
			$kitchenAmountOfThisInvoiceQuery->bindParam(':inv', $thisInvoice);
			$kitchenAmountOfThisInvoiceQuery->execute();
			for($i=0; $rows = $kitchenAmountOfThisInvoiceQuery->fetch(); $i++){
				$kitchenAmount=$rows['SUM(kitchen_sale.amount)'];
				echo formatMoney($kitchenAmount, true);
			}
			?></td>
			<td><?php
				$total=$row['amount'];
				echo formatMoney($total, true);
			?></td>
			</tr>
			<?php
				}
			?>

	</tbody>
	<thead>
		<tr>
			<th colspan="4" style="border-top:1px solid #999999"> Всего: </th>
			<!--Bar total amount -->
			<th colspan="1" style="border-top:1px solid #999999">
			<?php
				function formatMoney($number, $fractional=false) {
					if ($fractional) {
						$number = sprintf('%.2f', $number);
					}
					while (true) {
						$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
						if ($replaced != $number) {
							$number = $replaced;
						} else {
							break;
						}
					}
					return $number;
				}

				/*bar total amount*/

				$d1=$_GET['d1'];
				$d2=$_GET['d2'];
				$barTotalQuery = $db->prepare("SELECT SUM(t1.amount) FROM (SELECT sold_items.product_name, amount, date, kitchen FROM sold_items, products WHERE sold_items.product_name = products.product_name AND kitchen = 0 ) AS t1 WHERE t1.date BETWEEN :a AND :b");
				$barTotalQuery->bindParam(':a', $d1);
				$barTotalQuery->bindParam(':b', $d2);
				$barTotalQuery->execute();
				for($i=0; $rows = $barTotalQuery->fetch(); $i++){
				$barTotal=$rows['SUM(t1.amount)'];
				echo formatMoney($barTotal, true);
			}
				?>
			</th>

			<th colspan="1" style="border-top:1px solid #999999">
			<?php

				/*kitchen total amount*/

				$d1=$_GET['d1'];
				$d2=$_GET['d2'];
				$kitchenTotalQuery = $db->prepare("SELECT SUM(t2.amount) FROM (SELECT sold_items.product_name, amount, date, kitchen FROM sold_items, products WHERE sold_items.product_name = products.product_name AND kitchen = 1 ) AS t2 WHERE t2.date BETWEEN :a AND :b");
				$kitchenTotalQuery->bindParam(':a', $d1);
				$kitchenTotalQuery->bindParam(':b', $d2);
				$kitchenTotalQuery->execute();
				for($i=0; $rows = $kitchenTotalQuery->fetch(); $i++){
				$kitchenTotal=$rows['SUM(t2.amount)'];
				echo formatMoney($kitchenTotal, true);
			}
				?>
			</th>

			<!--Bar + kitchen total amount -->

			<th colspan="1" style="border-top:1px solid #999999">
			<?php
				$salesOverPeriod = $db->prepare("SELECT sum(amount) FROM sales WHERE date BETWEEN :c AND :d");
				$salesOverPeriod->bindParam(':c', $d1);
				$salesOverPeriod->bindParam(':d', $d2);
				$salesOverPeriod->execute();
				for($i=0; $salesRow = $salesOverPeriod->fetch(); $i++){
				$totalAmount=$salesRow['sum(amount)'];
				echo formatMoney($totalAmount, true);
			}
				?>

				</th>
		</tr>
	</thead>
</table>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>

</body>
<script src="js/jquery.js"></script>
  <script type="text/javascript">
$(function() {


$(".delbutton").click(function(){

//Save the link in a variable called element
var element = $(this);

//Find the id of the link that was clicked
var del_id = element.attr("id");

//Built a url to send
var info = 'id=' + del_id;
 if(confirm("Sure you want to delete this update? There is NO undo!"))
		  {

 $.ajax({
   type: "GET",
   url: "deletesales.php",
   data: info,
   success: function(){

   }
 });
         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");

 }

return false;

});

});
</script>
<?php include('footer.php');?>
</html>
