<?php

session_start();

require_once('config.php');
require_once('functions.php');


// DB接続した値を＄dbhにぶっこんでいる
$dbh = connectDb();

// categories_tableのnameを取ってきている
$sql = "select * from categories";
$stmt = $dbh->query($sql);
while (1) {
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row == false) {
	break;
}
	$categories[] = $row;
}
// var_dump($categories);

// books_tableのstatusを取ってきている
$sql = "select distinct status from books";
$stmt = $dbh->query($sql);
while (1) {
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row == false) {
	break;
}
	$statuses[] = $row;
}
// var_dump($statuses);


// ポストされているかどうかをまず確認 → されてたら挙動開始させる
if ($_SERVER['REQUEST_METHOD'] != "POST") {

	// CSRF対策 → functions.php参照（ポスト以外の処理だったらセッション変数tokenに乱数をセットする）
	// setToken();	

} else {

	// ここまでがCSRF対策
	// ポストされた際の挙動記載（フォームでセットしたhiddenポストtokenが空、もしくはセッション変数tokenとhiddenポストtokenが等しくない時にエラーを出す）
	// checkToken();

	// データを扱いやすくするために、フォームからポストされた内容を各変数に突っ込んでおく
	$category_id = $_POST['category_id'];
	$book_code = $_POST['book_code'];
	$title = $_POST['title'];
	$auther = $_POST['auther'];
	$price = $_POST['price'];
	$date_of_purchase = $_POST['date_of_purchase'];
	$status = $_POST['status'];
	$description = $_POST['description'];


	// そのあとDB接続した値を＄dbhにぶっこんでいる
	$dbh = connectDb();

	// 以下エラー処理を記載
	// 配列で初期化しておく
	$error = array();
	
	// 名前が空かどうかチェック
	// if ($user_name == '') {
	// 	$error['user_name'] = '名前を入力してください';
	// }

	// if (emailExists($email, $dbh)) {
	// 	$error['email'] = 'このメールアドレスは既に登録されています。';
	// }

	//メールアドレスが正しい記述かどうか 
	// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	// 	$error['email'] = "メールアドレスの形式が正しくありません";
	// }

	// メールアドレスが空かどうかチェック
	// if ($email == '') {
	// 	$error['email'] = 'メールアドレスを入力してください';
	// }
	
	// パスワードが空かどうかチェック
	// if ($password == '') {
	// 	$error['password'] = 'パスワードを入力してください';
	// }

	// パスワードとパスワード（確認）が合致しているかを確認
	// if (!$password == $password_confirm) {
	// 	$error['password_confirm'] = 'パスワードとパスワード（確認）が合致していません';
	// }

	// 上記のエラーチェックをパスしたら登録処理を実行する
	if (empty($error)) {
		$sql = "insert into books
				(category_id, book_code, title, auther, price, date_of_purchase, status, description, created, modified)
				values
				(:category_id, :book_code, :title, :auther, :price, :date_of_purchase, :status, :description, now(), now())";
		$stmt = $dbh->prepare($sql);
		$params = array(
			":category_id" => $category_id,
			":book_code" => $book_code,
			":title" => $title,
			":auther" => $auther,
			":price" => $price,
			":date_of_purchase" => $date_of_purchase,
			":status" => $status,
			":description" => $description
		);
		$stmt->execute($params);

		// 登録処理後、ログインページへリダイレクト処理をおこなう
		header('Location: '.SITE_URL.'index_book.php');
		exit;
	}
}

?>

<html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>REGISTER BOOK</title>
	</head>
	<body>
		<h1>INPUT THE BOOK</h1>
		<form action="" method="POST">
			<p>CATEGORY : 
				<select name="category_id">
				<option value="1">英語学習</option>
				<option value="2">ビジネス書</option>
				<option value="3">プログラミング</option>
				<option value="4">小説・その他</option>
				</select>
			</p>

			<p>
				BOOK CODE : 
				<input type="text" name="book_code" value=""> 
			</p>
			<p>
				TITLE : 
				<input type="text" name="title" value=""> 
			</p>
			<p>
				AUTHER : 
				<input type="text" name="auther" value=""> 
			</p>
			<p>
				PRICE : 
				<input type="text" name="price" value=""> 

			</p>
			<p>
				DATE  OF PURCHASE : 
				<input type="text" name="date_of_purchase" value=""> 

			</p>
			<p>STATUS : 
				<select name="status">
					<option value=1>在庫</option>
					<option value=2>紛失</option>
					<option value=3>対応中</option>
				</select>
			</p>
			DESCRIPTION : 
			<p>
				<textarea name="description" cols="40" rows="5"></textarea>
			</p>

			<p>
				<input type="submit" value="REGISTER"> 
			</p>
			<p>
				<a href="index.php">
					GO BACK TO HOME
				</a>
			</p>
		</form>
	</body>
</html>