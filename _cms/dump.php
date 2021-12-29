<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8" />
		<title>mysqldumpテスト</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div>
			<h1>mysqldumpテスト</h1>
			<div class="lead">

			<?php
			$data = $_POST;
			if (empty($data) || !$data['db'] || !$data['user'] || !$data['password']) {
				$message = '接続失敗しました。';
			}
			$data['host'] = $data['host'] ? $data['host'] : 'localhost';
			$dsn = 'mysql:dbname='. $data['db']. ';host='. $data['host'];

			$dumpFileName = "dump_". date('Ymd_His'). '.sql'. "\n";
			$dump = exec("which mysqldump");
			if (strlen($dump) == 0) {
				echo '<p><a href="index.php">一覧に戻る</a></p>';
				exit("command not found（コマンドが見つかりません）");
			}
			print_r($dump);

			$dumpfile = "dump_". date('Ymd_His'). '.sql';

			$cmd = $dump.
			" --host=". $data['host']. " --user=". $data['user']. " --password=". $data['password']. " ". $data['db'] .
			" > ". $dumpfile;

			system($cmd);
			echo '<p>mysqldumpを実行しました。'. $dumpFileName. 'を確認して下さい。</p>';
			echo '<p><a href="index.php">一覧に戻る</a></p>';
			?>
		</div>
	</body>
</html>
