<?php  include 'config.php';?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>サーバーチェック</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<header></header>
	<article>
		<div>
			<h1>サーバーチェック</h1>
			<p>サーバーチェックのスクリプトです。</p>
			<p><a href="https://basercms.net/about/system">（baserCMSのシステム要件はこちら）</a></p>

		</div>
		<section>
			<h2>基本チェック</h2>
			<ul>
				<li>phpバージョン： <?php echo phpversion(); ?></li>
				<li>ホスト名： <?php echo gethostname(); ?></li>
				<li>フルパス： <?php echo str_replace($here, '' , __FILE__)  ; ?></li>
				<li>PHP実行ユーザー名： <?php echo get_current_user(); ?></li>
			</ul>
		</section>

		<section>
			<h2>DB接続チェック（MySQLサーバー）</h2>
			<?php echo ($host) ?>
			<form action="db.php" novalidate="novalidate" id="db" method="post" accept-charset="utf-8">
				<table>
					<tr>
						<th><label for="host" >サーバー</label></th>
						<td><input type="text" name="host" placeholder="localhost"></td>
					</tr>
					<tr>
						<th><label for="user" >ユーザー名</label></th>
						<td><input type="text" name="user"></td>
					</tr>
					<tr>
						<th><label for="password" >パスワード</label></th>
						<td><input type="text" name="password"></td>
					</tr>
					<tr>
						<th><label for="db" >DB名</label></th>
						<td><input type="text" name="db"></td>
					</tr>
					<tr>
						<th><label for="port" >ポート</label></th>
						<td><input type="text"<?php echo $port ? ' value ="'. $port .'"' : '' ?> name="port"></td>
					</tr>
				</table>
				<input type="submit" name="submit" value="DB接続チェックをする">
			</form>
		</section>

		<section>
			<h2>メール送信チェック</h2>
			<form action="mailcheck.php" novalidate="novalidate" id="db" method="post" accept-charset="utf-8">
				<table>
					<tr>
						<th><label for="mailTo" >送信先メールアドレス</label></th>
						<td><input type="text"<?php echo $mailTo ? ' value ="'. $mailTo .'"' : '' ?> name="mailTo" placeholder="localhost"></td>
					</tr>
					<tr>
						<th><label for="mailFrom" >送信元メールアドレス</label></th>
						<td><input type="text"<?php echo $mailFrom ? ' value ="'. $mailFrom .'"' : '' ?> name="mailFrom"></td>
					</tr>
					<tr>
						<th><label for="subject" >メールタイトル</label></th>
						<td><input type="text"<?php echo $subject ? ' value ="'. $subject .'"' : '' ?> name="subject"></td>
					</tr>
					<tr>
						<th><label for="text" >メール本文</label></th>
						<td><input type="text"<?php echo $text ? ' value ="'. $text .'"' : '' ?> name="text"></td>
					</tr>
				</table>
				<p><input type="submit" name="submit" value="メール送信テストをする">【注意】メールが送信されます。</p>
			</form>
		</section>
		<section>
			<h2>リライトチェック</h2>
			<p><a href="_cms2/">こちらをクリックして下さい。</a></p>
		</section>
		<section>
			<h2>モジュールチェック</h2>
			<h4>設定値</h4>
			<ul>
				<li>Default timezone : <?php echo date_default_timezone_get();?> ／ Asia/Tokyo</li>
				<li>max_execution_time : <?php echo ini_get('max_execution_time');?> ／ 30</li>
				<li>post_max_size : <?php echo ini_get('post_max_size');?> ／ 11M</li>
				<li>upload_max_filesize : <?php echo ini_get('upload_max_filesize');?> ／ 10M</li>
				<li>memory_limit : <?php echo ini_get('memory_limit');?> ／ 128M</li>
			</ul>
			<h4>必須モジュールチェック</h4>
			<p>PDO 及び対象DBへのドライバ（例: pdo_mysql、pdo_pgsql、pdo_sqlite）</p>
			<?php $modules = get_loaded_extensions(); ?>
			<?php if (in_array('PDO', $modules) !== false) :?>
				<?php
				$pdos = [];
				$pdos[] = in_array('pdo_mysql', $modules) !== false ? 'pdo_mysql' : '';
				$pdos[] = in_array('pdo_pgsql', $modules) !== false ? 'pdo_pgsql' : '';
				$pdos[] = in_array('pdo_sqlite', $modules) !== false ? 'pdo_sqlite' : '';
				if (!empty($pdos)) {
					echo '<p>「'. implode('」・「', $pdos). '」 が使用可能です。</p>';
				} else {
					echo '<p>DBへのドライバが不足してます。</p>';
				}
				?>
			<?php else:?>
				<p>PDOが不足してます。</p>
			<?php endif;?>
			<ul>
				<li>mbstring : <?php echo in_array('mbstring', $modules) !== false ? 'OK' : '再確認して下さい' ?></li>
				<li>gd : <?php echo in_array('gd', $modules) !== false ? 'OK' : '再確認して下さい' ?></li>
				<li>libxml : <?php echo in_array('libxml', $modules) !== false ? 'OK' : '再確認して下さい' ?></li>
				<li>json : <?php echo in_array('json', $modules) !== false ? 'OK' : '再確認して下さい' ?></li>
			</ul>
		</section>

		<h2><a href="info.php">PHPインフォ</a></h2>
		<?php phpinfo();?>
	</article>
	<footer></footer>
</body>
</html>
