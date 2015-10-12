<?php

session_start();

require_once('config.php');
require_once('functions.php');

// ポストされているかどうかをまず確認 → されてたら挙動開始させる
if ($_SERVER['REQUEST_METHOD'] != "POST") {

	// CSRF対策 → functions.php参照（ポスト以外の処理だったらセッション変数tokenに乱数をセットする）
	setToken();	

} else {

	// ここまでがCSRF対策
	// ポストされた際の挙動記載（フォームでセットしたhiddenポストtokenが空、もしくはセッション変数tokenとhiddenポストtokenが等しくない時にエラーを出す）
	checkToken();

	// データを扱いやすくするために、フォームからポストされた内容を各変数に突っ込んでおく
	$name = $_POST['name'];
	$password = $_POST['password'];

	// そのあとDB接続した値を＄dbhにぶっこんでいる
	$dbh = connectDb();

	// 以下エラー処理を記載
	// 配列で初期化しておく
	$error = array();
	
	// 名前が空かどうかチェック
	if ($name == '') {
		$error['name'] = '名前を入力してください';
	}
	
	// パスワードが空かどうかチェック
	if ($password == '') {
		$error['password'] = 'パスワードを入力してください';
	}

	// 上記のエラーチェックをパスしたら登録処理を実行する
	if (empty($error)) {
		$sql = "insert into users
				(name, password, created, modified)
				values
				(:name, :password, now(), now())";
		$stmt = $dbh->prepare($sql);
		$params = array(
			":name" => $name,
			":password" => getSha1Password($password)
		);
		$stmt->execute($params);

		// 登録処理後、ログインページへリダイレクト処理をおこなう
		header('Location: '.SITE_URL.'login.php');
		exit;
	}
}

?>

<html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>sign up</title>
	</head>
	<body>
		<h1> sign up </h1>
		<form action="" method="POST">

			<p>
				NAME：
				<input type="text" name="name" value="<?php echo h($name); ?>"> 
				<span class="error">
					<?php echo $error['name']; ?>
				</span>
			</p>
			<p>
				PASSWORD：
				<input type="password" name="password" value=""> 
				<span class="error">
					<?php echo $error['password']; ?>
				</span>
			</p>
			<p>
				<input type="hidden" name="token" value="">
			</p>
			<p>
				<input type="submit" value="新規登録！"> 
				<a href="login.php">
					Go back to Log in
				</a>
			</p>
			<input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
		</form>
	</body>
</html>