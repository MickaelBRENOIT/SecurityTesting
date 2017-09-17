$(document).ready(function(){

    /* Used to display the slides according to the plugin fullPage.js */
    $('#fullpage').fullpage();
    $("#display-captcha").hide();
	
	
	var i=0;
	$(".fp-tableCell:has(.mysection)").css("vertical-align", "inherit");

    /* If we click on a dropdown list, we display his content (radio buttons or checkboxes) */
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

    /* If we do something on the prevent dictionary attack checkbox, this function is called */
    $('#cb-dic').change(function() {
        /* If checked, we add security to our password */
        if($(this).is(":checked")){
            //$("#display-captcha").css("visibility", "visible");
            $("#display-captcha").show();
            $("#passwordWithoutSecurity").addClass("protected");
            checkPasswordValid($("#passwordWithoutSecurity"));
            $("#labelPasswordWithoutSecurity").html("Password - 8 chars & 1 digit & 1 uppercase & 1 lowercase min");
        }
        /* Otherwise we removed the protection */
        else{
            //$("#display-captcha").css("visibility", "hidden");
            $("#display-captcha").hide();
            $("#passwordWithoutSecurity").removeClass("protected");
            $("#passwordWithoutSecurity").parent().removeClass("has-error");
            $("#submitWithoutSecurity").removeClass("disabled");
            $("#labelPasswordWithoutSecurity").html("Password");
        }
    });
    
    
    /* Handle the event when writting the password */
    $('#passwordWithoutSecurity').keyup(function(){
        checkPasswordValid($(this));
    });
    
    /* we checked if the password is valid, namely if the regex is respected or not. Green = good, Red = Not good enough */
    function checkPasswordValid(el){
        if($(el).hasClass("protected")){
            var inputVal = $(el).val();
            /* We want a password which has 8 characters minimum, a digit, a lowercase and an uppercase */
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

    /* clear cookies, div error and reset the form */
    $('#clear').click(function(){

        if (!!$.cookie('username')) {
            $.removeCookie('username', { path: '/' });
        }

        if (!!$.cookie('password')) {
            $.removeCookie('password', { path: '/' });
        }

        $("#display-errors").html("");
        $("#formWithoutSecurity")[0].reset();
    });

});

/* Called when the form is submitted */
function submitCheck(){

    /* If the include attack radio button is checked */
	if($("#rb-include").is(":checked")){
        /* We look now if the prevent checkbox is checked. If it is, we send value 1 in order to prevent the attack. Otherwise 0 is send. */
		if($("#cb-inc").is(":checked"))
			window.location = "?file=./includeattack/includeattack1.php&prevent=1";
		else
			window.location = "?file=./includeattack/includeattack1.php&prevent=0";
		return false;
	}
	
    /* Form is not submitted is the button is not enabled */
    if($("#submitWithoutSecurity").hasClass("disabled"))
        return false;
    
    /* if the dictionary attack radio button is checked */
    if($("#rb-dictionary").is(":checked") && !$("#cb-dic").is(":checked")){
        /* we stored the login in a var */
        var login = $("#loginWithoutSecurity").val();
        var dataString = 'login='+ login;
        /* if there is no login, we display an error cause we need a login at least */
        if(login == '')
        {
            $("#display-errors").html("Need a login at least");
            return false;
        }
        else
        {
            /* we send the login to our dictionary attack sctript, he will check if this login has a weak password
               In this time of the research we display a nice loader to notice the user something is processing. */
            $("#display-loader").addClass("loader");
            $.ajax({
                type: "POST",
                url: "dictionaryattack/dictionary.php",
                data: dataString,
                cache: false,
                success: function(result){

                    /* If we found a result, so the password was cracked. We delete the loader and we display
                        all the informations about the person who got hacked. */
                    $("#display-loader").removeClass();
                    result = result.split("&*###*&");
                    var data = result[0];
                    var name = result[1];
                    var pass = result[2];
                    $("#display-errors").html(data);
                    $("#loginWithoutSecurity").val(name);
                    $("#passwordWithoutSecurity").val(pass);
                    $("#rb-none").attr("checked", "checked");

                    /* 2 seconds later we submt the form to simulate a connection and we display the accounts of the person. */
                    setTimeout(function(){
                        $("#formWithoutSecurity").submit();
                    }, 2000);
                },
                error: function(xhr, textStatus, errorThrown){
                   $("#display-loader").removeClass();
                }
            });

            return false;
        }
    }
    /* Otherwise we normally submit the form */ 
    else {
        var login = $("#loginWithoutSecurity").val();
        var pass = $("#passwordWithoutSecurity").val();
        var prevent_sql = "no";

        /* we checked if the checkox about prevent sql injection is checked or not */
        if($("#cb-sql").is(':checked')){
            prevent_sql = "yes";
        }
        
        var dataString = 'login='+ login + '&pass='+ pass + '&sql='+ prevent_sql;
        if(login == '' || pass == '')
        {
            $("#display-errors").html("Please fill all fields");
            return false;
        }
        else
        {
            return true;
        }
    }				
}