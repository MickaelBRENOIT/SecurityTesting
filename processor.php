<?php
	$con = Database::getConnection();

    /* If the checkbox was checked about preventing sql injection, we ... */
    if($prevent_injection_sql == "yes"){
        
        /* ... filter the login and password variables in order to not accept quotes or tags */
        $nameclean = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $passclean = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        /* We hashed the password */
        $hash=md5($passclean);
		
        /* We do a prepare statement and we bind the values */
        $req = $con->prepareDB("SELECT * FROM users WHERE login = ? AND pass = ?") ;
        $req->bindParam(1, $nameclean);
        $req->bindParam(2, $hash);
        $req->execute();
    } else {
        $hash=md5($pass);

        /* The checkbox was not checked so we do a normal query */
        /*       bob' -- '  ||||| blabla' OR '1'='1' #         */
        $query = "SELECT * FROM users WHERE login = '".$name."' AND pass = '".$hash."'";
        $req = $con->queryDB($query);
    }
	
    /* The result of the query is stored in a associative array */
    $result = $req->fetch(PDO::FETCH_ASSOC);
    
    /* If a user is found */
    if($result){
        
        /* We set some cookies */
        $cookie_name_username = "username";
        $cookie_value_username = $name;
        setcookie($cookie_name_username, $cookie_value_username, time() + (86400 * 30), "/");

        $cookie_name_password = "password";
        $cookie_value_password = $pass;
        setcookie($cookie_name_password, $cookie_value_password, time() + (86400 * 30), "/");

        /* We set his session with some informations */
        $_SESSION["token"] = md5(date("mm-dd-yyyy"));
        $_SESSION["connected"] = true;
        $_SESSION["idUser"] = $result['id'];
        $_SESSION["xss"] = $prevent_xss_attack;

        /* We redirect the user to his accounts */
        header("location: ./accounts.php");

    }else{
        //echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
        $error = "Login/Password incorrect";
    }
?>