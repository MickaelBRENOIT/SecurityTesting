<?php 
	include_once('singleton/database.php');
	ini_set('display_errors', 1);
	
	
	$servername = "artgalermoeibltd.mysql.db";  // serveur de bdd
	$username = "artgalermoeibltd";   // nom de l'utilisateur
	$password = "8G46dyu7ti";   // mot de passe utilisateur
	$dbname = "artgalermoeibltd";   // nom de la bdd
	
	/*
	$servername = "localhost";
	$username = "root";
	$password = NULL;
//	$dbname = "uha_securite";
	$dbname = "mini_projet";*//*
	$conn = new mysqli($servername, $username, $password, $dbname);	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	echo $conn->error;
	
	// Create connection
	*/
	$name= $_POST['login'];
	$pass= $_POST['pass'];
	$hash=md5($pass);
	$con = Database::getConnection();
	
	$query = "SELECT * FROM accounts INNER JOIN users ON accounts.iduser = users.id WHERE login = '".$name."' AND pass = '".$hash."'";
	
	$result = $con->queryDB($query);
	$total = $result->rowCount();
	echo $query;
	
	if($total<1){
		echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
	}else{
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
	}
?>
