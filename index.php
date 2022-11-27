<?php 
	include('connection.php');

	$name_field = array(
							"lname" => "Фамилия",
							"fname" => "Имя",
							"mname" => "Отчество",
							"s_name" => "Улица",
							"building" => "Дом",
							"apart" => "Квартира",
							"phone_number" => "Номер телефона");


	if (array_key_exists('chkWide', $_GET)){
		$where = "WHERE lname LIKE '%".$_GET["lname"]."%' AND fname LIKE'%".$_GET["fname"]."%' AND mname LIKE'%".$_GET["mname"]."%' AND s_name LIKE'%".$_GET["s_name"]."%' AND building LIKE'%".$_GET["building"]."%' AND apart LIKE'%".$_GET["apart"]."%' AND phone_number LIKE'%".$_GET["phone_number"]."' ";
	}
	else{
		if($_GET["search_field"] != ""){
			$where = "where ".$_GET["search_field"]." ='".$_GET["search"]."' ";
			$cur_values[$_GET["search_field"]] = $_GET["search"];
			$cur_search = $_GET["search"];
		}
		else{
			$where = "";
			$cur_search = "";
		}
	}


	if (array_key_exists('sort', $_GET)){
		$ordered = " ORDER BY ".$_GET["sort"];
	}
	else{
		$ordered = "";
	}
	$sql = 'select id, l.lname, f.fname, m.mname, s.s_name, building, apart, phone_number from main
			join fname as f on f.f_id = fname_fk
			join lname as l on l.l_id = lname_fk
			join mname as m on m.m_id = mname_fk
			join streets as s on s.s_id = street_fk '.$where.$ordered.';';
	$res = (pg_query($dbconn, $sql));

	$arr = pg_fetch_all($res);

	$resMain = "";
	if($arr == NULL){
		$resMain = $resMain."<tr></tr>";
	}
	else{
		foreach ($arr as $i => $value) {
			$resMain = $resMain."<tr>";
			$resMain = $resMain."<td>".$arr[$i]["lname"]."</td>";
			$resMain = $resMain."<td>".$arr[$i]["fname"]."</td>";
			$resMain = $resMain."<td>".$arr[$i]["mname"]."</td>";
			$resMain = $resMain."<td>".$arr[$i]["s_name"]."</td>";
			$resMain = $resMain."<td>".$arr[$i]["building"]."</td>";
			$resMain = $resMain."<td>".$arr[$i]["apart"]."</td>";
			$resMain = $resMain."<td>".$arr[$i]["phone_number"]."</td>";
			$resMain = $resMain."<td><form action='delete_item.php' method='post'>
											<input type='hidden' name='delete_id' value='".$arr[$i]["id"]."'>
											<button type='submit' class='delete_but'>╳ </button>
										</form></td>";
			$resMain = $resMain."</tr>";
		}
	}

	$formSortBeginUp = "<form action='index.php' method='get'>
						<input type='hidden' name='sort' value='";
	$formSortEndUp = "'>
						<button type='submit' class='sort_but_up'> </button>
						</form>";

	$formSortBeginDown = "<form action='index.php' method='get'>
						<input type='hidden' name='sort' value='";
	$formSortEndDown = "'>
						<button type='submit' class='sort_but_down'> </button>
						</form>";
?>
<!DOCTYPE html>
<html lang='ru'>



<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
	 <link rel="stylesheet" href="index.css">
	 <script src="jquery-3.6.1.js"></script>
	 <script src="jquery.maskedinput.min.js"></script>
	 <script src="index.js"></script>
    <title>Добро пожаловать!</title>
    
</head>

