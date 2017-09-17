<?php 
    include("header.php"); 
    require("captcha/autoload.php");
?>

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
        $prevent_dictionary_attack= isset($_POST['dic'])?"yes":"no";

        /*We look if the checkbox about preventing xss attack was checked and we test if the captcha was validated or not */
        if($prevent_dictionary_attack == "yes") {
            $recaptcha = new \ReCaptcha\ReCaptcha('6Lc6_TAUAAAAAJy6Xhu6Yvt3nxk_4VpdE0VnNTrs');
            $resp = $recaptcha->verify($_POST["g-recaptcha-response"]);
            if ($resp->isSuccess()) {
                // verified!
                // if Domain Name Validation turned off don't forget to check hostname field
                // if($resp->getHostName() === $_SERVER['SERVER_NAME']) {  }
                include_once("./processor.php");
            } else {
                //$errors = $resp->getErrorCodes();
                $error = "Captcha invalid, Script / Robot ?";
            }
        } else {
            include_once("./processor.php");
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
                                
                                <!-- display a captcha -->
                                <div id="display-captcha" class="g-recaptcha" data-sitekey="6Lc6_TAUAAAAAHkIVevmUO50HLl2U1QDU3n7CflS"></div>
                                <!-- if an error is triggered when submitting the form, it's displayed here-->
                                <div id="display-errors" class="bg-danger message" style="background-color: #D46A6A;"><?php if(isset($error)) echo $error; ?></div>
                                <!-- display the loader when a dictionary attack is launched -->
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
                                    <label><input type="checkbox" id="cb-dic" value="yes" name="dic">Prevent Dictionary and/or Brute Force attacks</label>
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