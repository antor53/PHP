<?php
$title           = "";
$firstName 		 = "";
$lastName  		 = "";
$organization 	 = "";
$email 			 = "";
$phone 			 = "";
$monday          = "";
$tuesday         = "";
$tshirt          = "";
 
$errTitle        = "";
$errFirstName 	 = "";
$errLastName 	 = "";
$errOrganization = "";
$errEmail 		 = "";
$errPhone 		 = "";
$errAttending 	 = "";
$errTshirt		 = "";
 
$dataValid 		 = true;
 
// If submit with POST
if ($_POST) { 
	$title        = $_POST['title'];
	$firstName 	  = $_POST['firstName'];
	$lastName  	  = $_POST['lastName'];
	$organization = $_POST['organization'];
	$email 		  = $_POST['email'];
	$phone 		  = $_POST['phone'];
	$monday       = $_POST['monday'];
	$tuesday      = $_POST['tuesday'];
	$tshirt       = $_POST['tshirt'];
 
    // Test for nothing entered in field
	if (empty($title)) {
		$errTitle = "Error - one selected radio button is required";
		$dataValid = false;
	}    
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
	if (empty($monday) && empty($tuesday)) {
		$errAttending = "Error - at least one day is required";
		$dataValid = false;				
	}
	if ($_POST['tshirt'] == '--Please choose--') {
		$errTshirt = "Error - a t-shirt size is required";
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
 
<?php if (($_POST || $_GET) && $dataValid) {
 
	// process form - add to DB and then print out all records
	// get database servername, username, password, and database name
	// from local file not on web accessible path (remove newline/blanks)
	$lines    = file('*******');
	$dbserver = trim($lines[0]);
	$user     = trim($lines[1]);
	$password = trim($lines[2]);
	$dbname   = trim($lines[3]);
 
	// Connect to the mysql server and get back our link_identifier
	$connection = mysqli_connect($dbserver, $user, $password, $dbname)
					or die('Could not connect: ' . mysqli_error($connection));
 
 
	if (isset($_GET['id']))
	{
		$sql = 'UPDATE fsoss SET monday = 0, tuesday = 0 WHERE id=' . $_GET['id'];
	}
	else
	{
 
		$sql = "INSERT INTO fsoss VALUES ( null, '$title', '$firstName', '$lastName', " 
										  . "'$organization', '$email', '$phone', " 
										  . (empty($monday) ? 0:1) . ', ' . (empty($tuesday) ? 0:1) . ', '
										  . "'$tshirt' )";
	}
 
	// Run our sql query
	$query = mysqli_query($connection, $sql) 
				or die('query failed'. mysqli_error($connection));
?>
 
	<table border='1'>
		<tr>
			<th>Id</th>	
			<th>Title</th>		
			<th>First name</th>
			<th>Last name</th>
			<th>Organization</th>
			<th>Email address</th>
			<th>Phone number</th>
			<th>Days attending</th>
			<th>T-shirt size</th>	
			<th>Cancel</th>					
		</tr>
 
<?php 
	// Get all records now in DB
	$sql = "SELECT * from fsoss";
 
	// Run our sql query
	$query = mysqli_query($connection, $sql) 
				or die('query failed'. mysqli_error($connection));
 
	while($row = mysqli_fetch_assoc($query)) 
	{
?>
		<tr>
			<td><?php print $row['id']; ?></td>
			<td><?php print $row['title']; ?></td>
			<td><?php print $row['firstName']; ?></td>
			<td><?php print $row['lastName']; ?></td>
			<td><?php print $row['organization']; ?></td>
			<td><?php print $row['email']; ?></td>
			<td><?php print $row['phone']; ?></td>
			<td><?php print ($row['monday'] ? 'Y' : 'N') . '/' . ($row['tuesday'] ? 'Y' : 'N'); ?></td>
			<td><?php print $row['tshirt']; ?></td>				
 
			<td><a href="fsoss-register.php?id=<?php print $row['id']; ?>">Cacel</a></a>
		</tr>
<?php 		
	}		
 
	// Free resultset (optional)
	mysqli_free_result($query);
 
	// Close the MySQL Link
	mysqli_close($connection);
?>		
	</table>
	
<?php } else { ?>
 
	<form method="post" action="">
	<table>
	<tr>
		<td valign="top">Title:</td>
		<td>
			<table>
				<tr><td><input type="radio" name="title" value="mr" <?php if ($title == "mr") echo "CHECKED"; ?> >Mr</td></tr>
				<tr><td><input type="radio" name="title" value="mrs" <?php if ($title == "mrs") echo "CHECKED"; ?> >Mrs</td></tr>
				<tr><td><input type="radio" name="title" value="ms" <?php if ($title == "ms") echo "CHECKED"; ?> >Ms</td></tr>
			</table>
		</td>
		<td><?php echo $errTitle; ?></td>
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
			<input type="checkbox" name="monday" value="monday" <?php if ($monday) echo "CHECKED"; ?> >Monday
			<input type="checkbox" name="tuesday" value="tuesday" <?php if ($tuesday) echo "CHECKED"; ?> >Tuesday
		<td/>
		<?php echo $errAttending; ?>
	</tr>
	<tr>
		<td>t-shirt size:</td>
		<td>
			<select name="tshirt">
				<option>--Please choose--</option>
				<option name="small" value="s" <?php if ($tshirt == 's') echo "SELECTED"; ?> >Small</option>
				<option value="m" <?php if ($tshirt == 'm') echo "SELECTED"; ?> >Medium</option>
				<option value="l" <?php if ($tshirt == 'l') echo "SELECTED"; ?> >Large</option>
				<option value="xl" <?php if ($tshirt == 'xl') echo "SELECTED"; ?> >X-Large</option>
			</select>
		</td>
		<td><?php echo $errTshirt; ?></td>
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