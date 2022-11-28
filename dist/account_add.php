<?php
require_once './_header.php'; 
require_once './loginLevel.php'; 

// idを持っていたらidを返す、持っていなかったら0を返す
$lngAccountID = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 新規追加
if ($lngAccountID == 0) {
    $strAccountName = "";
    $strAccountLoginID = "";
    $strAccountLoginPassword = "";
    $strAccountEmail = "";
    $intAccountSecurityLevel = 2000;

    $strSubmit = "新規追加";
    $strTitle = "新規アカウント作成";
} else {
    // 編集登録
    // インスタンスを作成、変数に結果を入れる
    $row = Dbq::selectSQL('MstAccount', 'AccountID', $lngAccountID);

    // 変数にSQLの結果を入れる
    $strAccountName = $row['AccountName'];
    $strAccountLoginID = $row['AccountLoginID'];
    $strAccountLoginPassword = $row['AccountLoginPassword'];
    $strAccountEmail = $row['AccountEmail'];
    $intAccountSecurityLevel = $row['AccountSecurityLevel'];

    $strSubmit = "編集登録";
    $strTitle = "アカウント編集";
}

$intData = [];
$strData = [];
// 配列に権限番号を入れる
$intData = [0, 100, 1000, 2000];
// 配列に権限名を入れる
$strData = ['開発', '管理者', 'スタッフ', 'ユーザー'];

require_once './_header_head.php'; 
require_once './_header_body.php'; 
?>
    </div>
    <div class="l-header-bar">
        <h1 class="l-header-bar__title"><?php echo $strTitle ?></h1>
    </div>
    <div class="l-header__mask"></div>
</header>
<main class="l-main">
    <div class="l-wrap">
        <form method="post" action="account_DBupdate.php" class="form">
            <!-- idを送る -->
            <input type='hidden' name='id' value="<?php echo h($lngAccountID); ?>">
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="">アカウント名</label>
                </dt>
                <dd class="form__dd">
                    <input type="text" class="form__input" name="AccountName" id="AccountName" value="<?php echo h($strAccountName); ?>" placeholder="山田太郎">
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="">ログインID</label>
                </dt>
                <dd class="form__dd">
                    <input type="text" class="form__input" name="AccountLoginID" id="AccountLoginID" value="<?php echo h($strAccountLoginID); ?>" placeholder="loginID">
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="">ログインパスワード</label>
                </dt>
                <dd class="form__dd">
                    <input type="password" class="form__input" name="AccountLoginPassword" id="AccountLoginPassword" value="<?php echo h($strAccountLoginPassword); ?>" placeholder="loginPassword">
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="">メールアドレス</label>
                </dt>
                <dd class="form__dd">
                    <input type="email" class="form__input" name="AccountEmail" id="AccountEmail" value="<?php echo h($strAccountEmail); ?>" placeholder="sample@sample.com">
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="">アクセス権限</label>
                </dt>
                <dd class="form__dd">
                    <!-- 4回配列に入っている情報を出力する -->
                    <?php for ($i = 0; $i <= 3; $i++) : ?>
                        <div class='form__radios'>
                            <!-- ラジオボタン生成 -->
                            <input id='<?php echo $intData[$i]; ?>' class='form__radio' type='radio' name='AccountSecurityLevel' value='<?php echo h($intData[$i]); ?>'
                                <?php if ($intData[$i] == $intAccountSecurityLevel) echo "checked='checked'"; ?>>
                            <label class='form__radio--label' for='<?php echo $intData[$i]; ?>'><?php echo $strData[$i]; ?></label>
                        </div>
                    <?php endfor ; ?>
                </dd>
            </dl>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="csrfToken" value="<?php echo h(setToken()); ?>">
            <button type="submit" class="form__button"><?php echo $strSubmit ?></button>
        </form>
    </div>
</main>
<?php require_once './_footer_body.php'; ?>
