<?php
$file = $_FILES['picture'];



var_dump($file);
if($file['type'] === "image/jpeg" || $file['type'] === "image/png" || $file['type'] === "image/gif"){
	$path = "../img/Wallpapers/" . $file['name'];
	$success = move_uploaded_file($file["tmp_name"], $path);

	if($success){
		echo "成功しました。";
	}else{
		echo "失敗しました。";
	}

}else{
	echo "ファイルの形式が不正です。";
}

?>