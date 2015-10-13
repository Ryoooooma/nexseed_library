<?php

session_start();

require_once('assets/config.php');
require_once('assets/functions.php');

if (!empty($_SESSION['me'])) {
	header('Location:'.SITE_URL.'book_category.php');
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
	// setToken();	
} else {
	// 投稿後
	// checkToken();

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
			header('Location: '.SITE_URL.'book_category.php');
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
									<input id="save" type="checkbox" name="save" value="on"><label for="save">Keep to log in</label>
								</p>
								<p><input type="submit" value="Login"> <a href="signup.php">Go to sign up</a></p>
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
									<input type="text" name="name" value=""> 
								</p>
								<p>
									PASSWORD：
									<input type="password" name="password" value=""> 
								</p>
								<p><input type="submit" value="Login"> <a href="signup.php">Go to sign up</a></p>
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
