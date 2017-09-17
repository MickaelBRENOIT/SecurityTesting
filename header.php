<?php session_start();?> 
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
        <?php 
        $path = file_exists($_SERVER["DOCUMENT_ROOT"] . "/securitytesting/css/site.css")?"/securitytesting":"";
		 ?>
        <!-- localhost -->
        <link rel="stylesheet" href="<?php echo $path; ?>/css/bootstrap.min.css" media="all" type="text/css" >
        <link rel="stylesheet" href="<?php echo $path; ?>/css/site.css" media="all" type="text/css" >
    	<link rel="stylesheet" href="<?php echo $path; ?>/css/materialdesignicons.min.css" media="all" type="text/css" />
        <link rel="stylesheet" href="<?php echo $path; ?>/css/jquery.fullpage.min.css" media="all" type="text/css" />
        
        <!-- JQuery JS -->
        <script src="<?php echo $path; ?>/js/jquery.js"></script>

        <!-- JQuery cookie JS -->
        <script src="<?php echo $path; ?>/js/jquery.cookie.js"></script>

        <!-- fullPage JS -->
        <script src="<?php echo $path; ?>/js/jquery.fullpage.min.js"></script>
        
        
        
    </head>

    <body>
    
    <!-- Navigation bar with the logo of our website and display of the button logout to the right if the user is connected -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="<?php echo $path; ?>/index.php"><span class="glyphicon glyphicon-piggy-bank"></span> MMA Bank & Co</a>
            </div>
            <ul class="nav navbar-nav">
                <!-- Items need to be here if needed -->
            </ul>

        <?php if(isset($_SESSION["connected"])){?>
            <ul class="nav navbar-nav navbar-right">            
                <li><a href="<?php echo $path; ?>/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        <?php } ?>
        </div>
    </nav>