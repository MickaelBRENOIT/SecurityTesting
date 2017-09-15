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
        <link rel="stylesheet" href="http://127.0.0.1/securitytesting/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://127.0.0.1/securitytesting/css/site.css">
    	<link href="http://127.0.0.1/securitytesting/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />
        
        
        
        <!-- JQuery JS -->
        <script src="js/jquery.js"></script>

        <!-- JQuery cookie JS -->
        <script src="js/jquery.cookie.js"></script>
    </head>

    <body>
    <?php if(isset($_SESSION["connected"])){?>
    	<div class="row">
    		<a class="btn btn-danger pull-right" href="./logout.php">Logout</a>
        </div>
    <?php } ?>