<?php /*
	include_once('./singleton/database.php');
	include_once('header.php');
	ini_set('display_errors', 1);
	$con = Database::getConnection();
	$name= $_POST['login'];
	$nameclean = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$pass= $_POST['pass'];
	$passclean = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$hash=md5($passclean);
	//$result = $con->queryDB("SELECT * FROM accounts INNER JOIN users ON accounts.iduser = users.id WHERE login='$nameclean' AND pass='$hash'") ;
	$result = $con->prepareDB("SELECT * FROM accounts RIGHT JOIN users ON accounts.iduser = users.id WHERE login = ? AND pass = ?") ;
	$result->bindParam(1, $nameclean);
	$result->bindParam(2, $hash);
	$result->execute();
	$total=$result->rowCount();

	if($total<1){
		echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
	}else{

		$cookie_name_username = "username";
		$cookie_value_username = $name;
		setcookie($cookie_name_username, $cookie_value_username, time() + (86400 * 30), "/");

		$cookie_name_password = "password";
		$cookie_value_password = $pass;
		setcookie($cookie_name_password, $cookie_value_password, time() + (86400 * 30), "/");
	/*
		$result = $con->prepareDB("INSERT INTO users (login, pass) VALUES ('bobi', md5('saligots') )") ;
		$result->execute();
	*/?>
     <!--<div class="row">

            <div class="col-md-6 col-md-offset-3">-->
			<?php/*
				echo "<h2 style=\"text-align:center;\">Results</h2>";
				echo "<table class=\"table table-striped\">\n";
				echo "    <thead>\n";
				echo "      <tr>\n";
				echo "        <th>Owner</th>\n";
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
			?>
            </div>
            
        </div>
    <?php
	}
	include_once('footer.php');*/
?>
