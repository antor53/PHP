<?php
 
include_once("myClasses.php");
 
$menus = array();
$pv = new InputValidator($_POST);
$db = new DBLink();
if ($pv->exists('confirm'))
{
    $title = strtolower($_POST['title']);
    $pv->hasValue('username', 'You must enter an username');
    if ($title != 'delete')
    {
        $pv->hasValue('password', 'You must enter a password');
        $pv->hasValue('passhint', 'You must enter a password hint');
    }
 
    if ($pv->render())
    {
        $salt     = 'salt';
        $username = $pv->getVar('username');
        $password = crypt($pv->getVar('password'), $salt);
        $passhint = $pv->getVar('passhint'); 
 
        if ($title == 'insert')
        {
            $db->query("INSERT INTO users VALUES ( '$username', '$password', 'user', '$passhint')");
        }
        else if ($title == 'update')
        {
            $db->query("UPDATE users SET password = '$password', passwordHint = '$passhint' WHERE username = '$username'");
        }
        else if ($title == 'delete')
        {
            $db->query("DELETE FROM users WHERE username = '$username'");
        }
 
        $title = "display";
    }
 
    $pv->setVar($title, "");
}
 
if ($pv->exists('display'))
{
    $title = "Display";
    $rows = null;
    $db->query('SELECT * FROM users');
    $rows = $db->getRows();    
 
    array_push ($menus, new Menu( ['Go Menu', '80px', 'menu'] ));
}
else if ($pv->exists('insert'))
{
    $title = "Insert";
    array_push ($menus, new Menu( ['Confirm', '80px', 'confirm'] ));
    array_push ($menus, new Menu( ['Go Menu', '80px', 'menu'] ));
}
else if ($pv->exists('update'))
{
    $title = "Update";
    array_push ($menus, new Menu( ['Confirm', '80px', 'confirm'] ));
    array_push ($menus, new Menu( ['Go Menu', '80px', 'menu'] ));
}
else if ($pv->exists('delete'))
{
    $title = "Delete";
    array_push ($menus, new Menu( ['Confirm', '80px', 'confirm'] ));
    array_push ($menus, new Menu( ['Go Menu', '80px', 'menu'] ));
}
else /*if (!$_POST || $pv->exists('menu'))*/
{    
    $title = "Select Menu";
    array_push ($menus, new Menu( ['Display Users', '100px', 'display' ] ));
    array_push ($menus, new Menu( ['Insert User'  , '100px', 'insert'  ] ));
    array_push ($menus, new Menu( ['Update User.' , '100px', 'update'  ] ));
    array_push ($menus, new Menu( ['Delete User'  , '100px', 'delete'  ] ));
}
 
unset($db);
?>
 
<html>
<head>
</head>
<body>
    <h2><?php echo $title; ?></h2>
    <form action="" method="post">
    <input type="hidden" name="title" value="<?php echo $title; ?>" />
    <?php if ($pv->exists('display')) { ?>
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
    <?php } else if ($pv->exists('insert') || $pv->exists('update')) { ?>
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
        </table>       
    <?php } else if ($pv->exists('delete')) { ?> 
        <table>
            <tr>
                <td>User Name: </td>
                <td><input type="text" name="username" value="<?php echo $pv->getVar('username'); ?>" /><td>
                <td><?php echo $pv->getErr('username'); ?></td>
            </tr>
         </table> 
    <?php } ?>    
        <ol>
        <?php foreach ($menus as $menu) { ?>
            <li>
            <?php $menu->display(); ?>
            </li>    
        <?php } ?> 
        </ol>
    </form>
</body>
<html>