<?php 
	include_once('../singleton/database.php');
	ini_set('display_errors', 1);
	
	$name= $_POST['login'];
	$pass= $_POST['pass'];
	
	$error = array();
    $upload_dir = './uploads/';
	$filename = "";
	
	if(count($_FILES) > 0){
		$allowed_ext = array('jpg','jpeg','png','gif');
		$pic = "";
		
		if(array_key_exists('file',$_FILES) && $_FILES['file']['error'] == 0 ){
			
			$pic = $_FILES['file'];
			$ext = pathinfo($pic['name'], PATHINFO_EXTENSION);
			
			if(!in_array($ext,$allowed_ext))
				$error['extension'] = "Seuls les formats 'jpg', 'jpeg', 'png' et 'gif' sont autorisés !";
				
			$size = floatval(filesize($pic['tmp_name'])/(1024*1024));
			if($size > 1)
				$error['size'] = "L'image ne doit pas dépasser 1mo !";
				
			if(count($error) == 0 || $error == ""){
				if(!file_exists($upload_dir)){
					mkdir($upload_dir);
				}
				
				if(!move_uploaded_file($pic['tmp_name'],$upload_dir.$pic['name']))
					$error['move'] = "Une erreur s'est produite lors du chargement de l'image.";
				$filename = "./insert/uploads/" . $pic['name'];
			}
		}
	}
	if(count($error) == 0){
		$nameclean = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$pass= $_POST['pass'];
		$passclean = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$hash=md5($pass);
		
		$con = Database::getConnection();
		
		$result = $con->prepareDB("INSERT INTO users VALUES ( NULL, ? , ? , ?)") ;
		$result->bindParam(1, $nameclean);
		$result->bindParam(2, $hash);
		$result->bindParam(3, $filename);
		$result->execute();
	}
	if(!$result || count($error) > 0){
		echo "<h3 style=\"text-align:center;\">Erreur lors de l'insertion</h3>";
		foreach($error as $er){
			echo $er."<br/>";
		}
	}else{
		//header("Location: ./insert.php");
		var_dump($_FILES);
		if($filename != "")
			echo "<img src='$filename' width='50px'/>";
		//var_dump($_POST);
	}
	
	
	function get_extension($file_name){
		$ext = explode('.', $file_name);
		$ext = array_pop($ext);
		
		return strtolower($ext);
	}
?>
