<?php
$firstName 		 = "";
$lastName  		 = "";
$organization 	 = "";
$email 			 = "";
$phone 			 = "";
 
$errFirstName 	 = "";
$errLastName 	 = "";
$errOrganization = "";
$errEmail 		 = "";
$errPhone 		 = "";
 
$dataValid 		 = true;
 
// If submit with POST
if ($_POST) { 
	$firstName 	  = $_POST['firstName'];
	$lastName  	  = $_POST['lastName'];
	$organization = $_POST['organization'];
	$email 		  = $_POST['email'];
	$phone 		  = $_POST['phone'];
 
    // Test for nothing entered in field
	if (empty($firstName)) {
		$errFirstName = "Error - you must fill in a data";
		$dataValid = false;
	}
	if (empty($lastName)) {
		$errLastName = "Error - you must fill in a data";
		$dataValid = false;		
	}
	if (empty($organization)) {
		$errOrganization = "Error - you must fill in a data";
		$dataValid = false;		
	}
	if (empty($email)) {
		$errEmail = "Error - you must fill in a data";
		$dataValid = false;		
	}
	if (empty($phone)) {
		$errPhone = "Error - you must fill in a data";
		$dataValid = false;		
	}			
}
?>
 
<html>
<head>
	<title>FSOSS Registration</title>
</head>
<body>
	<h1>FSOSS Registration</h1>
	<hr />
 
<?php if ($_POST && $dataValid) { ?>
 
	<table>
	<tr>
		<td valign="top">Title:</td>
		<td><?php echo $_POST['title']; ?></td>
	</tr>
	<tr>
		<td>First name:</td>		
		<td><?php echo $firstName; ?></td>
	</tr>
	<tr>
		<td>Last name:</td>
		<td><?php echo $lastName; ?></td>
	</tr>
	<tr>
		<td>Organization:</td>
		<td><?php echo $organization; ?></td>
	</tr>
	<tr>
		<td>Email address:</td>
		<td><?php echo $email; ?></td>
	</tr>
	<tr>
		<td>Phone number:</td>
		<td><?php echo $phone; ?></td>
	</tr>
	<tr>
		<td>Days attending:</td>
		<td><?php echo $_POST['monday'] . ', ' . $_POST['tuesday']; ?></td>
	</tr>
	<tr>
		<td>T-shirt size:</td>
		<td><?php echo $_POST['t-shirt']; ?></td>
	</tr>
	</table>
	
<?php } else { ?>
 
	<form method="post" action="">
	<table>
	<tr>
		<td valign="top">Title:</td>
		<td>
			<table>
				<tr><td><input type="radio" name="title" value="mr">Mr</td></tr>
				<tr><td><input type="radio" name="title" value="mrs">Mrs</td></tr>
				<tr><td><input type="radio" name="title" value="ms">Ms</td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>First name:</td>
		<td><input type="text" name="firstName" value="<?php echo $firstName; ?>"></td>
		<td><?php echo $errFirstName; ?></td>
	</tr>
	<tr>
		<td>Last name:</td>
		<td><input type="text" name="lastName" value="<?php echo $lastName; ?>"></td>
		<td><?php echo $errLastName; ?></td>
	</tr>
	<tr>
		<td>Organization:</td>
		<td><input type="text" name="organization" value="<?php echo $organization; ?>"></td>
		<td><?php echo $errOrganization; ?></td>
	</tr>
	<tr>
		<td>Email address:</td>
		<td><input type="text" name="email" value="<?php echo $email; ?>"></td>
		<td><?php echo $errEmail; ?></td>
	</tr>
	<tr>
		<td>Phone number:</td>
		<td><input type="text" name="phone" value="<?php echo $phone; ?>"></td>
		<td><?php echo $errPhone; ?></td>
	</tr>
	<tr>
		<td>Days attending:</td>
		<td>
			<input type="checkbox" name="monday" value="monday">Monday
			<input type="checkbox" name="tuesday" value="tuesday">Tuesday
		<td/>
	</tr>
	<tr>
		<td>T-shirt size:</td>
		<td>
			<select name="t-shirt">
				<option>--Please choose--</option>
				<option name="small" value="s">Small</option>
				<option value="m">Medium</option>
				<option value="l">Large</option>
				<option value="xl">X-Large</option>
			</select>
		</td>
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