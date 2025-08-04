<?php
require "../script/imageslide.php";

$views = 20; //表示する画像の最大数
$dir = "ayu"; //参照したいディレクトリ名
$out = imageSlide($views, $dir); //出力する文字列

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="refresh" content="10; URL=./ayu.php">
	<title>My collections</title>
	<link rel="stylesheet" href="../css/slideshow.css">
	<style type="text/css">
		body{
			background-color: white;
		}
		.image_box{
			border-color: white;
		}
	</style>
</head>
<body>

<?php echo $out; ?>

<footer>
  <div id='footer'>
    <hr>
		<p>by Yantama 2020</p>
		<a href="../">ホームへ戻る</a>
	</div>
</footer>

</body>
</html>
