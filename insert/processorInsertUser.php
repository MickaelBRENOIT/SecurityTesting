<?php 
	include_once('../singleton/database.php');
	ini_set('display_errors', 1);
	
	$name= $_POST['login'];
	$pass= $_POST['pass'];
	
	$nameclean = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$pass= $_POST['pass'];
	$passclean = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$hash=md5($pass);
	
	$con = Database::getConnection();
	
	$result = $con->prepareDB("INSERT INTO users VALUES ( NULL, ? , ? )") ;
	$result->bindParam(1, $nameclean);
	$result->bindParam(2, $hash);
	$result->execute();
	
	if(!$result){
		echo "<h3 style=\"text-align:center;\">Erreur lors de l'insertion</h3>";
	}else{
		echo "<h3 style=\"text-align:center;\">Utilisateur ajouté avec succes</h3>";
	}
?>
