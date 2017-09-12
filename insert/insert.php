<!DOCTYPE <!DOCTYPE html>
<html lang="fr">

    <head>
    
        <!-- allow to use accents -->
        <meta charset="utf-8">
        
        <!-- Basic SEO Optimization -->
        <meta name="description" content="">
        <meta name="keywords" content="">
        
        <!-- allow compatibility with IE -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <!-- allow compatibility with small devices like tablets and phones -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- title of the website -->
        <title>Security tests</title>
        
        <!-- icon of the website -->
        <link rel="shortcut icon" href="">
        
        <!-- Fonts : need to be load before any others css files (Default Font "Roboto") -->
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
        
        <!-- CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        
    </head>

    <body>

        <div class="container">
            <div class="row">                
                <div class="col-md-6">

                    <h2 style="text-align:center;">Insert Users</h2>
                    
                    <form id="insertUserWithSecurity">
                          <div class="form-group">
                            <input type="text" class="form-control" id="loginWithSecurity" placeholder="Login">
                            <input type="password" class="form-control" id="passwordWithSecurity" placeholder="Password">
                          </div>
                          <button type="submit" id="submitInsertUserWithSecurity" class="btn btn-block btn-success">Insert</button>
                    </form>
				</div>
                <div class="col-md-6">
                    
                    <h2 style="text-align:center;">Insert Accounts</h2>
                    
                    <form id="insertAccountWithSecurity">
                          <div class="form-group">
                            <select type="text" class="form-control" id="accountOwner" placeholder="Login">
                            	<option value="0"></option>
                            	<?php
									include_once('../singleton/database.php');
									$con = Database::getConnection();
									$result = $con->prepareDB("SELECT id, login FROM users") ;
									$result->execute();
									while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value='".$row['id']."'>".$row['login']."</option>";
									}
								?> 
                            </select>
                            <input type="text" class="form-control" id="accountType" placeholder="Account type">
                            <input type="text" class="form-control" id="accountAmount" placeholder="Amount">
                          </div>
                          <button type="submit" id="submitInsertAccountWithSecurity" class="btn btn-block btn-success">Insert</button>
                    </form>
                </div>

            </div>

            <hr style="border: 0; 
					  height: 5px; 
					  background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
					  background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
					  background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
					  background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);">

            <div class="row">

                <div class="col-md-	2">
                    
                    <div id="display"></div>

                </div>

            </div>

            <hr style="border: 0; 
					  height: 5px; 
					  background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
					  background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
					  background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
					  background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);">

            <div class="row">

                <div class="col-md-12">
                    <button type="button" id="clear" class="btn btn-block btn-info">Clear everything</button>
                </div>

            </div>
            
        </div>

        <!-- JQuery JS -->
        <script src="../js/jquery.js"></script>

        <!-- JQuery cookie JS -->
        <script src="../js/jquery.cookie.js"></script>

        <script>
        $(document).ready(function(){
			
			/* Handle the event when the form with security is submitted */
            
			
			$("#submitInsertUserWithSecurity").click(function(){
				if(!$('#submitWithSecurity').hasClass('disabled')){
					var login = $("#loginWithSecurity").val();
					var pass = $("#passwordWithSecurity").val();
					var dataString = 'login='+ login + '&pass='+ pass;
					if(login == '' || pass == '')
					{
						$("#display").html("<h4 class=\"bg-warning\" style=\"text-align:center; padding: 30px 0 30px 0;\">Please fill all fields</h4>");
					}
					else
					{
						$.ajax({
							type: "POST",
							url: "processorInsertUser.php",
							data: dataString,
							cache: false,
							success: function(result){
								$("#display").html(result);
								$("#insertUserWithSecurity")[0].reset();
							}
						});
					}
					return false;
				} else {
					return false;
				}
            });
			
			$("#submitInsertAccountWithSecurity").click(function(){
				var owner = $("#accountOwner").val();
				var type = $("#accountType").val();
				var amount = $("#accountAmount").val();
				var dataString = 'owner='+ owner + '&type='+ type + '&amount='+ amount;
				if(owner == '' || type == '' || amount == '')
				{
					$("#display").html("<h4 class=\"bg-warning\" style=\"text-align:center; padding: 30px 0 30px 0;\">Please fill all fields</h4>");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "processorInsertAccount.php",
						data: dataString,
						cache: false,
						success: function(result){
							$("#display").html(result);
							$("#insertAccountWithSecurity")[0].reset();
						}
					});
				}
				return false;
            });
        });
        </script>

    </body>

</html>