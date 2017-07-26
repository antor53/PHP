<?php
 
include_once("myClasses.php");
 
$db = new DBLink();
$pv = new InputValidator($_POST);
 
if($pv->exists('submit')) 
{
    $pv->hasValue('username', 'You must enter an username');
    $pv->hasValue('password', 'You must enter a password');
    $pv->hasValue('passhint', 'You must enter a password hint');
 
    if ($pv->render())
    {
        $salt     = 'salt';
        $username = $pv->getVar('username');
        $password = crypt($pv->getVar('password'), $salt);
        $passhint = $pv->getVar('passhint'); 
 
        $db->query("SELECT * FROM users WHERE username = '$username'");
        if ($db->emptyResult())
        {
            $db->query("INSERT INTO users VALUES ( '$username', '$password', 'user', '$passhint')");
        }                                                                                         
        else
        {
            $db->query("UPDATE users SET password = '$password', passwordHint = '$passhint' WHERE username = '$username'");
        }
 
        $pv->clear();
    }
}
 
$db->query('SELECT * FROM users');
$rows = $db->getRows();
?>
 
<html>
<head>
</head>
<body>
    <h2>Users Table</h2>
    <table border='1'>        
        <tr>
            <th>User Name</th> 
            <th>Password</th>      
            <th>Pasword Hint</th>           
        </tr>
        <?php 
            foreach ($rows as $row) 
            {                            
                echo "<tr>";
                echo "<td>" . $row['username']     . "</td>";
                echo "<td>" . $row['password']     . "</td>";
                echo "<td>" . $row['passwordHint'] . "</td>";
                echo "</tr>";            
            }
        ?> 
    </table>        
    <br /><hr/>
    <h2>Insert / Update</h2>
    <form action="" method="post">
        <table>
            <tr>
                <td>User Name: </td>
                <td><input type="text" name="username" value="<?php echo $pv->getVar('username'); ?>" /><td>
                <td><?php echo $pv->getErr('username'); ?></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="text" name="password" value="<?php echo $pv->getVar('password'); ?>" /><td>
                <td><?php echo $pv->getErr('password'); ?></td>
            </tr>
            <tr>
                <td>Password Hint: </td>
                <td><input type="text" name="passhint" value="<?php echo $pv->getVar('passhint'); ?>" /><td>
                <td><?php echo $pv->getErr('passhint'); ?></td>
            </tr>   
            <tr></tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" /></td>
                <td></td>
            </tr>                           
        </table> 
    </form>
</body>
<html>
 
<?php 
unset($db);
unset($pv);
?>