<?php

function imageSlide($views, $dir){

	$out = ""; //出力する文字列

	/*--------------------DB接続----------------------*/
	$mysqli = new mysqli("localhost", "root", "ZpBR99sn", "collection");
	if ($mysqli->connect_errno) {
		 printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
	$mysqli->set_charset('utf8mb4');

	$filename = "";
	$sql_select_filename = "SELECT * FROM images WHERE display = true AND dirname = '".$dir."' ORDER BY count ASC LIMIT ".$views;
	//$sql_select_filename = "SELECT * FROM images WHERE display = true AND dirname = '".$dir."'";
	$sql_update_count = "";

	if(isset($_POST['filename'])) { // 非表示ボタンが押されている場合
		// var_dump($_POST['filename']);
		$postDir = $_POST['dirname'];
		$postFile = $_POST['filename'];
	    $sql_update_display = "UPDATE images SET display = false WHERE dirname = '".$postDir."' AND filename = '".$postFile."'";
	    $mysqli->query($sql_update_display);
	} 

	$result = $mysqli->query($sql_select_filename);
	$table_array = array();  // テーブル情報を格納する変数
	while($row = $result->fetch_assoc() ){
	  array_push($table_array, $row);
	}

	//shuffle($table_array);

	//var_dump($table_array[0]["filename"]);

	//for($i = 0;$i < count($table_array); $i++){
	for($i = 0;$i < $views; $i++){
		try{				
			$dirname = $table_array[$i]["dirname"];
			$filename = $table_array[$i]["filename"];
//			$sql_update_count = "UPDATE images SET count = count + 1 WHERE filename = '".$filename."'";
			$sql_update_count = "UPDATE images SET count = count + 1 WHERE dirname = '".$dirname."' AND filename = '".$filename."'";
			$out .= "
					<div class='image_box'>
						<img src='../img/".$dirname."/".$filename."' alt='".$filename."'>
						<span class='button'>
							<form action='#' method='post'>
								<input type='image' src='../img/material/icon_hidden.png' alt='表示切替'>
								<input type='hidden' name='dirname' value='".$dirname."'>
								<input type='hidden' name='filename' value='".$filename."'>
							</form>
						</span>
					</div>
					";
			$mysqli->query($sql_update_count);
		}catch(Exception $e){
			$mysqli->rollback();
		}
	}

	$mysqli->commit();
	$mysqli->close();

	return $out;
}

?>
