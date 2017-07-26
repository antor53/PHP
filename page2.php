<?php
session_start();
 
if(!isset($_SESSION['username']))
{
	header("location: login.php");
}
 
?>
 
<html>
<body>
	<h2>Page2</h2>
	<hr/>
	<?php echo $_SESSION['username']; ?>
</body>
</html>