<?php

$dir = "../img"; //本ファイルから見た画像フォルダの位置

function getFileList($directory) { //ディレクトリ内の一覧を配列で取得
    $files = glob(rtrim($directory, '/') . '/*');
    $list = array();
    foreach ($files as $file) {
        if (is_file($file)) {
            $list[] = $file;
        }
        if (is_dir($file)) {
            $list = array_merge($list, getFileList($file));
        }
    }
    return $list;
}

function createFileDirectoryList($pathlist){ //パスの文字列からimg以降のフォルダを抽出してリストを返す
	global $dir;
	$dirlist = array();
	$start_word = strlen($dir) + 1;

	for($i = 0;$i < count($pathlist);$i++){
		$pathlist[$i] = substr($pathlist[$i], $start_word);
		$tmp = explode("/", $pathlist[$i]); //パスをスラッシュ毎に分割
		$end_word = end($tmp);
		$filename = strlen($end_word); //ファイル名の文字数を抽出
		$dirname = substr($pathlist[$i], 0, strlen($pathlist[$i]) - ($filename + 1)); //フォルダ名を抽出
		if($dirname != ""){
			array_push($dirlist, $dirname);
		}else{
			array_push($dirlist, "");
		}
	}
	return $dirlist;
}

function createFileNameList($pathlist){ //パスの文字列からファイル名を抽出してリストを返す
	$namelist = array();
	for($i = 0;$i < count($pathlist);$i++){
		$tmp = explode("/", $pathlist[$i]);
		$end_word = end($tmp);
		array_push($namelist, $end_word);
	}
	return $namelist;
}

$list = getFileList($dir);

shuffle($list); //配列をシャッフル

//var_dump($list); //相対パス込みでファイル名取得

//echo strlen($dir);

$directories = createFileDirectoryList($list); //パスの文字列からimg以降のフォルダを抽出してリストを返す
$files = createFileNameList($list); //パスの文字列を削ぎ落とす

//var_dump($files);

/*--------------------DB接続----------------------*/

$mysqli = new mysqli("localhost", "root", "ZpBR99sn", "collection");

if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$mysqli->set_charset('utf8mb4');

$sql_drop_table = "DROP TABLE collection.images";
$sql_create_table = "CREATE TABLE collection.images(
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	dirname varchar(255),
	filename varchar(255) NOT NULL UNIQUE,
	count int NOT NULL DEFAULT 0,
	likes int NOT NULL DEFAULT 0,
	display boolean DEFAULT true
)";

//var_dump($db_link);

try{
	$dirname = "";
	$filename = "";
	$sql_insert_filename = "";

	//テーブル初期化

	$mysqli->query($sql_drop_table);
	$mysqli->query($sql_create_table);

	echo "リセット開始\n/";

	for($i = 0; $i < count($files); $i++){
		$filename = $files[$i];
		$dirname = $directories[$i];
		$sql_insert_filename = "INSERT INTO images (dirname,filename) VALUES ('".$dirname."','".$filename."')";
		echo "*";
		$mysqli->query($sql_insert_filename);
  }

  $mysqli->query("SET @i := 0");
  $mysqli->query("UPDATE images SET id = (@i := @i + 1)");

}catch(Exception $e){
	$mysqli->rollback();
	printf("Exception: %s\n", $e);
}
$mysqli->commit();

echo "/\nリセット完了\n";

$mysqli->close();

?>
