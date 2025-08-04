<?php
require "../script/imageslide.php";

$views = 1; //表示する画像の最大数
$dir = "Wallpapers"; //参照したいディレクトリ名
$out = imageSlide($views, $dir); //出力する文字列

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="refresh" content="10; URL=./ura.php">
	<title>My collections</title>
	<link rel="stylesheet" href="../css/slideshow.css">
</head>
<body>

<?php echo $out; ?>

<footer>
  <hr>
	<div id='footer'>
		<p>by Yantama 2020</p>
		<a href="../">ホームへ戻る</a>
	</div>
</footer>

</body>
</html>
