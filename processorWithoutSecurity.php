<?php 
	include_once('singleton/database.php');
	include_once('header.php');
	ini_set('display_errors', 1);
	
	$name= $_POST['login'];
	$pass= $_POST['pass'];
	$prevent_injection_sql= isset($_POST['sql'])?"yes":"no";
	$prevent_xss_attack= isset($_POST['xss'])?"yes":"no";

	$con = Database::getConnection();
	
	if($prevent_injection_sql == "yes"){
		$nameclean = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$passclean = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$hash=md5($passclean);
		$result = $con->prepareDB("SELECT * FROM accounts RIGHT JOIN users ON accounts.iduser = users.id WHERE login = ? AND pass = ?") ;
		$result->bindParam(1, $nameclean);
		$result->bindParam(2, $hash);
		$result->execute();
	} else {
		$hash=md5($pass);
		$query = "SELECT * FROM accounts RIGHT JOIN users ON accounts.iduser = users.id WHERE login = '".$name."' AND pass = '".$hash."'";
		$result = $con->queryDB($query);
	}

	$total = $result->rowCount();
	
	if($total<1){
		echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
	}else{

		$cookie_name_username = "username";
		$cookie_value_username = $name;
		setcookie($cookie_name_username, $cookie_value_username, time() + (86400 * 30), "/");

		$cookie_name_password = "password";
		$cookie_value_password = $pass;
		setcookie($cookie_name_password, $cookie_value_password, time() + (86400 * 30), "/");

		$_SESSION["token"] = md5(date("mm-dd-yyyy"));
		$_SESSION["connected"] = true;
	?>
        <div class="section col-md-6 col-md-offset-3">
        
        	<div class="row">

                <div class="col-md-10 col-md-offset-1">
			<?php
				
				echo "<br/>";
				echo "<h2 style=\"text-align:center;\">Your accounts</h2>";
				echo "<table class=\"table table-striped\">\n";
				echo "    <thead>\n";
				echo "      <tr>\n";
				echo "        <th>Login</th>\n";
				echo "        <th>Type</th>\n";
				echo "        <th>Amount</th>\n";
				//echo "        <th>Id User</th>\n";
				echo "      </tr>\n";
				echo "    </thead>\n";
				echo "    <tbody>\n";
				if($prevent_xss_attack == "no")
					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
						echo "      <tr>\n";
						echo "        <td>".$row['login']."</td>\n";
						echo "        <td>".$row['type']."</td>\n";
						echo "        <td>".$row['amount']."</td>\n";
						//echo "        <td>".$row['iduser']."</td>\n";
						echo "      </tr>\n";
					}
				else
					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
						echo "      <tr>\n";
						echo "        <td>".htmlspecialchars($row['login'])."</td>\n";
						echo "        <td>".htmlspecialchars($row['type'])."</td>\n";
						echo "        <td>".htmlspecialchars($row['amount'])."</td>\n";
						//echo "        <td>".$row['iduser']."</td>\n";
						echo "      </tr>\n";
					}
				echo "    </tbody>\n";
				echo "  </table>";
				?>
                </div>
            </div>
        </div>
    <?php
	}
	include_once('footer.php');
?>
