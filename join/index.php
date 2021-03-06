<?php 
session_start();

if(!empty($_POST)) {
	if ($_POST['name'] === '' ) {
		$error['name'] = 'blank';
	}
	if ($_POST['email'] === '' ) {
		$error['email'] = 'blank';
	}
	// strlenは入力した文字数を測ってくれるメソッド
	if (strlen($_POST['password']) < 4 ) {
		// 'blank'ではなく'length'を使う事で違う種類のエラーだと認識させる。
		$error['password'] = 'length';
	}
	if ($_POST['password'] === '' ) {
		$error['password'] = 'blank';
	}
	// 画像が選択されていればの処理
	$filename = $_FILES['image']['name'];
	if (!empty($filename)) {
		// 以下のファイル形式以外拒否する記述
		$ext = substr($filename, -3);
		if (ext != 'jpg' && $ext != 'git') {
			$error['image'] = 'type';
		}

	}
	// emptyは$errorが空かを確認するメソッド
	if (empty($error)) {
	// 下のfileから持ってきて、../member_picture/に保存場所を移動。更にセッションに保存する。
	$image = date('YmdHis') . $_FILES['image']['name'];
	move_uploaded_file($_FILES['image']['tmp_name'],'../member_picture/' . $image);
	// 20201119myface.pngのようなファイル名で保存される。日付の付与で同名の場合の上書きを避ける。
	$_SESSION['join'] = $_POST;
	$_SESSION['join']['image'] = $image;
	header('Location: check.php');
	exit();
	}
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録</title>

	<link rel="stylesheet" href="../style.css" />
</head>
<body>
<div id="wrap">
<div id="head">
<h1>会員登録</h1>
</div>

<div id="content">
<p>次のフォームに必要事項をご記入ください。</p>
<form action="" method="post" enctype="multipart/form-data">
	<dl>
		<dt>ニックネーム<span class="required">必須</span></dt>
		<dd>
        	<input type="text" name="name" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>" />
					<?php if ($error['name'] === 'blank'): ?>
					<p class="error">* ニックネームを入力してください</p>
					<?php endif; ?>
		</dd>
		<dt>メールアドレス<span class="required">必須</span></dt>
		<dd>
        	<input type="text" name="email" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" />
					<?php if ($error['email'] === 'blank'): ?>
					<p class="error">* メールアドレスを入力してください</p>
					<?php endif; ?>
		<dt>パスワード<span class="required">必須</span></dt>
		<dd>
        	<input type="password" name="password" size="10" maxlength="20" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
					<?php if ($error['password'] === 'length'): ?>
					<p class="error">* パスワードは4文字以上で入力してください</p>
					<?php endif; ?>
					<?php if ($error['password'] === 'blank'): ?>
					<p class="error">* パスワードを入力してください</p>
					<?php endif; ?>
        </dd>
		<dt>写真など</dt>
		<dd>
        	<input type="file" name="image" size="35" value="test" />
					<?php if ($error['image'] === 'type'): ?>
					<p class="error">* 写真などは「.gif」または「.jpg」「.png」の画像を指定してください</p>
					<?php endif; ?>
					<?php if (!empty($error)): ?>
					<p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
					<?php endif; ?>
        </dd>
	</dl>
	<div><input type="submit" value="入力内容を確認する" /></div>
</form>
</div>
</body>
</html>
