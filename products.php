<html>
<head>
<title>
"UYUT" POS Service
</title>

<?php
require_once('auth.php');
?>
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
<!--sa poip up-->
<script src="jeffartagame.js" type="text/javascript" charset="utf-8"></script>
<script src="js/application.js" type="text/javascript" charset="utf-8"></script>
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

<script>
function sum() {
            var txtFirstNumberValue = document.getElementById('txt1').value;
            var txtSecondNumberValue = document.getElementById('txt2').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt3').value = result;

            }

			 var txtFirstNumberValue = document.getElementById('txt11').value;
            var result = parseInt(txtFirstNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt22').value = result;
            }

			 var txtFirstNumberValue = document.getElementById('txt11').value;
            var txtSecondNumberValue = document.getElementById('txt33').value;
            var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt55').value = result;

            }

			 var txtFirstNumberValue = document.getElementById('txt4').value;
			 var result = parseInt(txtFirstNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt5').value = result;
				}

        }
</script>


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
			<li><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Продажи</a>  </li>
			<li class="active"><a href="products.php"><i class="icon-list-alt icon-2x"></i> Позиции</a>                                     </li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Ингредиенты</a>                                    </li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Закупки</a>                                    </li>
			<li><a href="salesreport.php?d1=0&d2=0"><i class="icon-bar-chart icon-2x"></i> Статистика</a>                </li>


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
			<i class="icon-table"></i> Позиции
			</div>
			<ul class="breadcrumb">
			<li><a href="index.php">Главное меню</a></li> /
			<li class="active">Позиции</li>
			</ul>


<div style="margin-top: -19px; margin-bottom: 21px;">
<a  href="index.php"><button class="btn btn-default btn-large" style="float: left;"><i class="icon icon-circle-arrow-left icon-large"></i> Назад</button></a>

  <?php
	  include('../connect.php');
		  $result = $db->prepare("SELECT * FROM products");
			$result->execute();
			$rowcount = $result->rowcount();
	?>

			<div style="text-align:center;">
			Общее число позиций:  <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $rowcount;?>]</font>
			</div>

</div>

<!--
Here starts the table
-->


<input type="text" style="padding:15px;" name="filter" value="" id="filter" placeholder="Найти продукт..." autocomplete="off" />
<a rel="facebox" href="addproduct.php"><Button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Добавить позицию</button></a><br><br>
<table class="hoverTable" id="resultTable" data-responsive="table" style="text-align: left;">
	<thead>
		<tr>
			<th width="22%"> Название </th>
			<th width="16%"> Категория </th>
			<th width="10%"> Цена </th>
			<th width="10%"> Кухня / Бар </th>
      <th width="20%"> Примечание </th>
			<th width="12%"> Действие </th>
		</tr>
	</thead>
	<tbody>
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

    function kitchenOrBar($kitchenValue) {
        if ($kitchenValue == 0) {
          return "Бар";
        } else {
          return "Кухня";
        }

    }

      include('../connect.php');
      $result = $db->prepare("SELECT * FROM products ORDER BY product_name DESC");
			$result->execute();
			for($i=0; $row = $result->fetch(); $i++){
					echo '<tr class="record">';
      //notice that there is no closing brackets for the "for" cycle, they are down the file
      ?>

      <td><?= $row['product_name']; ?></td>
			<td><?= $row['category']; ?></td>
      <td><?php
			$price = $row['price'];
			echo formatMoney($price, true);
      ?></td>
			<td><?php
      $kitchenValue = $row['kitchen'];
      echo kitchenOrBar($kitchenValue);
      ?></td>
			<td><?= $row['product_comment']; ?></td>
      <td><a rel="facebox" title="Нажмите для редактирования позиции" href="editproduct.php?id=<?php echo $row['product_id']; ?>"><button class="btn btn-warning"><i class="icon-edit"></i> </button> </a>
			<a href="#" id="<?php echo $row['product_id']; ?>" class="delbutton" title="Нажмите для удаления позиции"><button class="btn btn-danger"><i class="icon-trash"></i></button></a></td>

      </tr>
      <?php
				}
			?>

	</tbody>
</table>
<div class="clearfix"></div>
</div>
</div>
</div>

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
 if(confirm("Подтвердите удаление продукта, нажав ОК; вы не сможете отменить это действие!"))
		  {

 $.ajax({
   type: "GET",
   url: "deleteproduct.php",
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
</body>
<?php include('footer.php');?>

</html>