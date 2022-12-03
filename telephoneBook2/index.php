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



	$lname_input1 = "<input value='";
	$lname_input2 = "' type='text' class='form-control autocomplete' autocomplete='off' list='lname' placeholder='Фамилия' name='lname' class='wide_search_fields'>
									<input type='hidden' name='lnameId' class='wide_search_fields'/>
									<datalist id='lname'>";
	$res_options = "";
	$sql = "select * from lname order by 2;";
	$res = (pg_query($dbconn, $sql));
	$arr = pg_fetch_all($res);
	foreach ($arr as $i => $value) {
		$res_options = $res_options."<option data-id='".$i."' value='".trim($arr[$i]["lname"], " ")."'>";
	}
	$lname_input2 = $lname_input2.$res_options."</datalist>";

	$fname_input1 = "<input value='";
	$fname_input2 = "' type='text' class='form-control autocomplete' autocomplete='off' list='fname' placeholder='Имя' name='fname' class='wide_search_fields'>
									<input type='hidden' name='fnameId' class='wide_search_fields'/>
									<datalist id='fname'>";
	$res_options = "";
	$sql = "select * from fname order by 2;";
	$res = (pg_query($dbconn, $sql));
	$arr = pg_fetch_all($res);
	foreach ($arr as $i => $value) {
		$res_options = $res_options."<option data-id='".$i."' value='".trim($arr[$i]["fname"], " ")."'>";
	}
	$fname_input2 = $fname_input2.$res_options."</datalist>";

	$mname_input1 = "<input  value='";
	$mname_input2 = "' type='text' class='form-control autocomplete' autocomplete='off' list='mname' placeholder='Отчество' name='mname' class='wide_search_fields'>
									<input type='hidden' name='mnameId' class='wide_search_fields'/>
									<datalist id='mname'>";
	$res_options = "";
	$sql = "select * from mname order by 2;";
	$res = (pg_query($dbconn, $sql));
	$arr = pg_fetch_all($res);
	foreach ($arr as $i => $value) {
		$res_options = $res_options."<option data-id='".$i."' value='".trim($arr[$i]["mname"], " ")."'>";
	}
	$mname_input2 = $mname_input2.$res_options."</datalist>";

	$streets_input1 = "<input  value='";
	$streets_input2 = "' type='text' class='form-control autocomplete' autocomplete='off' list='s_name' placeholder='Улица' name='s_name'>
									<input type='hidden' name='s_nameId' />
									<datalist id='s_name'>";
	$res_options = "";
	$sql = "select * from streets order by 2;";
	$res = (pg_query($dbconn, $sql));
	$arr = pg_fetch_all($res);
	foreach ($arr as $i => $value) {
		$res_options = $res_options."<option data-id='".$i."' value='".trim($arr[$i]["s_name"], " ")."'>";
	}
	$streets_input2 = $streets_input2.$res_options."</datalist>";

	$building_input1 = "<input value='";
	$building_input2 = "' type='text' placeholder='Дом' autocomplete='off' name='building' value=''>";
	$apart_input1 = "<input  value='";
	$apart_input2 = "' type='text' placeholder='Квартира' autocomplete='off' name='apart' value=''>";
	$phone_number_input1 = "<input  value='";
	$phone_number_input2 = "' type='text' placeholder='Телефон' autocomplete='off' class='phone_mask' name='phone_number'>";






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
			$resMain = $resMain."<tr><form action='updateMainData.php' method='post'>";
			$resMain = $resMain."<td><div class='hidden' id='input-lname-".$arr[$i]["id"]."'>".$lname_input1.trim($arr[$i]["lname"], ' ').$lname_input2."
									</div><div class='content_td-".$arr[$i]["id"]."'>".$arr[$i]["lname"]."</div></td>";
			$resMain = $resMain."<td><div class='hidden' id='input-fname-".$arr[$i]["id"]."'>".$fname_input1.trim($arr[$i]["fname"], ' ').$fname_input2."
									</div><div class='content_td-".$arr[$i]["id"]."'>".$arr[$i]["fname"]."</div></td>";
			$resMain = $resMain."<td><div class='hidden' id='input-mname-".$arr[$i]["id"]."'>".$mname_input1.trim($arr[$i]["mname"], ' ').$mname_input2."
									</div><div class='content_td-".$arr[$i]["id"]."'>".$arr[$i]["mname"]."</div></td>";
			$resMain = $resMain."<td><div class='hidden' id='input-streets-".$arr[$i]["id"]."'>".$streets_input1.trim($arr[$i]["s_name"], ' ').$streets_input2."
									</div><div class='content_td-".$arr[$i]["id"]."'>".$arr[$i]["s_name"]."</div></td>";
			$resMain = $resMain."<td><div class='hidden' id='input-building-".$arr[$i]["id"]."'>".$building_input1.trim($arr[$i]["building"], ' ').$building_input2."
									</div><div class='content_td-".$arr[$i]["id"]."'>".$arr[$i]["building"]."</div></td>";
			$resMain = $resMain."<td><div class='hidden' id='input-apart-".$arr[$i]["id"]."'>".$apart_input1.trim($arr[$i]["apart"], ' ').$apart_input2."
									</div><div class='content_td-".$arr[$i]["id"]."'>".$arr[$i]["apart"]."</div></td>";
			$resMain = $resMain."<td><div class='hidden' id='input-phone_number-".$arr[$i]["id"]."'>".$phone_number_input1.trim($arr[$i]["phone_number"], ' ').$phone_number_input2."
									</div><div class='content_td-".$arr[$i]["id"]."'>".$arr[$i]["phone_number"]."</div></td>";
			$resMain = $resMain."<td><div class='but_box'>
											<a onclick=hide_update(".$arr[$i]["id"].")><img id='edit-butt-".$arr[$i]["id"]."' class='edit-img' src='edit.png' alt=''></a>
											<input type='hidden' name='id' value='".$arr[$i]["id"]."'>
											<button id='save-but-".$arr[$i]["id"]."' type='submit' class='save_but hidden'><b>✓</b> </button>
										</form>
										<form action='delete_item.php' method='post'>
											<input type='hidden' name='delete_id' value='".$arr[$i]["id"]."'>
											<button type='submit' class='butt delete_but'>╳ </button>
										</form>
										</div></td>";
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
	<div class="main-menu">
		<a href="index.php"><div>
			<img src="home.svg" width="50px">
		</div></a>
		<a href="editTable.php"><div>
			<img src="edit.svg" width="50px">
		</div></a>
	</div>

	<table class="main">
		<tr><td><div class="head"><img src="logo.png" height="100px"></div></td>
		<tr>
			<td>
				<div class="main-search">
					<div id="search_box">
						<form id="search_form" action='index.php' method='get'>
							<div class="select-wrapper">
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
				  	 		</div>
							<input id="search" type='search' name='search' value='<?php echo $cur_search; ?>'>
							<button id="search_btn" type='submit' class='search_but'>Найти</button>
						</form>
					</div>
					<div id="wide-main-box">
						<div id="wide_search_field">
							<a id="chkWideSearch">
								<span id="wide_search_text">Расширенный поиск</span>
								<svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg" id="wide_arrow"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.429.253a.819.819 0 0 0-1.184 0 .883.883 0 0 0 0 1.22l4.142 4.274A.821.821 0 0 0 5 6a.821.821 0 0 0 .612-.253l4.143-4.273a.883.883 0 0 0 0-1.221.819.819 0 0 0-1.184 0L5 3.937 1.429.253Z" fill="currentColor"></path></svg>
							</a>
						</div>


						<div id="wide_search_box" class="hidden">
							<form action='index.php' method='get' id="wide_form">
								<div id="wide_search_table">

									<input id="wide-search-lname" type="text" class="form-control autocomplete" autocomplete="off" list="lname" placeholder="Фамилия" name="lname" class="wide_search_fields">
									<input type="hidden" name="lnameId" class="wide_search_fields"/>
									<datalist id="lname">
											<?php
												$res_options = "";
												$sql = "select * from lname order by 2;";
												$res = (pg_query($dbconn, $sql));
												$arr = pg_fetch_all($res);
												foreach ($arr as $i => $value) {
													$res_options = $res_options."<option data-id='".$i."' value='".trim($arr[$i]["lname"], " ")."'>";
												}
												echo $res_options;
											 ?>
									</datalist>

									<input id="wide-search-fname" type="text" class="form-control autocomplete" autocomplete="off" list="fname" placeholder="Имя" name="fname" class="wide_search_fields">
									<input type="hidden" name="fnameId" class="wide_search_fields"/>
									<datalist id="fname">
											<?php
												$res_oprions = "";
												$sql = "select * from fname order by 2;";
												$res = (pg_query($dbconn, $sql));
												$arr = pg_fetch_all($res);
												foreach ($arr as $i => $value) {
													$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["fname"], " ")."'>";
												}
												echo $res_oprions;
											 ?>
									</datalist>

									<input id="wide-search-mname" type="text" class="form-control autocomplete" autocomplete="off" list="mname" placeholder="Отчество" name="mname" class="wide_search_fields">
									<input type="hidden" name="mnameId" class="wide_search_fields"/>
									<datalist id="mname">
											<?php
												$res_oprions = "";
												$sql = "select * from mname order by 2;";
												$res = (pg_query($dbconn, $sql));
												$arr = pg_fetch_all($res);
												foreach ($arr as $i => $value) {
													$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["mname"], " ")."'>";
												}
												echo $res_oprions;
											 ?>
									</datalist>

									<input id="wide-search-streets" type="text" class="form-control autocomplete" autocomplete="off" list="s_name" placeholder="Улица" name="s_name">
									<input type="hidden" name="s_nameId" />
									<datalist id="s_name">
											<?php
												$res_oprions = "";
												$sql = "select * from streets order by 2;";
												$res = (pg_query($dbconn, $sql));
												$arr = pg_fetch_all($res);
												foreach ($arr as $i => $value) {
													$res_oprions = $res_oprions."<option data-id='".$i."' value='".trim($arr[$i]["s_name"], " ")."'>";
												}
												echo $res_oprions;
											 ?>
									</datalist>
									<input id="wide-search-building" type='text' placeholder="Дом" autocomplete="off" name='building' value=''>
									<input id="wide-search-apart" type='text' placeholder="Квартира" autocomplete="off" name='apart' value=''>
									<input id="wide-search-phone_number" type="text" placeholder="Телефон" autocomplete="off" class="phone_mask" name='phone_number'>


								</div>
								<div class="wide-search-but"><button type='submit' class='add_but'>Найти </button></div>
							</form>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				 	<?php
						if(array_key_exists('search_field', $_GET) != "" || array_key_exists('lname', $_GET)){
							echo "<a class='show-all' href='index.php'>Показать все записи</a>";
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
						<th></th>
					</tr>
					<tr class="add_tr">
						<form action='add_item.php' method='post'>
							<td>
								<input id="wide-search-lname" type="text" class="form-control autocomplete" autocomplete="off" list="lname" placeholder="Фамилия" name="lname">
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
							<td>
								<input type="text" class="form-control autocomplete" autocomplete="off" list="fname" placeholder="Имя" name="fname">
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
							<td>
								<input type="text" class="form-control autocomplete" autocomplete="off" list="mname" placeholder="Отчество" name="mname">
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
							<td>
								<input type="text" class="form-control autocomplete" autocomplete="off" list="s_name" placeholder="Улица" name="s_name">
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
							<td> <input type='text' placeholder="Дом" autocomplete="off" name='building' value=''></td>
							<td> <input id="wide-search-apart" type='text' placeholder="Квартира" autocomplete="off" name='apart' value=''></td>
							<td><input type="text" placeholder="Телефон" autocomplete="off" class="phone_mask" name='phone_number'> </td>
								<script>
								   $(".phone_mask").mask("+9(999)999-99-99");
								</script>
							<td> <button type='submit' class='butt add_but'>+ </button></td>
						</form>
					</tr>
					<?php echo $resMain; ?>
				</table>
			</td>
		</tr>
	</table>
	<script>
        $(".phone_mask").mask("+9(999)999-99-99");
    </script>
</body>