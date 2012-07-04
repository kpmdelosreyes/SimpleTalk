<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simple Talk</title>

        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen, projection, handheld" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" media="screen, projection, handheld" />
  
        <script src="js/jquery-1.3.2.min.js"></script>
        <script src="js/jquery-ui-1.7.3.custom.min.js" type="text/javascript"></script> 
        <script type="text/javascript">

$(document).ready(function(){
   
//   $("#user_name, #password").keyup(function(){
//       
//       var user_name = $("#user_name").val(), password = $("#password").val();  
//       if(user_name.length >= 6 ){
//           $("span#usr_verify").css({ "background-image": "url('img/yes.png')" });
//       }
//   });
   register_.submitNewUser();
   
});

var register_ = {
    submitNewUser : function()
    {
        $("#register").click(function(){
            var fFname = $("#fFname").val(), fLname = $("#fLname").val(), user_name = $("#user_name").val(), password = $("#password").val();  


            $.ajax({
               url : "index.php",
               type: "POST",
               dataType : "html",
               data : {action : 'registerMe', fFname : fFname, fLname : fLname, user_name : user_name, password : password},
               success : function(){
                   window.location.href = "simpleTalk.php";
               }
            });
        });
    },
    
    isValidEmailAddress : function(emailAddress)
    {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }
}


</script> 
</head>
    <body>
        
        <div class="container">
            <div class="row">
                <div class="span4">
                <h1>Register in SimpleTalk</h1>
                </div>
            </div>
			
            <form class="well form-vertical" id="simpleTalkRegForm">
                <label class="control-label" for="fFname"><p>First Name</p></label>
                <div class="controls">
                    <input type="text" id="fFname" name="fFname" value="" class="input-xlarge" /><span id="fname_verify" class="verify"></span>
                </div>
                <label class="control-label" for="fLname">Last Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="fLname" name="fLname"  value="" /><span id="fLname_verify" class="verify"></span>
                </div>
                <label class="control-label" for="fUname">Username</label>
                <div class="controls">
                     <input type="text" id="user_name" name="user_name" value="" class="input-xlarge" /><span id="usr_verify" class="verify"></span>
                </div>
                <label class="control-label" for="fPword">Password</label>
                <div class="controls">
                    <input type="password" class="input-xlarge" id="password" name="fPword" value=""/><span id="password_verify" class="verify"></span>
                </div>
                <label class="control-label" for="con_password">Confirm Password</label>
                <div class="controls">
                    <input type="password" id="con_password" name="con_password" class="input-xlarge" value="" /><span id="confrimpwd_verify" class="verify"></span>
                </div>
                <input class="btn btn-primary" type="button" id="register" value="Register"/>
                <input class="btn btn-danger" type="submit" id="cancel" value="Cancel"/>
                    
            </form>
			<div class="formResult"></div>
        </div>
       
    </body>
</html>
