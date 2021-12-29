<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8" />
		<title>DB接続テスト</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div>
			<h1>DB接続テスト</h1>
			<div class="lead">
				<?php
				$message = '';
				$data = $_POST;
				if (empty($data) || !$data['db'] || !$data['user'] || !$data['password']) {
					$message = '接続失敗しました。';
				}
				$data['host'] = $data['host'] ? $data['host'] : 'localhost';
				$dsn = 'mysql:dbname='. $data['db']. ';host='. $data['host'];
				try{
				    $dbh = new PDO($dsn, $data['user'], $data['password']);
				} catch (PDOException $e){
				    print('Error:'.$e->getMessage());
				    $message = '接続失敗しました。';
				    echo '<h3>'. $message. '</h3>';
				    echo '<p><a href="index.php">一覧に戻る</a></p>';
				    die();
				}
				$sql = "SHOW VARIABLES LIKE 'collation%';";
				$stmt = $dbh->query($sql);
				$results = $stmt->fetchAll(PDO::FETCH_BOTH);
				$collation = [];
				if (!empty($results)) {
					foreach ($results as $result) {
						$collation[$result['Variable_name']] = $result['Value'];
					}
				}
				$sql2 = "show character set";
				$stmt2 = $dbh->query($sql2);
				$results2 = $stmt2->fetchAll(PDO::FETCH_BOTH);
				$mb4 = false;
				if (!empty($results2)) {
					$mb4 = array_search('utf8mb4_general_ci', array_column($results2,'Default collation'));
				}
				?>
				<p><?php echo $message ? $message : $data['host']. ' に接続成功しました。' ?></p>
				<p><?php printf("MySQL server version: %s\n", $dbh->getAttribute(constant("PDO::ATTR_SERVER_VERSION"))); ?></p>
				<p><?php echo isset($collation['collation_database']) ? 'データベースの照合順序 : '. $collation['collation_database'] : ''; ?></p>
				<p>utf8mb4 利用:   <?php echo $mb4 ? '可' : '不可' ?></p>
			</div>

			<div class="end">
				<?php if (!$message) :?>
					<form action="dump.php" novalidate="novalidate" id="dump" method="post" accept-charset="utf-8">
						<input type="hidden" value="<?php echo $data['host']?>" name="host" placeholder="localhost">
						<input type="hidden" value="<?php echo $data['user']?>" name="user">
						<input type="hidden" value="<?php echo $data['password']?>" name="password">
						<input type="hidden" value="<?php echo $data['db']?>" name="db">
						<input type="submit" name="submit" value="mysqldumpをテストする">
					</form>
				<?php endif;?>
				<p><a href="index.php">一覧に戻る</a></p>
			</div>
		</div>
	</body>
</html>