<body>
	<div class="main_head">

		<div class="main-search">
			<div id="search_box">
				<form id="search_form" action='index.php' method='get'>
					<span id="main_search_span">Поле для поиска: </span>
					<select id="search_field" name="search_field" size="1">
						<?php
						$res_select = "";
						foreach ($name_field as $i => $val){
							$sel = "";
							if($i == $_GET["search_field"]){
								$sel = "selected";
							}
							$res_select = $res_select."<option ".$sel." value='".$i."'>".$val."</option>";
						}
						echo $res_select;
						?>
		  	 		</select>
					<input id="search" type='search' name='search' value='<?php echo $cur_search; ?>'>
					<button id="search_btn" type='submit' class='search_but'>Найти</button>
					<span id="wide_search_field">Расширенный поиск </span><input form="wide_form" name="chkWide" type="checkbox" id="chkWideSearch" value="true">
				</form>
			</div>


			<div id="wide_search_box" class="hidden">
				<form action='index.php' method='get' id="wide_form">
					<table id="wide_search_table">
						<tr>
							<td> Фамилия</td>
							<td>
								<input type="text" class="form-control autocomplete" autocomplete="off" list="lname" placeholder="Введите фамилию" name="lname" class="wide_search_fields">
								<input type="hidden" name="lnameId" class="wide_search_fields"/>
								<datalist id="lname">
										<?php
											$res_oprions = "";
											$sql = "select * from lname;";
											$res = (pg_query($dbconn, $sql));
											$arr = pg_fetch_all($res);
											foreach ($arr as $i => $value) {
												$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["lname"], " ")."'>";
											}
											echo $res_oprions;
										 ?>
								</datalist>
							</td>
						</tr>
						<tr>
							<td> Имя</td>
							<td>
								<input type="text" class="form-control autocomplete" autocomplete="off" list="fname" placeholder="Введите имя" name="fname" class="wide_search_fields">
								<input type="hidden" name="fnameId" class="wide_search_fields"/>
								<datalist id="fname">
										<?php
											$res_oprions = "";
											$sql = "select * from fname;";
											$res = (pg_query($dbconn, $sql));
											$arr = pg_fetch_all($res);
											foreach ($arr as $i => $value) {
												$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["fname"], " ")."'>";
											}
											echo $res_oprions;
										 ?>
								</datalist>
							</td>
						</tr>
						<tr>
							<td> Отчество</td>
							<td>
								<input type="text" class="form-control autocomplete" autocomplete="off" list="mname" placeholder="Введите отчество" name="mname" class="wide_search_fields">
								<input type="hidden" name="mnameId" class="wide_search_fields"/>
								<datalist id="mname">
										<?php
											$res_oprions = "";
											$sql = "select * from mname;";
											$res = (pg_query($dbconn, $sql));
											$arr = pg_fetch_all($res);
											foreach ($arr as $i => $value) {
												$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["mname"], " ")."'>";
											}
											echo $res_oprions;
										 ?>
								</datalist>
							</td>
						</tr>
						<tr>
							<td> Улица</td>
							<td>
								<input type="text" class="form-control autocomplete" autocomplete="off" list="s_name" placeholder="Введите улицу" name="s_name">
								<input type="hidden" name="s_nameId" />
								<datalist id="s_name">
										<?php
											$res_oprions = "";
											$sql = "select * from streets;";
											$res = (pg_query($dbconn, $sql));
											$arr = pg_fetch_all($res);
											foreach ($arr as $i => $value) {
												$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["s_name"], " ")."'>";
											}
											echo $res_oprions;
										 ?>
								</datalist>
							</td>
						</tr>
						<tr>
							<td> Дом</td>
							<td> <input type='text' placeholder="Введите номер дома" autocomplete="off" name='building' value=''></td>
						</tr>
						<tr>
							<td> Квартира</td>
							<td> <input type='text' placeholder="Введите номер квартиры" autocomplete="off" name='apart' value=''></td>
						</tr>
						<tr>
							<td> Номер телефона</td>
							<td><input type="text" placeholder="Введите телефон" autocomplete="off" class="phone_mask" name='phone_number'> </td>
								 <script>
							        $(".phone_mask").mask("+9(999)999-99-99");
							    </script>
						</tr>
						<tr>
							<td> <button type='submit' class='add_but'>Найти </button></td>
						</tr>
					</table>
				</form>
			</div>
		</div>



	<div>
		<a onclick='hide_insert()'>Добавление новой записи</a>
		<div class ="hidden insert_block">
			<form action='add_item.php' method='post'>
				<table id="insert_table">
					<tr>
						<td> Фамилия</td>
						<td>
							<input type="text" class="form-control autocomplete" autocomplete="off" list="lname" placeholder="Введите фамилию" name="lname">
							<input type="hidden" name="lnameId" />
							<datalist id="lname">
									<?php
										$res_oprions = "";
										$sql = "select * from lname;";
										$res = (pg_query($dbconn, $sql));
										$arr = pg_fetch_all($res);
										foreach ($arr as $i => $value) {
											$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["lname"], " ")."'>";
										}
										echo $res_oprions;
									 ?>
							</datalist>
						</td>
					</tr>
					<tr>
						<td> Имя</td>
						<td>
							<input type="text" class="form-control autocomplete" autocomplete="off" list="fname" placeholder="Введите имя" name="fname">
							<input type="hidden" name="fnameId" />
							<datalist id="fname">
									<?php
										$res_oprions = "";
										$sql = "select * from fname;";
										$res = (pg_query($dbconn, $sql));
										$arr = pg_fetch_all($res);
										foreach ($arr as $i => $value) {
											$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["fname"], " ")."'>";
										}
										echo $res_oprions;
									 ?>
							</datalist>
						</td>
					</tr>
					<tr>
						<td> Отчество</td>
						<td>
							<input type="text" class="form-control autocomplete" autocomplete="off" list="mname" placeholder="Введите отчество" name="mname">
							<input type="hidden" name="mnameId" />
							<datalist id="mname">
									<?php
										$res_oprions = "";
										$sql = "select * from mname;";
										$res = (pg_query($dbconn, $sql));
										$arr = pg_fetch_all($res);
										foreach ($arr as $i => $value) {
											$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["mname"], " ")."'>";
										}
										echo $res_oprions;
									 ?>
							</datalist>
						</td>
					</tr>
					<tr>
						<td> Улица</td>
						<td>
							<input type="text" class="form-control autocomplete" autocomplete="off" list="s_name" placeholder="Введите улицу" name="s_name">
							<input type="hidden" name="s_nameId" />
							<datalist id="s_name">
									<?php
										$res_oprions = "";
										$sql = "select * from streets;";
										$res = (pg_query($dbconn, $sql));
										$arr = pg_fetch_all($res);
										foreach ($arr as $i => $value) {
											$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["s_name"], " ")."'>";
										}
										echo $res_oprions;
									 ?>
							</datalist>
						</td>
					</tr>
					<tr>
						<td> Дом</td>
						<td> <input type='text' placeholder="Введите номер дома" autocomplete="off" name='building' value=''></td>
					</tr>
					<tr>
						<td> Квартира</td>
						<td> <input type='text' placeholder="Введите номер квартиры" autocomplete="off" name='apart' value=''></td>
					</tr>
					<tr>
						<td> Номер телефона</td>
						<td><input type="text" placeholder="Введите телефон" autocomplete="off" class="phone_mask" name='phone_number'> </td>
							 <script>
						        $(".phone_mask").mask("+9(999)999-99-99");
						    </script>
					</tr>
					<tr>
						<td> <button type='submit' class='add_but'>Добавить </button></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	</div>

	 <?php
				if(array_key_exists('search_field', $_GET) != "" || array_key_exists('chkWide', $_GET)){
					echo "<h3> Показаны результаты с удовлетворяющие условию: ".$name_field[$_GET["search_field"]]." — ".$_GET["search"]." </h3> <a href='index.php'>Показать все записи</a>";
				}
			?>

	<table id="mainTable">
		<tr>
			<th><div class="table_head_th"><span class="table_head_text">Фамилия </span><span class="table_head_buttons"><?php echo $formSortBeginUp."lname".$formSortEndUp; echo $formSortBeginDown."lname DESC".$formSortEndDown; ?></span></div></th>
			<th><div class="table_head_th"><span class="table_head_text">Имя </span><span class="table_head_buttons"><?php echo $formSortBeginUp."fname".$formSortEndUp; echo $formSortBeginDown."fname DESC".$formSortEndDown; ?></span></div></th>
			<th><div class="table_head_th"><span class="table_head_text">Отчество </span><span class="table_head_buttons"><?php echo $formSortBeginUp."mname".$formSortEndUp; echo $formSortBeginDown."mname DESC".$formSortEndDown;?></span></div></th>
			<th><div class="table_head_th"><div class="table_head_text">Улица </div><div class="table_head_buttons"><?php echo $formSortBeginUp."s_name".$formSortEndUp; echo $formSortBeginDown."s_name DESC".$formSortEndDown;?></div></div></th>
			<th><div class="table_head_th"><div class="table_head_text">Дом </div><div class="table_head_buttons"><?php echo $formSortBeginUp."building".$formSortEndUp; echo $formSortBeginDown."building DESC".$formSortEndDown;?></div></div></th>
			<th><div class="table_head_th"><div class="table_head_text">Квартира </div><div class="table_head_buttons"><?php echo $formSortBeginUp."apart".$formSortEndUp; echo $formSortBeginDown."apart DESC".$formSortEndDown;?></div></div></th>
			<th><div class="table_head_th"><div class="table_head_text">Номер телефона </div><div class="table_head_buttons"><?php echo $formSortBeginUp."phone_number".$formSortEndUp; echo $formSortBeginDown."phone_number DESC".$formSortEndDown;?></div></div></th>
		</tr>
		<?php echo $resMain; ?>
	</table>

</body>
</html>

