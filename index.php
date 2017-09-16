<?php include("header.php"); ?>
<?php
	if (isset( $_GET['includeattack'] ) )
	{
		$format = "./includeattack/includeattack1";
		include( $format . '.php' );
	}
?>

<?php

    include_once('singleton/database.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $name= $_POST['login'];
        $pass= $_POST['pass'];
        $prevent_injection_sql= isset($_POST['sql'])?"yes":"no";
        $prevent_xss_attack= isset($_POST['xss'])?"yes":"no";

        $con = Database::getConnection();

        if($prevent_injection_sql == "yes"){
            $nameclean = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $passclean = filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $hash=md5($passclean);
            $req = $con->prepareDB("SELECT * FROM users WHERE login = ? AND pass = ?") ;
            $req->bindParam(1, $nameclean);
            $req->bindParam(2, $hash);
            $req->execute();
        } else {
            $hash=md5($pass);
            $query = "SELECT * FROM users WHERE login = '".$name."' AND pass = '".$hash."'";
            $req = $con->queryDB($query);
        }

        $result = $req->fetch(PDO::FETCH_ASSOC);
        /*       bob' -- '  ||||| blabla' OR '1'='1' #         */

        if($result){
            
            $cookie_name_username = "username";
            $cookie_value_username = $name;
            setcookie($cookie_name_username, $cookie_value_username, time() + (86400 * 30), "/");

            $cookie_name_password = "password";
            $cookie_value_password = $pass;
            setcookie($cookie_name_password, $cookie_value_password, time() + (86400 * 30), "/");

            $_SESSION["token"] = md5(date("mm-dd-yyyy"));
            $_SESSION["connected"] = true;
            $_SESSION["idUser"] = $result['id'];
            $_SESSION["xss"] = $prevent_xss_attack;

            header("location: ./accounts.php");

        }else{
            //echo "<h3 style=\"text-align:center;\">Login/Password incorrect</h3>";
            $error = "Login/Password incorrect";
        }
    }
?>

<div class="section col-md-6 col-md-offset-3">
    <h1 style="text-align:center">MMA Bank & Co.</h1>

    <div class="row">
    
        <div class="col-md-10 col-md-offset-1">
            
            <?php if(!isset($_SESSION) || count($_SESSION) == 0){ ?>
            <h3 style="text-align:center;">To see your accounts, please enter your login</h3>
            <form id="formWithoutSecurity" action="" method="post" onSubmit="return submitCheck();">
                <div class="form-group">
                  <label for="labelLogin">Login</label>
                  <input type="text" class="form-control" id="loginWithoutSecurity" placeholder="Login" name="login">
                </div>
                <div class="form-group" id="divWithoutSecurity">
                  <label id="labelPasswordWithoutSecurity" for="labelPassword">Password</label>
                  <input type="password" class="form-control" id="passwordWithoutSecurity" placeholder="Password" name="pass">
                </div>

                <div class="row">

                    <div class="col-md-10 col-md-offset-1">
                        
                        <div id="display-errors" class="bg-danger message"><?php if(isset($error)) echo $error; ?></div>
                        <div id="display-loader" style="text-align:center;"></div>

                    </div>
                    
                </div>

                <div class="h3 dropdown">Select your attack <i class="mdi mdi-menu-down pull-right"></i></div>
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
                <hr/>
                <div class="h3 dropdown">Select your defence(s) <i class="mdi mdi-menu-down pull-right"></i></div>
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
                </div>

                <button type="submit" id="submitWithoutSecurity" class="btn btn-block btn-primary">Connect</button>
            </form>
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

<!-- Our JS -->
<script src="js/myJS.js"></script>

<?php include("footer.php"); ?>