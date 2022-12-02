<?php
require_once './_header.php'; 

// 現在のurl取得
$page_url = (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ) ? "https://" : "http://").$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<?php require_once '_header_head.php'; ?>
	<div class="login">
		<form class="login__form" method="POST" action="login.php">
			<h1 class="login__title">サンプルシステム</h1>
			<div class="login__list">
				<dl class="login__item">
					<dt class="login__name">ログインID</dt>
					<dd class="login__input">
						<input type="text" id="loginID" name="loginID" placeholder="loginと入力してください">
					</dd>
					<p class="login__error">
						<?php
						// エラーあれば出力
						if (isset($_SESSION['strErrLogin'])) {
							echo $_SESSION['strErrLogin'];
							$_SESSION['strErrLogin'] = "";
						}
						?>
					</p>
				</dl>
				<dl class="login__item">
					<dt class="login__name">パスワード</dt>
					<dd class="login__input">
						<input type="text" id="password" name="password" placeholder="sampleと入力してください">
					</dd>
				</dl>
			</div>
			<p class="login__error">
				<?php
				// エラーあれば出力 
				if (isset($_SESSION['strErrPassword'])) {
					echo $_SESSION['strErrPassword'];
					$_SESSION['strErrPassword'] = "";
				}
				if (isset($_SESSION['strErrMsg'])) {
					echo $_SESSION['strErrMsg'];
					$_SESSION['strErrMsg'] = "";
				}
				?>
			</p>
			<!-- ワンタイムトークン -->
			<input type="hidden" name="csrfToken" value="<?php echo h(setToken()); ?>">
			<button class="login__button" type="submit">ログイン</button>
		</form>
	</div>
<?php require_once './_footer_body.php'; ?>
