<?php 
	include_once('singleton/database.php');
	$con = Database::getConnection();
	$name= $_POST['login'];
	$nameclean = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$pass= $_POST['pass'];
	$passclean = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$hash=md5($passclean);
	//$result = $con->queryDB("SELECT * FROM accounts INNER JOIN users ON accounts.iduser = users.id WHERE login='$nameclean' AND pass='$hash'") ;
	$result = $con->prepareDB("SELECT * FROM accounts INNER JOIN users ON accounts.iduser = users.id WHERE login = ? AND pass = ?") ;
	$result->bindParam(1, $nameclean);
	$result->bindParam(2, $hash);
	$result->execute();
	$total=$result->rowCount();
	
	if($total<1){
		echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
	}else{
		echo "<br/>";
		echo "<h2 style=\"text-align:center;\">Results</h2>";
		echo "<table class=\"table table-striped\">\n";
		echo "    <thead>\n";
		echo "      <tr>\n";
		echo "        <th>Id</th>\n";
		echo "        <th>Type</th>\n";
		echo "        <th>Amount</th>\n";
		echo "        <th>Id User</th>\n";
		echo "      </tr>\n";
		echo "    </thead>\n";
		echo "    <tbody>\n";
		
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo "      <tr>\n";
			echo "        <td>".$row['id']."</td>\n";
			echo "        <td>".$row['type']."</td>\n";
			echo "        <td>".$row['amount']."</td>\n";
			echo "        <td>".$row['iduser']."</td>\n";
			echo "      </tr>\n";
		}
		
		echo "    </tbody>\n";
		echo "  </table>";
	}
?>
