<?php
	
$use_pdo = false;
 
class DBLink 
{
	private $connection;
	private $query;
 
	public function __construct() 
	{
		$dbserver   = 'db-mysql.zenit';		
		$dbuser 	= 'int322_163b13';
		$dbuserpw   = 'oneTWO345';
		$dbname     = 'int322_163b13';	
 
		if ($GLOBALS['use_pdo'])
		{
			$dsn = "mysql:dbname=$dbname;host=$dbserver";	
 
			try
			{
			    $this->connection = new PDO($dsn, $dbuser, $dbuserpw);
			}
			catch (PDOException $e)
			{
			    echo 'There was a problem connecting to the database: ' . $e->getMessage();
			}
		}
		else
		{
			// Connect DB
			$this->connection = mysqli_connect($dbserver, $dbuser, $dbuserpw, $dbname) 
									or die('Could not connect: ' . mysqli_error($this->link));	
		}	
	}
 
	public function __destruct() 
	{
		if ($GLOBALS['use_pdo'])		
			unset($this->connection);		
		else		
			mysqli_close($this->connection); 		      
    }
 
    public function query($sql_query)
    {
    	if ($GLOBALS['use_pdo'])
    	{
			try 
			{
			    // connect as appropriate as above
			    $this->query = $this->connection->query($sql_query);
			} 
			catch(PDOException $e) 
			{
			    echo "An Error occured: " . $e->getMessage(); 	//user friendly message
			}
		}
		else
		{
    		$this->query = mysqli_query($this->connection, $sql_query) 
								or die('query failed'. mysqli_error($this->connection));    	
		}
		return $this->query;				
    }
 
    public function getRows()
    {	
    	if ($GLOBALS['use_pdo'])
    	{
    		return $this->query->fetchAll(PDO::FETCH_ASSOC);
    	}
    	else
    	{
        	$data = array();
			while($row = mysqli_fetch_assoc($this->query))
				array_push($data, $row);
			return $data;		
    	}
    }
 
    public function emptyResult()
    {
    	if ($GLOBALS['use_pdo'])
    		return $this->query->rowCount() == 0;
    	else
    		return mysqli_num_rows($this->query) == 0; 
    }
}
 
class InputValidator 
{
	private $arrKey = array();
	private $arrErr = array();
 
	public function __construct(&$array) 
	{
		$this->arrKey = $array;
	}
 
	public function clear()
	{
		unset($this->arrKey);
		unset($this->arrErr);
	}
 
    public function exists($key) 
    {    	
        if(is_string($key) || is_int($key)) 
        {        	
			return array_key_exists($key, $this->arrKey);
        }
        return true;
    }
 
	public function hasValue($key, $err) 
	{		
		if ($this->arrKey[$key] == "")
		{
			$this->arrErr[$key] = $err;
			return false;
		}
		else
		{
			$this->arrErr[$key] = "";
		}
    }
 
    public function setVar($key, $value)
    {
    	$this->arrKey[$key] = $value;
    }
 
    public function getVar($key)
    {
    	return $this->arrKey[$key];    	
    }    
 
    public function setErr($key, $value)
    {
    	return $this->arrErr[$key] = $value;
    }
 
    public function getErr($key)
    {
    	return $this->arrErr[$key];
    }
 
    public function render()
    {
    	foreach ($this->arrErr as $err)
    	{
    		if ($err != "")
    			return false;
    	}
    	return true;
    }
}
 
class Menu 
{
	private $_array = array();
 
	public function __construct($strings) 
	{	
		$this->_array[0] = '<label style="width: ' . $strings[1] . '; display: inline-block; margin: 5px 0 5px 0;">';
		$this->_array[1] = $strings[0];		
		$this->_array[2] = '</label>';		
		$this->_array[3] = '<input type="submit" name="' . $strings[2] . '" value="Button"/>';			
	}
 
	public function display()
	{
		foreach ($this->_array as $str)
		{
			echo $str;
		}
	}
}
 
?>