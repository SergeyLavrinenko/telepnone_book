<?php 
	include('connection.php');

	$name_field = array(
							"lname" => array("l_id", "lname", "Фамилия"),
							"fname" => array("f_id", "fname", "Имя"),
							"mname" => array("m_id", "mname", "Отчество"),
							"streets" => array("s_id", "s_name", "Улица"),
							);


	$cur_table = "";
	if(array_key_exists('table', $_GET)){
		$cur_table = $_GET["table"];
		$style = $style."<style>
    						#but-".$_GET["table"]."{
								background-color: #4ad5d4;
  								border: solid 3px #a52a2a;
							}
    					 </style>";
	}
	else{
		$style = $style."<style>
    						#but-lname{
								background-color: #4ad5d4;
  								border: solid 3px #a52a2a;
							}
    					 </style>";
		$cur_table = "lname";
	}



	$sql = 'select * from '.$cur_table.' order by 2;';
	$res = (pg_query($dbconn, $sql));

	$arr = pg_fetch_all($res);

	$resMain = "";
	if($arr == NULL){
		$resMain = $resMain."<tr></tr>";
	}
	else{
		$resMain = $resMain."<tr><th>".$name_field[$cur_table][2]."</th><th></th></tr>";
		foreach ($arr as $i => $value) {
			$resMain = $resMain."<tr> <form action='updateData.php' method='post'>";

			$resMain = $resMain."<td id='data-".$arr[$i][$name_field[$cur_table][0]]."''>"."
									<div class='hidden' id='input-".$arr[$i][$name_field[$cur_table][0]]."'>
										<input type='text' name='data' value='".trim($arr[$i][$name_field[$cur_table][1]], ' ')."'>
									</div>
									<div id='text-".$arr[$i][$name_field[$cur_table][0]]."'>
										".$arr[$i][$name_field[$cur_table][1]]."
									</div>
								</td>";

			$resMain = $resMain."<td class='edit-td' id='edit-but-".$arr[$i][$name_field[$cur_table][0]]."'>
									<input type='hidden' name='update_id' value='".$arr[$i][$name_field[$cur_table][0]]."'>
									<input type='hidden' name='table' value='".$cur_table."'>
									<a onclick=hide_insert(".$arr[$i][$name_field[$cur_table][0]].")><img id='edit-butt-".$arr[$i][$name_field[$cur_table][0]]."' class='edit-img' src='edit.png' alt=''></a>
									<button id='save-but-".$arr[$i][$name_field[$cur_table][0]]."' type='submit' class='save_but hidden'><b>✓</b> </button>
								</td>";

			$resMain = $resMain."</form></tr>";
		}
	}



?>

<!DOCTYPE html>
<html lang='ru'>



<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
	 <link rel="stylesheet" href="editTable.css">
	 <link rel="stylesheet" href="head.css">
	 <script src="jquery-3.6.1.js"></script>
	 <script src="jquery.maskedinput.min.js"></script>
	 <script src="editTable.js"></script>
    <title>Редактирование таблиц</title>
    <?php echo $style;?>
    
</head>

<body>
	<div class="head-box">
		<h2>Редактирование таблиц</h2>
	</div>

	<table class="main-table">
		<tr>
			<td class="menu-box-td">
				<div class="menu-box">
					<ul>
						<li><a class="button-menu" id="main-button-menu" href="index.php" id="but-lname">Главная</a></li>

						<li><a class="button-menu" href="editTable.php?table=lname" id="but-lname">Таблица фамилий</a></li>
						<li><a class="button-menu" href="editTable.php?table=fname" id="but-fname">Таблица имен</a></li>
						<li><a class="button-menu" href="editTable.php?table=mname" id="but-mname">Таблица отчеств</a></li>
						<li><a class="button-menu" href="editTable.php?table=streets" id="but-streets">Таблица улиц</a></li>
					</ul>
				</div>
			</td>
			<td>
				<table class="data-table">
					<?php echo $resMain;?>
				</table>
			</td>
		</tr>
	</table>

</body>
</html>