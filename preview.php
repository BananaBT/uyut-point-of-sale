<!DOCTYPE html>
<html>
<head>
<?php require_once ('auth.php');?>
<title>
POS
</title>
 <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">

  <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">

      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script language="javascript">
function Clickheretoprint()
{
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";
      disp_setting+="scrollbars=yes,width=800, height=400, left=100, top=25";
  var content_vlue = document.getElementById("content").innerHTML;

  var docprint=window.open("","",disp_setting);
   docprint.document.open();
   docprint.document.write('</head><body onLoad="self.print()" style="width: 800px; font-size: 13px; font-family: arial;">');
   docprint.document.write(content_vlue);
   docprint.document.close();
   docprint.focus();
}
</script>

<?php
//the important part, here we get invoice id from savesales.php that uniquely identified an invoice,
//and then we pull cash amount and all the other info about a specific sale
//also we pull table number and order note allthe way through savesales.php from checkout.php
$invoice = $_GET['invoice'];
$table = $_GET['table'];
$note = $_GET['note'];
include('../connect.php');
$result = $db->prepare("SELECT * FROM sales WHERE invoice_number= :userid");
$result->bindParam(':userid', $invoice);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
$invoice=$row['invoice_number'];
$date=$row['date'];
$cashier=$row['cashier'];
$am=$row['amount'];
}
?>
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
<body>

<?php include('navfixed.php');?>

	<div class="container-fluid">
      <div class="row-fluid">
	<div class="span2">
             <div class="well sidebar-nav">
                 <ul class="nav nav-list">
              <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Главное меню </a></li>
			<li class="active"><a href="sales.php?id=cash&invoice"><i class="icon-shopping-cart icon-2x"></i> Продажи</a>  </li>
			<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Позиции</a>                                     </li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Ингредиенты (продуктовые карты)</a>                                    </li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Закупки</a>                                    </li>
			<li><a href="salesreport.php?d1=0&d2=0"><i class="icon-bar-chart icon-2x"></i> Статистика</a>                </li>
			<li><a href="sales_inventory.php"><i class="icon-table icon-2x"></i> Расход ингредиентов</a>                </li>
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
	<a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><button class="btn btn-default"><i class="icon-arrow-left"></i> Назад к "Продажам"</button></a>

<div class="content" id="content">
<div style="margin: 0 auto; padding: 20px; width: 900px; font-weight: normal;">
	<div style="width: 100%; height: 190px;" >
	<div style="width: 900px; float: left;">
	<center><div style="font:bold 25px 'Aleo';">ЗАКАЗ</div>
	Кафе "Уют"
  <br><br>
	</center>
	</div>

	<div style="width: 200px; float: left; height: 70px;">
	<table cellpadding="3" cellspacing="0" style="font-family: arial; font-size: 12px; text-align:left; width:100%;">

		<tr>
			<td>Код заказа :</td>
			<td><?php echo $invoice ?></td>
		</tr>
		<tr>
			<td>Дата :</td>
			<td><?php echo $date ?></td>
		</tr>
	</table>

  <div style="width: 136px; float: left; height: 70px;"></div>
  <div class="clearfix"></div>
  </div>

  <div style="width: 35%; margin-top:-70px; margin-left: -20px;">
  	<table border="1" cellpadding="4" cellspacing="0" style="font-family: arial; font-size: 24px;	text-align:left; table-layout: fixed; word-wrap: break-word;" width="100%">
      <!-- table-layout and word-wrap were specified because when there is an item that has a lot of components in it written without spaces, it spreads the table)-->
      <caption>
        За столик: <?= $table; ?>
      </caption>
  		<thead>
  			<tr>
  				<th> Название </th>
  				<th  width="20%"> К-во</th>
  			</tr>
  		</thead>
  		<tbody>

  				<?php
  					$id=$_GET['invoice'];
  					$result = $db->prepare("SELECT * FROM sold_items WHERE invoice= :userid");
  					$result->bindParam(':userid', $id);
  					$result->execute();
  					for($i=0; $row = $result->fetch(); $i++){
  				?>
  			<tr class="record">
  			  <td><?php echo $row['product_name']; ?></td>
  				<td><?php echo $row['qty']; ?></td>
        </tr>

        <?php
          }
        ?>

        <tr>
          <td colspan="2" style="width=100%; font-size: 22px;" id="note"><?php echo $note; ?></td>
        </tr>

  		</tbody>
  	</table>

  	</div>
  	</div>
  	</div>
  </div>



  <div class="pull-right" style="margin-right:100px;">
  		<a href="javascript:Clickheretoprint()" style="font-size:20px;"><button class="btn btn-success btn-large"><i class="icon-print"></i> Распечатать</button></a>
  		</div>
  </div>
  </div>

  <script>
    let noteToHide = document.getElementById("note");
    if (noteToHide.innerHTML == "") {
      noteToHide.style.display = "none";
    }
  </script>

</body>
