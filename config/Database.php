
<?php
/**
 * summary
 */
class Database
{
    /**
     * summary
     */
    private $host;
    private $username;
    private $password;
    private $database;
    private $conn;

    public function connect()
    {
    	$this->host = 'localhost';
    	$this->username = 'root';
    	$this->password = '';
    	$this->database = 'restapi_corephp';
    	$this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
    	if ($this->conn->connect_errno) {
    		die($this->conn->connect_error);
    	} 
    	else
    	 {
    	 	return $this->conn;
    	}
    }
}