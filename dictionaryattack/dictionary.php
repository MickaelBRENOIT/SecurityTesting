<?php
	include_once('../singleton/database.php');

	/* we will need that in order to calculate our process time */
	$start = microtime(true);
	$name= $_POST['login'];

	/* We retrieve all the lines on our dictionary */
	$lines = file("./wordlist263533.txt");
	$con = Database::getConnection();
	$i = 0;
	foreach ($lines as $word) {
		/* we delete unwanted characters as end of line */
		$sub = str_replace(array("\n\r", "\n", "\r"), '', $word);
		/* we hash our word */
		$hash=md5($sub);
		
		/* we test the word as a possible password */
		$query = "SELECT * FROM accounts RIGHT JOIN users ON accounts.iduser = users.id WHERE login = '".$name."' AND pass = '".$hash."'";
		
		$result = $con->queryDB($query);
		$total = $result->rowCount();
		
		if($total<1){
			//echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
		}else{
			/* if something is found, the person is hacked */
			echo "<br/>";
			echo "<h2 style=\"text-align:center;\">Results</h2>";
			echo "<h4 style=\"text-align:center;\">Get hacked - Login : ".$name." - Pass : ".$sub."</h4>";
			/* Time we need to hack the acount */
			$executionTime = microtime(true) - $start;
			echo "<h3 style=\"text-align:center;\">Execution Time : ".$executionTime." seconds</h3>";
			echo "&*###*&$name&*###*&$sub";
			break;
		}
	}
?>