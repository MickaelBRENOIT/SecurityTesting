<?php 
	include_once('singleton/database.php');
	include_once('header.php');
	ini_set('display_errors', 1);

	$con = Database::getConnection();
	/* If the user who is connected is not an admin he will see his accounts. Otherwise an admin can see every accounts. */
	if($_SESSION['idUser'] != 1)
		$query = "SELECT * FROM accounts RIGHT JOIN users ON accounts.iduser = users.id WHERE users.id = '".$_SESSION['idUser']."'";
	else
		$query = "SELECT * FROM accounts RIGHT JOIN users ON accounts.iduser = users.id order by users.id";
	$result = $con->queryDB($query);

	/* We retrieve the number of lines (or accounts found) */
	$total = $result->rowCount();
	
	/* In case of error */
	if($total<1){
		echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
	}else{
	?>
	
        <div class="mysection col-md-6 col-md-offset-3">
        
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
				echo "      </tr>\n";
				echo "    </thead>\n";
				echo "    <tbody>\n";

				/* if the user is not protected against xss attack, we DO NOT escape the datas we retrieved. Otherwise we do. */

				if($_SESSION['xss'] == "no")
					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
						echo "      <tr>\n";
						echo "        <td>".$row['login']."</td>\n";
						echo "        <td>".$row['type']."</td>\n";
						echo "        <td>".$row['amount']."</td>\n";
						echo "      </tr>\n";
					}
				else
					while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
						echo "      <tr>\n";
						echo "        <td>".htmlspecialchars($row['login'])."</td>\n";
						echo "        <td>".htmlspecialchars($row['type'])."</td>\n";
						echo "        <td>".htmlspecialchars($row['amount'])."</td>\n";
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
