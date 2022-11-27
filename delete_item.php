<?php
	include('connection.php');


	if (!empty($_POST["delete_id"])){
		$sql = "delete from main where id =".$_POST["delete_id"].";";
		$res = (pg_query($dbconn, $sql));
		$arr = pg_fetch_all($res);



	}
	header('Location: http://'.$_SERVER['HTTP_HOST']."/index.php");


?>