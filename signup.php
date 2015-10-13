<?php

session_start();

require_once('assets/config.php');
require_once('assets/functions.php');

// ポストされているかどうかをまず確認 → されてたら挙動開始させる
if ($_SERVER['REQUEST_METHOD'] != "POST") {

	// CSRF対策 → functions.php参照（ポスト以外の処理だったらセッション変数tokenに乱数をセットする）
	// setToken();	

} else {

	// ここまでがCSRF対策
	// ポストされた際の挙動記載（フォームでセットしたhiddenポストtokenが空、もしくはセッション変数tokenとhiddenポストtokenが等しくない時にエラーを出す）
	// checkToken();

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
		header('Location: '.SITE_URL.'index.php');
		exit;
	}
}

?>

<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>TOP</title>
		<link rel="stylesheet" type="text/css" href="assets/css/split_demo.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/split_component.css" />
		<script src="assets/js/split_modernizr.custom.js"></script>
	</head>
	<body>
		<div class="container">
			<div id="splitlayout" class="splitlayout">
				<div class="intro">
					<div class="side side-left">
						<header class="codropsheader clearfix">
							<h1>Nexseed Library</h1>
						</header>
						<div class="intro-content">
							<h1><span>STUDENT</span><span>Normal User</span></h1>
						</div>
						<div class="overlay"></div>
					</div>
					<div class="side side-right">
						<div class="intro-content">
							<h1><span>ADMIN</span><span>Super User</span></h1>
						</div>
						<div class="overlay"></div>
					</div>
				</div><!-- /intro -->
				<div class="page page-right">
					<div class="page-inner">
						<section>
							<form action="" method="POST">
								<p>
									NAME：
									<input type="text" name="name" value="<?php echo h($name); ?>"> 
								</p>
								<p>
									PASSWORD：
									<input type="password" name="password" value=""> 
								</p>
								<p>
									<input type="hidden" name="token" value="">
								</p>
								<p>
									<input type="submit" value="新規登録！"> 
									<a href="index.php">
										Go back to Log in
									</a>
								</p>
							</form>
						</section>
					</div><!-- /page-inner -->
				</div><!-- /page-right -->
				<div class="page page-left">
					<div class="page-inner">
						<section>
							<form action="" method="POST">
								<p>
									NAME：
									<input type="text" name="name" value="<?php echo h($name); ?>"> 
								</p>
								<p>
									PASSWORD：
									<input type="password" name="password" value=""> 
								</p>
								<p>
									<input type="hidden" name="token" value="">
								</p>
								<p>
									<input type="submit" value="新規登録！"> 
									<a href="index.php">
										Go back to Log in
									</a>
								</p>
							</form>
						</section>
					</div><!-- /page-inner -->
				</div><!-- /page-left -->
				<a href="#" class="back back-right" title="back to intro">&rarr;</a>
				<a href="#" class="back back-left" title="back to intro">&larr;</a>
			</div><!-- /splitlayout -->
		</div><!-- /container -->
		<script src="assets/js/split_classie.js"></script>
		<script src="assets/js/split_cbpSplitLayout.js"></script>
	</body>
</html>
