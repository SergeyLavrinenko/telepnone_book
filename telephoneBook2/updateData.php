<?php
	include('connection.php');

	$name_field = array(
							"lname" => array("l_id", "lname"),
							"fname" => array("f_id", "fname"),
							"mname" => array("m_id", "mname"),
							"streets" => array("s_id", "s_name"),
							);

	if (array_key_exists('table', $_POST)){
		$cur_table = $_POST["table"];
		$sql = "update ".$cur_table." set ".$name_field[$cur_table][1]." = '".$_POST["data"]."' where ".$name_field[$cur_table][0]." =".$_POST["update_id"].";";
		echo $sql;
		$res = (pg_query($dbconn, $sql));
		$arr = pg_fetch_all($res);
	}

	header('Location: http://'.$_SERVER['HTTP_HOST']."/editTable.php?table=".$cur_table);

?>