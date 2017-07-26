<?php
$data = "";
$errData = "";
$dataValid = true;
 
if ($_POST) { 
	$data = $_POST['data'];
	$pattern = "/^ *((\([0-9]{3}\))|([0-9]{3} *-?)) *[0-9]{3} *-? *[0-9]{4} *$/";
 
	if (empty($data)) {
		$errData = "Error - you must fill in a data";
		$dataValid = false;
	}		
	else if (!preg_match($pattern, $data))
	{
		$errData = "Error - you must fill in a valid formatted data";
		$dataValid = false;	
	}	
}
?>
 
<html>
<head>
	<title>Regular Expression</title>
</head>
<body>
	<h2>Regular Expressions</h2>
	<h3>6. Telephone number validation: 
		<ul>
			<li>999-999-9999</li>
			<li>999 999 9999</li>
			<li>999 999-9999</li>
			<li>9999999999</li>
			<li>999 9999999</li>
			<li>(999) 999-9999</li>
			<li>(999) 999 9999</li>
		</ul>
	</h3>
	<h4>
		<ul>
			<li>Where There is an embedded blank between digits, there may be zero or more embedded blanks.</li>
			<li>All valid forms may have leading and trailing blanks.</li>			
		</ul>
	</h4>
 
	<hr />
 
<?php if ($_POST && $dataValid) { ?>
 
	<h3><?php echo "[$data] is valid."; ?></h3>
 
<?php } else { ?>
 
	<form method="post" action="">
	<table>
	<tr>
		<td>Telephone number:</td>
		<td><input type="text" name="data" value="<?php echo $data; ?>"></td>
		<td><?php echo $errData; ?></td>
	</tr>
	<tr>
		<td></td><td></td><td></td>
	</tr>
	<tr>
		<td></td><td><input name="submit" type="submit"></td><td></td>
	</tr>
	</table>
	</form>
 
<?php } ?>
 
</body>
</html>