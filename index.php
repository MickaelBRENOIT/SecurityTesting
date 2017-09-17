<?php include("header.php"); ?>

<?php

	$prevent_include_attack = "";

    /* We verify that a file is passed into the url */
	if ( isset( $_GET['file'] ) )
	{
		$page =  $_GET['file'];
		
        /* We look if we checked the checkbox about prevent include attack and we set $prevent with a value */
		$prevent = isset( $_GET['prevent'])?$_GET['prevent']:0;
		
        /* If the value is 1, that mean the checkbox was checked so we put the protection */
		if($prevent == 1){
			$page = trim($page, ".php");
			
			$page = str_replace("../","protect",$page);
			$page = str_replace(";","protect",$page);
			$page = str_replace("%","protect",$page);	
			
			if (file_exists($page) && $page != 'index.php') {
			   include("./".$page); 
			}
			else {
				echo "<h4 class='message'>Page inexistante !</h4>";
			}
		}
		else
			include( $page );
	}
?>

<?php

    include_once('singleton/database.php');

    /* Called when the form is submitted */
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        /* We retrieve the login */
        $name= $_POST['login'];
        /* We retrieve the password */
        $pass= $_POST['pass'];
        /* We look if the checkbox about preventing sql injection was checked and we assign a value to the variable */
        $prevent_injection_sql= isset($_POST['sql'])?"yes":"no";
        /* We look if the checkbox about preventing xss attack was checked and we assign a value to the variable */
        $prevent_xss_attack= isset($_POST['xss'])?"yes":"no";
        //$prevent_include_attack= isset($_POST['inc'])?"yes":"no";
		
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
    }
?>

<div id="fullpage">
    <div class="section active" id="section0">
        <div class="mysection col-md-6 col-md-offset-3">
            <h1 style="text-align:center">MMA Bank & Co.</h1>

            <div class="row">
            
                <div class="col-md-10 col-md-offset-1">
                    
                    <!-- If anybody is connected we display the sign in form -->
                    <?php if(!isset($_SESSION) || count($_SESSION) == 0){ ?>
                    <h3 style="text-align:center;">To see your accounts, please enter your login</h3>
                    <form id="formWithoutSecurity" action="" method="post" onSubmit="return submitCheck();">
                        <div class="form-group">
                          <label for="labelLogin">Login</label>
                          <input type="text" class="form-control transparent-input" id="loginWithoutSecurity" placeholder="Login" name="login">
                        </div>
                        <div class="form-group" id="divWithoutSecurity">
                          <label id="labelPasswordWithoutSecurity" for="labelPassword">Password</label>
                          <input type="password" class="form-control transparent-input" id="passwordWithoutSecurity" placeholder="Password" name="pass">
                        </div>

                        <div class="row">

                            <div class="col-md-10 col-md-offset-1">
                                
                                <!-- if an error is triggered when submitting the form, it's displayed here-->
                                <div id="display-errors" class="bg-danger message"><?php if(isset($error)) echo $error; ?></div>
                                <div id="display-loader" style="text-align:center;"></div>

                            </div>
                            
                        </div>
                        <!-- Dropdown list where you can select your attack -->
						<div class="dropdownDiv">
                            <div class="h3 dropdown" style="text-align:center;">Select your attack <i class="mdi mdi-menu-down pull-right"></i></div>
                            <div id="radio-group" class="radio-group red" style="display:none">
                                <div class="radio">
                                    <label><input type="radio" id="rb-dictionary" name="attack" value="dict-attack">Dictionary Attack</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" id="rb-xss" name="attack" value="xss-attack">Cross-site scripting</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" id="rb-include" name="attack" value="include-attack">Include Attack</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" id="rb-none" name="attack" value="no-attack">None</label>
                                </div>
                            </div>
						</div>
                        <!-- Dropdown list where you can select your defenses -->
						<div class="dropdownDiv">
                            <div class="h3 dropdown" style="text-align:center;">Select your defence(s) <i class="mdi mdi-menu-down pull-right"></i></div>
                            <div id="checkbox-group" class="radio-group green" style="display:none">
                                <div class="checkbox">
                                    <label><input type="checkbox" id="cb-xss" value="yes" name="xss">Prevent Cross-site scripting</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" id="cb-sql" value="yes" name="sql">Prevent Injections SQL</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" id="cb-dic" value="">Prevent Dictionary and/or Brute Force attacks</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" id="cb-inc" value="yes" name="inc">Prevent Include attacks</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="submitWithoutSecurity" class="btn btn-block btn-primary">Connect</button>
                    </form>

                    <!-- Otherwise if the user is already connected we display his avatar, his name and a button which redirects him to his accounts -->
                    <?php } else {

                        include_once('singleton/database.php');
                        $con = Database::getConnection();
                        $query = "SELECT * FROM users WHERE id = '".$_SESSION["idUser"]."'";
                        $result = $con->queryDB($query);
                        $row = $result->fetch(PDO::FETCH_ASSOC);

                        ?>
                        <div class="account-infos">
                            <img src="<?= $row["img"]; ?>" alt="..." class="img-rounded" width="140" height="140">
                            <h3 >Welcome <?= $row["login"]; ?></h3>
                            <a class="btn btn-primary" href="./accounts.php">Show my accounts</a>
                            <!-- If the user is an admin, he is the only one who can insert an account or a user -->
                            <?php if($_SESSION["idUser"] == "1") { ?>
                                <a class="btn btn-default" href="./insert/insert.php">Insert accounts or user</a>
                            <?php } ?>

                        </div>
                        
                        <!--<a class="btn btn-danger" href="./logout.php">Logout</a>-->
                    <?php } ?>

                </div>

            </div>`
            
            <div class="row">

                <div class="col-md-10 col-md-offset-1">

                    <button type="button" id="clear" class="btn btn-block btn-warning">Clear everything</button>

                </div>

            </div>
            
        </div>
    </div>

<?php include("slides.php"); ?>

<!-- Our JS -->
<script src="js/myJS.js"></script>

<?php include("footer.php"); ?>