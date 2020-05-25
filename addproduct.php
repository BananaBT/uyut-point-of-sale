<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveproduct.php" method="post">
<center><h4><i class="icon-plus-sign icon-large"></i> Добавить позицию</h4></center>
<hr>

<!--form, which is sent to save_product.php through the POST method-->

<div id="ac">
  <span>Название : </span><textarea style="width:265px; height:50px; resize:vertical;" name="product_name" required> </textarea><br>
  <!--value of an attribute "name" should be exactly as the name of the column in the DB, so "product_name" for the textfield above-->
	<span>Категория : </span>
	<select name="category"  style="width:265px; height:30px; margin-left:-5px;" >
			<option></option>
	<?php
	include('../connect.php');
	$result = $db->prepare("SELECT * FROM categories");
		$result->bindParam(':userid', $res);
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
		<option><?php echo $row['category']; ?></option>
	<?php
	}
	?>
	?>
  </select><br>
	<span>Цена : </span><input type="text" id="txt1" style="width:265px; height:30px;" name="price" onkeyup="sum();"><br><br>

<!--"value" argument of the radio button is sent to saveproduct.php and further next to the DB-->

  <div style="display:inline-block; margin-right: 8em;">
    <input type="radio" id="kitchen" name="kitchen" value="1" checked><label for="kitchen" style="display:inline-block; margin-left: 1vw;">Кухня</label>
    <!--the "value" argument of the radio button is sent to saveproduct.php and further next to the DB-->  
  </div>
  <div style="display:inline-block;">
    <input type="radio" id="bar" name="kitchen" value="0"><label for="bar" style="display:inline-block; margin-left: 1vw;">Бар</label>
  </div>

  <br><br>
  <span>Комментарий : </span><textarea style="width:265px; height:50px; resize:vertical;" name="product_comment"> </textarea>

  <br><br>



<div style="float:right; margin-right:10px;">
<button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Сохранить</button>
</div>
</div>
</form>
