<?php 
	include_once('singleton/database.php');
	ini_set('display_errors', 1);
	
	$name= $_POST['login'];
	$pass= $_POST['pass'];
	$hash=md5($pass);
	$con = Database::getConnection();
	
	$query = "SELECT * FROM accounts INNER JOIN users ON accounts.iduser = users.id WHERE login = '".$name."' AND pass = '".$hash."'";
	
	$result = $con->queryDB($query);
	$total = $result->rowCount();
	
	if($total<1){
		echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
	}else{

		$cookie_name = "user";
		$cookie_value = $name;
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

		echo "<br/>";
		echo "<h2 style=\"text-align:center;\">Results</h2>";
		echo "<table class=\"table table-striped\">\n";
		echo "    <thead>\n";
		echo "      <tr>\n";
		echo "        <th>Login</th>\n";
		echo "        <th>Type</th>\n";
		echo "        <th>Amount</th>\n";
		echo "        <th>Id User</th>\n";
		echo "      </tr>\n";
		echo "    </thead>\n";
		echo "    <tbody>\n";
		
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo "      <tr>\n";
			echo "        <td>".$row['login']."</td>\n";
			echo "        <td>".$row['type']."</td>\n";
			echo "        <td>".$row['amount']."</td>\n";
			echo "        <td>".$row['iduser']."</td>\n";
			echo "      </tr>\n";
		}
		
		echo "    </tbody>\n";
		echo "  </table>";

		if(!isset($_COOKIE[$cookie_name])) {
		    echo "Cookie named '" . $cookie_name . "' is not set!";
		} else {
		    echo "Cookie '" . $cookie_name . "' is set!<br>";
		    echo "Value is: " . $_COOKIE[$cookie_name];
		}

	}
?>
