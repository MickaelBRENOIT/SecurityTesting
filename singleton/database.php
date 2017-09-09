<?php

//db connection class using singleton pattern
class Database{

	private static $_instance;
    private $_pdo;

    private function __construct()
    {
        $this->_pdo = new PDO('mysql:host=localhost;dbname=mini_projet', 'root', '');//<-- connect here
        $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getConnection()
    {
        if (self::$_instance === null) //don't check connection, check instance
        {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }
	
	public function queryDB($query)
	{
		return $this->_pdo->query($query);
	}
	
	public function prepareDB($query)
	{
		return $this->_pdo->prepare($query);
	}

    //to TRULY ensure there is only 1 instance, you'll have to disable object cloning
    public function __clone()
    {
        return false;
    }
    public function __wakeup()
    {
        return false;
    }

} //end class

?>