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

        <div class="container">
            <div class="row">
                <div class="col-md-6">

                    <h2 style="text-align:center;">Sans Sécurité</h2>

                    <form>
                          <div class="form-group">
                            <label for="labelLogin">Login</label>
                            <input type="text" class="form-control" id="loginWithoutSecurity" placeholder="Login">
                          </div>
                          <div class="form-group" id="divWithoutSecurity">
                            <label for="labelPassword">Password</label>
                            <input type="password" class="form-control" id="passwordWithoutSecurity" placeholder="Password">
                          </div>
                          <button type="submit" id="submitWithoutSecurity" class="btn btn-block btn-danger">Submit Without Security</button>
                    </form>

                    <button type="button" id="submitDictionaryAttack" class="btn btn-block btn-warning">Dictionary Attack</button>

                </div>
                
                <div class="col-md-6">
                    
                    <h2 style="text-align:center;">Avec Sécurité</h2>

                    <form>
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

            <div class="row">

                <div class="col-md-6">
                    
                    <div id="displayWithoutSecurity"></div>

                </div>

                <div class="col-md-6">
                    
                    <div id="displayWithSecurity"></div>

                </div>

            </div>
            
        </div>

        <!-- JQuery JS -->
        <script src="js/jquery.js"></script>

        <script>
        $(document).ready(function(){
			
			/* Handle the event when the form with security is submitted */
            $("#submitWithoutSecurity").click(function(){
				if(!$('#submitWithSecurity').hasClass('disabled')){
					var login = $("#loginWithoutSecurity").val();
					var pass = $("#passwordWithoutSecurity").val();
					var dataString = 'login='+ login + '&pass='+ pass;
					if(login == '' || pass == '')
					{
						$("#displayWithoutSecurity").html("<h3 style=\"text-align:center;\">Please fill all fields</h3>");
					}
					else
					{
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
					return false;
				} else {
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
						$("#displayWithSecurity").html("<h3 style=\"text-align:center;\">Please fill all fields</h3>");
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
			$('#submitDictionaryAttack').click(function(){
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
			});
        });
        </script>

    </body>

</html>