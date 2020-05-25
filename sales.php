<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<!-- js -->
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loadingImage : 'src/loading.gif',
      closeImage   : 'src/closelabel.png'
    })
  })
</script>
<title>
POS
</title>
<?php
	require_once('auth.php');
?>

	<link href="vendors/uniform.default.css" rel="stylesheet" media="screen">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link href="css/bootstrap-responsive.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="vendors/chosen.min.css">

	<!-- combosearch box-->

	  <script src="vendors/jquery-1.7.2.min.js"></script>
    <script src="vendors/bootstrap.js"></script>

    <script src="vendors/chosen.jquery.min.js"></script>

<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<!--sa poip up-->

 <script language="javascript" type="text/javascript">
/* Visit http://www.yaldex.com/ for full source code
and get more free JavaScript, CSS and DHTML scripts! */
<!-- Begin
var timerID = null;
var timerRunning = false;
function stopclock (){
if(timerRunning)
clearTimeout(timerID);
timerRunning = false;
}
function showtime () {
var now = new Date();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds()
var timeValue = "" + ((hours >12) ? hours -12 :hours)
if (timeValue == "0") timeValue = 12;
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
timeValue += (hours >= 12) ? " P.M." : " A.M."
document.clock.face.value = timeValue;
timerID = setTimeout("showtime()",1000);
timerRunning = true;
}
function startclock() {
stopclock();
showtime();
}
window.onload=startclock;
// End -->
</SCRIPT>

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
	<?php
$position=$_SESSION['SESS_LAST_NAME'];
if($position) {
?>

<div class="container-fluid">
      <div class="row-fluid">
	<div class="span2">
          <div class="well sidebar-nav">
              <ul class="nav nav-list">
      <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Главное меню </a></li>
      <!--here the system assigns you an id when you click on "sales.php" from the side panel-->
			<li class="active"><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Продажи</a></li>
			<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Позиции</a></li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Ингредиенты</a></li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Закупки</a></li>
			<li><a href="salesreport.php?d1=0&d2=0"><i class="icon-bar-chart icon-2x"></i> Статистика</a></li>
			<br><br><br><br><br><br>
			<li>
			 <div class="hero-unit-clock">

			<form name="clock">
        <font color="white">Время: <br></font>&nbsp;<input style="width:150px;" type="submit" class="trans" name="face" value="">
			</form>
			  </div>
			</li>

				</ul>
<?php } ?>
          </div><!--/.well -->
        </div><!--/span-->
	<div class="span10">
		<div class="contentheader">
			<i class="icon-money"></i> Продажи
			</div>
			<ul class="breadcrumb">
			<a href="index.php"><li>Главное меню</li></a> /
			<li class="active">Продажи</li>
			</ul>
<div style="margin-top: -19px; margin-bottom: 21px;">
<a  href="index.php"><button class="btn btn-default btn-large" style="float: none;"><i class="icon icon-circle-arrow-left icon-large"></i> Назад</button></a>
</div>

<!--the idea behind those invoices: when you enter "sales.php", the system automatically assigns you an invoice id,
which can be used to identify a specific sale-->


<form action="incoming.php" method="post" >

  <input type="hidden" name="pt" value="<?php echo $_GET['id']; ?>" />
  <!--invoice can be used later on to identify specific sale orders by date, cashier etc.-->
  <input type="hidden" name="invoice" value="<?php echo $_GET['invoice']; ?>" />
  <select name="product" style="width:650px;" class="chzn-select" required>
    <!--the description of that class is in "chzn-select" of ..\vendors\chosen.jquery.min.js-->
    <option></option>
	<?php
	  include('../connect.php');
	  $result = $db->prepare("SELECT * FROM products");
		$result->bindParam(':userid', $res);
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
		<option value="<?php echo $row['product_id'];?>">
      <?php echo $row['product_name']; ?> — <?php echo $row['price']; ?> &#x20bd;
    </option>
	<?php
				}
			?>
  </select>

<input type="number" name="qty" value="1" min="1" placeholder="Qty" autocomplete="off" style="width: 68px; height:30px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" / required>
<input type="hidden" name="date" value="<?php echo date("d/m/y"); ?>" />
<Button type="submit" class="btn btn-info" style="width: 123px; height:35px; margin-top:-5px;" /><i class="icon-plus-sign icon-large"></i> Добавить</button>
</form>
<table class="table table-bordered" id="resultTable" data-responsive="table">
	<thead>
		<tr>
			<th> Название </th>
			<th> Категория </th>
			<th> Цена (шт) </th>
			<th> Количество </th>
			<th> Цена (всего) </th>
			<th> Действие </th>
		</tr>
	</thead>
	<tbody>

			<?php
      //unlike fetch() function, the following code adds data into DB
				$id=$_GET['invoice'];
				include('../connect.php');
				$result = $db->prepare("SELECT * FROM sold_items WHERE invoice= :userid");
				$result->bindParam(':userid', $id);
				$result->execute();
				for($i=1; $row = $result->fetch(); $i++){
			?>
			<tr class="record">
      <td hidden><?php echo $row['product']; ?></td>
			<td><?= $row['product_name']; ?></td>
			<td><?= $row['category']; ?></td>
			<td>
			<?php
			$price=$row['price'];
			echo formatMoney($price, true);
			?>
			</td>
			<td><?= $row['qty']; ?></td>
			<td>
			<?php
			$totalAmount=$row['amount'];
			echo formatMoney($totalAmount, true);
			?>
			</td>
			<td width="90"><a href="delete.php?id=<?php echo $row['transaction_id']; ?>&invoice=<?php echo $_GET['invoice']; ?>&dle=<?php echo $_GET['id']; ?>&qty=<?php echo $row['qty'];?>&code=<?php echo $row['product'];?>"><button class="btn btn-mini btn-warning"><i class="icon icon-remove"></i> Отмена </button></a></td>
			</tr>
			<?php
				}
			?>
			<tr>
			<th>  </th>
			<th>  </th>
			<th>  </th>
      <th>  </th>
			<th> Всего: </th>
			<th>  </th>
		</tr>
			<tr>
				<th colspan="4"><strong style="font-size: 12px; color: #222222;"></strong></th>
				<td colspan="1"><strong style="font-size: 12px; color: #222222;">
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
				$sdsd=$_GET['invoice'];
				$resultas = $db->prepare("SELECT sum(amount) FROM sold_items WHERE invoice= :a");
				$resultas->bindParam(':a', $sdsd);
				$resultas->execute();
				for($i=0; $rowas = $resultas->fetch(); $i++){
				$fgfg=$rowas['sum(amount)'];
				echo formatMoney($fgfg, true);
				}
				?>
				</strong>
        </td>

			</tr>

	</tbody>
</table><br>
<a rel="facebox" href="checkout.php?pt=<?php echo $_GET['id']?>&invoice=<?php echo $_GET['invoice']?>&total=<?php echo $fgfg ?>&totalprof=<?php echo $asd ?>&cashier=<?php echo $_SESSION['SESS_FIRST_NAME']?>"><button class="btn btn-success btn-large btn-block"><i class="icon icon-save icon-large"></i> Сохранить</button></a>
<div class="clearfix"></div>
</div>
</div>
</div>
</body>
<?php include('footer.php');?>
</html>
