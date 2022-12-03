<?php 
   $host = "localhost";
   $port = "5432";
   $dbname = "telephone";
   $user = "postgres";
   $password = ""; 
   $connection_string = "host={$host} port={$port} dbname={$dbname}   
                              user={$user} password={$password} ";
   $dbconn = pg_connect($connection_string);    
	if (!$dbconn) {
		echo "Произошла ошибка.\n";
		exit;
	}   
?>