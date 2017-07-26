<?php		
date_default_timezone_set("America/New_York");
setcookie('visit', $_COOKIE['visit'] + 1);
setcookie('time', time());
 
$dataValid = true;
$name  = "";
$value = "";
$errorName = "";
$errorValue = "";
 
if ($_POST)
{
	$name  = $_POST['name'];
	$value = $_POST['value'];
 
	if ($name == "") 	
	{
		$errorName = "Error - you must fill in a data";	
		$dataValid = false;
	}
 
	if ($value == "") 
	{
		$errorValue = "Error - you must fill in a data";
		$dataValid = false;
	}	
 
	if ($dataValid)
	{
		setcookie($name, $value);	
	}
}
?>
 
<html>
<body>
	<h2>Add Cookie</h2>
	<hr />
	<form method="post" action="">
		<table>
			<tr>
				<td>Name:</td>					
				<td><input type="text" name="name" value="<?php echo $name; ?>" /></td>
				<td><?php echo $errorName; ?></td>
			</tr>
			<tr>
				<td>Value:</td>					
				<td><input type="text" name="value" value="<?php echo $value; ?>" /></td>
				<td><?php echo $errorValue; ?></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" /></td>
				<td></td>
			</tr>	
		</table>
	</form>	
 
	<h2>Welcome</h2>
	<hr />
	<?php 
		if (isset($_COOKIE['visit']))		
			echo "Welcome back - you visited this page " . $_COOKIE['visit'] . " times. <br />";
 
		if (isset($_COOKIE['time']))
			echo "Recent visit time is " . date('Y-m-d H:i:s', $_COOKIE['time']) . "<br />";
	?>
 
	<br />
	<h2>List Cookie</h2>
	<hr />
	<table border="1">
		<tr>
			<th>Name</th>
			<th>Value</th>
		</tr>
		<?php
			while (list($key, $val) = each($_COOKIE))
			{
    			echo "<tr>";
    			echo "<td>$key</td>";
    			echo "<td>$val</td>";
    			echo "</tr>";
			}
		?>
	</table>
</body>
</html>