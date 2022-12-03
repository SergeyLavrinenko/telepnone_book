<?php
	include('connection.php');


	if (!empty($_POST["lname"])){
		$sql = "select * from lname where lname='".$_POST["lname"]."';";
		$res = (pg_query($dbconn, $sql));
		$arr = pg_fetch_all($res);
		if($arr == NULL){
			$sql = "insert into lname(lname) values ('".$_POST["lname"]."') RETURNING l_id;";
			$res = (pg_query($dbconn, $sql));
			$lname_id = pg_fetch_row($res)[0];
		}
		else{
			$lname_id = $arr[0]["l_id"];
		}

		$sql = "select * from fname where fname='".$_POST["fname"]."';";
		$res = (pg_query($dbconn, $sql));
		$arr = pg_fetch_all($res);
		if($arr == NULL){
			$sql = "insert into fname(fname) values ('".$_POST["fname"]."') RETURNING f_id;";
			$res = (pg_query($dbconn, $sql));
			$fname_id = pg_fetch_row($res)[0];
		}
		else{
			$fname_id = $arr[0]["f_id"];
		}

		$sql = "select * from mname where mname='".$_POST["mname"]."';";
		$res = (pg_query($dbconn, $sql));
		$arr = pg_fetch_all($res);
		if($arr == NULL){
			$sql = "insert into mname(mname) values ('".$_POST["mname"]."') RETURNING m_id;";
			$res = (pg_query($dbconn, $sql));
			$mname_id = pg_fetch_row($res)[0];
		}
		else{
			$mname_id = $arr[0]["m_id"];
		}

		$sql = "select * from streets where s_name='".$_POST["s_name"]."';";
		$res = (pg_query($dbconn, $sql));
		$arr = pg_fetch_all($res);
		if($arr == NULL){
			$sql = "insert into streets(s_name) values ('".$_POST["s_name"]."') RETURNING s_id;";
			$res = (pg_query($dbconn, $sql));
			$street_id = pg_fetch_row($res)[0];
		}
		else{
			$street_id = $arr[0]["s_id"];
		}

		$sql = "update main set lname_fk=".$lname_id.", fname_fk=".$fname_id.", mname_fk=".$mname_id.", street_fk=".$street_id.", building='".$_POST["building"]."', apart='".$_POST["apart"]."', phone_number='".$_POST["phone_number"]."' where id = ".$_POST["id"].";";
		$res = (pg_query($dbconn, $sql));
		$arr = pg_fetch_all($res);


	}
	header('Location: http://'.$_SERVER['HTTP_HOST']."/index.php");


?>