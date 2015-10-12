<?php

session_start();

require_once('config.php');
require_once('functions.php');

if (!empty($_SESSION['me'])) {
	header('Location:'.SITE_URL.'admin_page/index.php');
}

function getUser($name, $password, $dbh) {
	$sql = "select * from users where name = :name and password = :password limit 1";
	$stmt = $dbh->prepare($sql);
	$stmt->execute(array(":name"=>$name, ":password"=>getSha1Password($password)));
	// 返り値のPDOオブジェクトに対してfetchメソッドを実行し、結果セットを配列で取得している
	$user = $stmt->fetch();
	return $user ? $user : false;
}

if ($_SERVER['REQUEST_METHOD'] != "POST") {
	// 投稿前

	// CSRF対策
	setToken();	
} else {
	// 投稿後
	checkToken();

	$name = $_POST['name'];
	$password = $_POST['password'];


	// DB接続した値を＄dbhにぶっこんでいる
	$dbh = connectDb();

	$error = array();

	$me = getUser($name, $password, $dbh);

	// 名前が空
	if ($password == '') {
		$error['name'] = 'お名前を入力してください';
	}

	if (!$me) {
		$error['password'] = 'お名前とパスワードが正しくありません。';
	}

	// パスワードが空
	if ($password == '') {
		$error['password'] = 'パスワードを入力してください';
	}

	if (empty($error)) {
		$_SESSION['me'] = $me;
			header('Location: '.SITE_URL.'admin_page/index.php');
		exit;
	}

	// ログイン情報を記録する
	if ($_POST['save'] == 'on') {
		setcookie('email', $_POST['email'], time()+60*60*24*14);
		setcookie('password', $_POST['password'],
		time()+60*60*24*14);
	}
}

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>ログイン画面</title>
	</head>
	<body>
		<h1>log in</h1>
		<form action="" method="POST">
			<p>
				NAME：
				<input type="text" name="name" value="<?php echo h($name); ?>"> 
				<span class="error">
					<?php echo h($error['name']); ?>
				</span>
			</p>
			<p>
				PASSWORD：
				<input type="password" name="password" value=""> 
				<span class="error">
					<?php echo h($error['password']); ?>
				</span>
			</p>
			<p>
				<input id="save" type="checkbox" name="save" value="on"><label for="save">Keep to log in</label>
			</p>
			<p><input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>"></p>
			<p><input type="submit" value="ログイン！"> <a href="signup.php">Go to sign up</a></p>
		</form>
	</body>
</html>