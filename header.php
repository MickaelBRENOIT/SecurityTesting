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
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/site.css">
    	<link href="/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />
        
        
        
        <!-- JQuery JS -->
        <script src="js/jquery.js"></script>

        <!-- JQuery cookie JS -->
        <script src="js/jquery.cookie.js"></script>
    </head>

    <body>
    <div class="navigationbar">
        <a class="pull-left icon" href="../index.php" title="Index"><i class="mdi mdi-bank"></i></a>
    <?php if(isset($_SESSION["connected"])){?>
        <a class="pull-right icon logout" href="./logout.php" title="Logout"><i class="mdi mdi-power"></i></a>
    <?php } ?>
    </div>