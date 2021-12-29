<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8" />
		<title>メール送信テスト</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div>
			<h1>メール送信テスト</h1>
			<div class="lead">
				<?php
				$message = 'メール送信テストに失敗しました。設定を確認して下さい。';
				$data = $_POST;
				if (mail($data['mailTo'], $data['subject'], $data['text'], 'From: '. $data['mailFrom'])) {
					$message = 'メール送信テストを実施しました。受信メールをご確認下さい';
				}
				?>
				<p><?php echo strip_tags($message); ?></p>
			</div>

			<div class="end">
				<p><a href="index.php">一覧に戻る</a></p>
			</div>
		</div>
	</body>
</html>
