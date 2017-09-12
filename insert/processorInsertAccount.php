<?php 
	include_once('../singleton/database.php');
	ini_set('display_errors', 1);
	
	$owner= $_POST['owner'];
	$type= $_POST['type'];
	$amount = $_POST['amount'];
	
	$typeclean = filter_var($type, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$amountclean = filter_var($amount, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	
	$con = Database::getConnection();
	$result = $con->prepareDB("INSERT INTO accounts VALUES ( NULL, ? , ?, ? )") ;
	$result->bindParam(1, $typeclean);
	$result->bindParam(2, $amountclean);
	$result->bindParam(3, $owner);
	$result->execute();
	
	if(!$result){
		echo "<h3 style=\"text-align:center;\">Erreur lors de l'insertion</h3>";
	}else{
		echo "<h3 style=\"text-align:center;\">Compte ajouté avec succes</h3>";
	}
?>
