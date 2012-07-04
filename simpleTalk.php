<?php 
    session_start();
    if(isset($_SESSION['uname'])){
        $session = $_SESSION['uname'];
        $logform = "<input type = \"button\" class=\"btn\" id=\"signin\" value =\"Sign out\"/>";
    }else{
        $session = "Guest";
        $logform .= "<input type=\"text\" class=\"input-small\" placeholder=\"Email\" name=\"email\">
                    <input type=\"password\" class=\"input-small\" placeholder=\"Password\" name=\"pword\">&nbsp;";
        $logform .= "<label class=\"checkbox\" for=\"remember_me\">
                        <input type=\"checkbox\" id=\"remember_me\" name=\"remember_me\"> Remember me
                    </label>&nbsp;";
        $logform .= "<input type = \"button\" class=\"btn\" id=\"signin\" value =\"Sign in\"/>";
        $logform .= "<input type=\"button\" class=\"btn\" id=\"signup\" value=\"Sign up\" />";
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simple Talk</title>	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen, projection, handheld" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" media="screen, projection, handheld" />  
	<link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.css" media="screen, projection, handheld" />  
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/colorpicker/assets/skins/sam/colorpicker.css"/>
                
	<script src="js/jquery-1.3.2.min.js"></script>
	<script src="js/jquery-ui-1.7.3.custom.min.js" type="text/javascript"></script> 
	<script src="js/timeago.js" type="text/javascript"></script> 
        <script src="http://yui.yahooapis.com/2.9.0/build/utilities/utilities.js" ></script>
        <script src="http://yui.yahooapis.com/2.9.0/build/slider/slider-min.js" ></script>
        <script src="http://yui.yahooapis.com/2.9.0/build/colorpicker/colorpicker-min.js" ></script>
        <script type="text/javascript" src="js/slimScroll.js"></script>
        <script type="text/javascript" src="js/talk.js"></script> 
</head>
    <body class="yui3-skin-night">
    <div class="container">
        <div class="row">
            <div class="span2">
            <h1>Simple Talk</h1>
            </div>

        </div>
        <form class="well form-inline">
            <?php echo $logform; ?>
        </form>

        <div class="container">

            <div id="wrapper" class="alert alert-info" style="margin: 10px 15px;width:35%;height:auto">  
                <div id="menu" >   
                    <p class="logout"><a class="close" href="#">&times;</a></p>  
                    <p class="welcome">Welcome, <b id="session_user"><?php echo $session; ?></b></p>  

                    <div style="clear:both"></div>  
                </div>  

                <div id="chatbox" style="text-align:left;margin:0 auto; margin-bottom:25px;padding:10px;background:#fff;height:270px;width:410px;border:1px solid #ACD8F0;overflow:auto;">
                    <ul id="chatbox1" style='list-style:none;margin:0;padding:0;'></ul>
                </div>  

                    <div class="tabbable" style="margin-bottom:10px;">
                        <ul class="nav nav-tabs">
                            <li class="pane_font active"><a href="#pane1" data-toggle="tab" id="a_font">Text Font</a></li>
                            <li class="pane_emoticons"><a href="#pane2" data-toggle="tab" id="a_emoticons">Emoticons</a></li>
                        </ul>			

                        <!--Tabs-->
                        <div class="tab-content" style="margin-top:-5px;">						
                            <!--Fonts-->
                            <div id="pane1" class="tab-pane active">
                                <div class="btn-group" style="float:left; margin:0 0 10px 15px">
                                        <a class="btn btn-primary" href="#">
                                                Font
                                        </a>
                                        <a class="btn btn-primary dropdown-toggle" id="font-family"  href="#">
                                                <span class="caret"></span>
                                        </a>
                                        <ul class="font-family dropdown-menu">
                                                <li style = "font-family:Arial">
                                                        <a href="#" id="arial">
                                                                Arial
                                                        </a>
                                                </li>
                                                <li style = "font-family:Calibri">
                                                        <a href="#" id="calibri">
                                                                Calibri
                                                        </a>
                                                </li>
                                                <li style = "font-family:Courier">	
                                                        <a href="#" id="courier">
                                                                Courier
                                                        </a>
                                                </li>
                                                <li style = "font-family:Times New Roman">
                                                        <a href="#" id="timesNewRoman">
                                                                Times New Roman
                                                        </a>
                                                </li>
                                                <li style = "font-family:Verdana">
                                                        <a href="#" id="verdana">
                                                                Verdana
                                                        </a>
                                                </li>
                                        </ul>
                                </div>
					
                                <div class="btn-group" style="float:left; margin:0 0 10px 15px">
                                        <a class="btn btn-primary" href="#">
                                                <div id="color-picked" style="width:10px; height:10px; background-color:#000000; border:thin solid #FFFFFF; margin-top:3px; margin-bottom:3px"></div>
                                        </a>

                                        <a class="btn btn-primary dropdown-toggle" id="colorpicker-drop" style ="cursor:pointer">
                                                <span class="caret"></span>
                                        </a>

                                        <div id="colorpicker" style="display:none;top:100px;"></div>
                                </div>
					
					<div class="btn-group" style="float:left; margin:0 0 10px 15px">
						<a class="btn btn-primary" href="#" id="sz-picked">
							10
						</a>
						<a class="btn btn-primary dropdown-toggle" id="font-size" href="#">
							<span class="caret"></span>
						</a>
						<ul class="font-size dropdown-menu">
							<li><a href="#" id="sz10">10</a></li>
							<li><a href="#" id="sz12">12</a></li>
							<li><a href="#" id="sz16">16</a></li>
							<li><a href="#" id="sz18">18</a></li>
							<li><a href="#" id="sz24">24</a></li>
						</ul>
					</div>
					
					<a class="btn btn-primary" href="#" style="margin-left:15px" id="stBold">
						<span style="font-weight:bold">B</span>
					</a>
					<a class="btn btn-primary" href="#" id="stItalic">
						<span style="font-style:italic">I</span>
					</a>
					<a class="btn btn-primary" href="#" id="stUnderline">
						<span style="text-decoration:underline">U</span>
					</a>
                        </div>	

                        <!--Emoticons-->
                        <div id="pane2" class="tab-pane">
                                <div id= "emoticons_wrapper" style="width:100%; height: 80px;text-align:center;margin:0 auto;overflow:auto;">
                                </div>
                        </div>

                        <form name="message" action="">                         
                                <i class="icon-pencil"></i><textarea name="usermsg" id="usermsg" onkeydown="if (event.keyCode == 13) document.getElementById('submitmsg').click();" size="80" style="max-width:80%;width:80%;max-height:50px;height:50px;"></textarea>
                                &nbsp;<input name="submitmsg" type="button"  id="submitmsg" value="Say It!" />  
                        </form> 
            </div> 
        </div>
    </div>
    </body>
</html>
