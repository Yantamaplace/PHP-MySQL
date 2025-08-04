<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Sample Page</title>
</head>
<body>
	<h1>Hello world!</h1>
	<p><a style="display:none;" href="./pages/ayu.php">あゆ</a></p>
	<p><a style="" href="./pages/ura.php">２次</a></p>
	<p><a style="" href="./sql/reset.php">リセット</a></p>

    <form action="./script/submit.php" method="post" enctype="multipart/form-data">
    	<label>画像：<input type="file" name="picture"></label>
    	<input type="submit" value="送信">
    </form>

	<hr>

<?php
phpinfo();
?>

</body>
</html>