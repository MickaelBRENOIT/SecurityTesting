<?php
	include_once('../singleton/database.php');
	$start = microtime(true);
	$name= $_POST['login'];
	$lines = file("wordlist263533.txt");
	$con = Database::getConnection();

	foreach ($lines as $word) {
		// Need to test every word in the dictionary
		$sub = substr($word, 0, -1);
		$hash=md5($sub);

		$query = "SELECT * FROM accounts INNER JOIN users ON accounts.iduser = users.id WHERE login = '".$name."' AND pass = '".$hash."'";
		
		$result = $con->queryDB($query);
		$total = $result->rowCount();
		
		if($total<1){
			//echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
		}else{
			echo "<br/>";
			echo "<h2 style=\"text-align:center;\">Results</h2>";
			echo "<h4 style=\"text-align:center;\">Get hacked - Login : ".$name." - Pass : ".$sub."</h4>";
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

			$executionTime = microtime(true) - $start;
			echo "<h3 style=\"text-align:center;\">Execution Time : ".$executionTime." seconds</h3>";
			break;
		}
	}
?>