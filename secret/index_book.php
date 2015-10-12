<?php

session_start();

require_once('config.php');
require_once('functions.php');


// ログインしてなかったら、ログインページにとばす
if (empty($_SESSION['me'])) {
	header('Location:' .SITE_URL.'login.php');
}

// ログイン情報を変数meに突っ込む
$me = $_SESSION['me'];

// DB接続した値を＄dbhにぶっこんでいる
$dbh = connectDb();

// 変数postsに配列型で初期化
$books = array();

$sql = "select * from books";
$stmt = $dbh->query($sql);
while (1) {
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row == false) {
	break;
}
	$books[] = $row;
}

// if ($_SERVER['REQUEST_METHOD'] != "POST") {
	// 投稿前

	// CSRF対策
	// setToken();	
// } else {
	// 投稿後
	// checkToken();

	// $name = $_POST['name'];
	// $email = $_POST['email'];
	// $user_id = $me['id'];
	// $body = $_POST['body'];


	// $error = array();

	// // エラー処理
	// if ($body == '') {
	// 	$error['body'] = '内容を入力してくださいな';
	// }

	// if (empty($error)) {
		
 //    	// DB接続した値を＄dbhにぶっこんでいる
	// 	$dbh = connectDb();
		
	// 	$sql = "insert into posts
	// 		   (user_id, body, created, modified)
	// 		   values
	// 		   (:user_id, :body, now(), now())";

	// 	$stmt = $dbh->prepare($sql);

	// 	$params = array(
	// 		":body" => $body,
	// 		":user_id" => $user_id,
	// 	);

	// 	$stmt->execute($params);

	// 	// 同じページにとばす
	// 	header('Location: '.SITE_URL);
	// 	exit;
	// }
// }

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<title>BOOKS INDEX</title>
	</head>
	<body>
		<h2>【つぶやき一覧】</h2>
		<ul class="li_none">
			<?php foreach ($books as $book) : ?>
				<li>
					NO. <?php echo $book['id']; ?> TITLE : <?php echo $book['title']; ?>
				</li>
			<?php endforeach ; ?>
		</ul>
	</body>
</html>