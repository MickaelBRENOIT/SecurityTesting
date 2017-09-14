<?php include("../header.php"); ?>

        <div class="section  col-md-10 col-md-offset-1">
            <div class="row">                
                <div class="col-md-6">

                    <h2 style="text-align:center;">Insert Users</h2>
                    
                    <form id="insertUserWithSecurity" action="./processorInsertUser.php" method="post" onSubmit="return checkInsertUser();" enctype="multipart/form-data">
                          <div class="form-group">
                            <input type="text" class="form-control" id="loginWithSecurity" placeholder="Login" name="login">
                            <input type="password" class="form-control" id="passwordWithSecurity" placeholder="Password" name="pass">
                            <input type="file" name="file" id="fileWithSecurity">
                          </div>
                          <button type="submit" id="submitInsertUserWithSecurity" class="btn btn-block btn-success">Insert</button>
                    </form>
				</div>
                
                <div class="col-md-6">
                    
                    <h2 style="text-align:center;">Insert Accounts</h2>
                    
                    <form id="insertAccountWithSecurity" action="./processorInsertAccount.php" method="post" onSubmit="return checkInsertAccount();">
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
            
			
			
        });
		
		function checkInsertUser(){
			//if(!$('#submitWithSecurity').hasClass('disabled')){
			var login = $("#loginWithSecurity").val();
			var pass = $("#passwordWithSecurity").val();
			var filename = $("#fileWithSecurity").val();
			//var dataString = 'login='+ login + '&pass='+ pass;
			if(login == '' || pass == '')
			{
				$("#display").html("<h4 class='bg-warning message'>Please fill all fields</h4>");
				return false;
			}
			if(filename != ""){
				var ext = getExtension(filename);
				switch (ext.toLowerCase()) {
					case 'jpg':
					case 'gif':
					case 'bmp':
					case 'png':
						return true;
					default:
						$("#display").html("<h4 class='bg-warning message'>Please select a valid file (image)</h4>");
						return false;
				}
			}
			//etc
			return true;
		}
			
		function checkInsertAccount(){
			var owner = $("#accountOwner").val();
			var type = $("#accountType").val();
			var amount = $("#accountAmount").val();
			//var dataString = 'owner='+ owner + '&type='+ type + '&amount='+ amount;
			if(owner == '' || type == '' || amount == '')
			{
				$("#display").html("<h4 class=\"bg-warning\" style=\"text-align:center; padding: 30px 0 30px 0;\">Please fill all fields</h4>");
				return false;
			}
			return true;
		}
		
		function getExtension(filename) {
			var parts = filename.split('.');
			return parts[parts.length - 1];
		}
        </script>
<?php include("../footer.php"); ?>