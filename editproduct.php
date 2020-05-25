<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveeditproduct.php" method="post">
<center><h4><i class="icon-edit icon-large"></i> Редактирование позиции</h4></center>
<hr>

<?php
	include('../connect.php');
	//$id variable is in the products.php, it was extracted from the product table of the database, product_id column
	//the whole query down the file extracts all the relevant info on a position with a certain id
	$id=$_GET['id'];
	$itemToEdit = $db->prepare("SELECT * FROM products WHERE product_id= :userid");
	$itemToEdit->bindParam(':userid', $id);
	$itemToEdit->execute();

	for ($i=0; $row = $itemToEdit->fetch(); $i++) {
		//the DB does not return whatever inside quotes by default to protect itself from sql injection, so to return them you first have to use htmlspecialchars
		//the first answer here -- https://stackoverflow.com/questions/13711693/how-to-pass-apostrophies-from-text-areas-to-mysql-using-php
		$productNameWithQuotes = htmlspecialchars($row['product_name'], ENT_QUOTES);
?>

<div id="ac">
<!--first we get $id and send it saveeditproduct.php as an entry to a hidden field, there it can be used to actually pull and change the data from the database using product_id -->
<input type="hidden" name="productIdentifier" value="<?php echo $id; ?>" />
<span>Название : </span><input type="text" style="width:265px; height:30px;"  name="productName" value="<?= $productNameWithQuotes; ?>" Required/><br>
<span>Категория : </span>
<select name="category" style="width:265px; height:30px; margin-left:-5px;" >
	<!--the first <option> line defined the default option-->
	<option><?= $row['category']; ?></option>
	<?php
		$categoryItems = $db->prepare("SELECT * FROM categories");
		$categoryItems->bindParam(':userid', $res);
		$categoryItems->execute();
		for ($i=0; $rows = $categoryItems->fetch(); $i++) {
	?>
	<option><?= $rows['category']; ?></option>
	<?php
	}
	?>
</select>

<span>Цена : </span><input type="text" style="width:265px; height:30px;" id="txt1" name="price" value="<?php echo $row['price']; ?>" onkeyup="sum();" Required/><br>

<!--
we need to make radio buttons in such a way, that the correct ones are checked by default
as a temporary solution we create a hidden paragraph with a row value of 0 or 1 depending on whether it's a kitchen or a bar product
and then by extracting this value through DOM we manipulate (by using DOM "checked" property) radio buttons
later we somehow will remove this crutch-->

<p id="ks" style="display:none;"><?php echo $row['kitchen']; ?></p>

<script>
var kitchenStatus = document.getElementById("ks").innerText;
if (kitchenStatus == "0") {
	document.getElementById("bar").checked = true;
} else if (kitchenStatus == "1") {
	document.getElementById("kitchen").checked = true;
} else {
	document.getElementById("bar").checked = false;
	document.getElementById("kitchen").checked = false;
}
</script>

<div style="display:inline-block; margin-right: 8em;">
	<input type="radio" id="kitchen" name="kitchen" value="1"><label for="kitchen" style="display:inline-block; margin-left: 1vw;">Кухня</label>
	<!--the "value" argument of the radio button is sent to saveeditproduct.php and further next to the DB-->
</div>
<div style="display:inline-block;">
	<input type="radio" id="bar" name="kitchen" value="0"><label for="bar" style="display:inline-block; margin-left: 1vw;">Бар</label>
</div>
<br><br>
<span>Комментарий : </span><textarea style="width:265px; height:50px;" name="comment" ><?php echo $row['product_comment']; ?> </textarea><br>

<br>

<div style="float:right; margin-right:10px;">

<button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Сохранить изменения</button>
</div>
</div>
</form>
<?php
}
?>
