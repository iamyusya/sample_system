<?php
require_once './_header.php';
require_once './loginLevel.php';

// idを持っていたらidを返す、持っていなかったら0を返す
$lngUserID = isset($_GET['id']) ? intval($_GET['id']) : 0;
// 変数にテーブル、カラムを入れる
$table = 'MstUser';
$tableID = 'UserID';

// 新規追加
if ($lngUserID == 0) {
    $strUserKana = "";
    $strUserName = "";
    $intUserZipCode = "";
    $strUserAddress1 = "";
    $strUserAddress2 = "";

    $strSubmit = "新規追加";
    $strTitle = "新規顧客作成";
} else {
    // 編集登録
    // インスタンスを作成、変数に結果を入れる
    $row = Dbq::selectSQL($table, $tableID, $lngUserID);

    // 変数にSQLの結果を入れる
    $strUserKana = $row['UserKana'];
    $strUserName = $row['UserName'];
    $intUserZipCode = $row['UserZipCode'];
    $strUserAddress1 = $row['UserAddress1'];
    $strUserAddress2 = $row['UserAddress2'];

    $strSubmit = "編集登録";
    $strTitle = "顧客編集";
}
// 配列に都道府県を入れる
$prefecture = [
    '北海道',
    '青森県',
    '岩手県',
    '宮城県',
    '秋田県',
    '山形県',
    '福島県',
    '茨城県',
    '栃木県',
    '群馬県',
    '埼玉県',
    '千葉県',
    '東京都',
    '神奈川県',
    '山梨県',
    '長野県',
    '新潟県',
    '富山県',
    '石川県',
    '福井県',
    '岐阜県',
    '静岡県',
    '愛知県',
    '三重県',
    '滋賀県',
    '京都府',
    '大阪府',
    '兵庫県',
    '奈良県',
    '和歌山県',
    '鳥取県',
    '島根県',
    '岡山県',
    '広島県',
    '山口県',
    '徳島県',
    '香川県',
    '愛媛県',
    '高知県',
    '福岡県',
    '佐賀県',
    '長崎県',
    '熊本県',
    '大分県',
    '宮崎県',
    '鹿児島県',
    '沖縄県'
];

require_once './_header_head.php'; 
require_once './_header_body.php'; 
?>
    <div class="l-header-bar">
        <h1 class="l-header-bar__title"><?php echo $strTitle ?></h1>
    </div>
    <div class="l-header__mask"></div>
</header>
<main class="l-main">
    <div class="l-wrap">
        <form method="post" action="user_DBupdate.php" class="form">
            <!-- idを送る -->
            <input type='hidden' name='id' value="<?php echo $lngUserID?>">
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="UserName">顧客名</label>
                </dt>
                <dd class="form__dd">
                    <input type="text" class="form__input" name="UserName" id="UserName" value="<?php echo $strUserName; ?>" placeholder="山田太郎">
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="UserName">顧客名（フリガナ）</label>
                </dt>
                <dd class="form__dd">
                    <input type="text" class="form__input" name="UserKana" id="UserKana" value="<?php echo h($strUserKana) ?>" placeholder="ヤマダタロウ">
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="UserZipCode">郵便番号</label>
                </dt>
                <dd class="form__dd form__dds">
                    <span>〒</span><input type="text" class="form__input form__zip-code" name="UserZipCode" id="UserZipCode" value="<?php echo h($intUserZipCode) ?>" placeholder="1234567" autocomplete="shipping postal-code">
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="UserAddress1">都道府県</label>
                </dt>
                <dd class="form__dd">
                    <select class="form__select" name="UserAddress1" id="UserAddress1" autocomplete="shipping address-level1">
                        <!-- 都道府県の数繰り返す -->
                        <?php foreach ($prefecture as $key) : ?>
                            <!-- 更新時、登録されている都道府県を選択状態にする -->
                            <?php if ($key == $strUserAddress1) : ?>
                                <option value='<?php echo h($key); ?>' selected='selected'><?php echo $key; ?></option>
                            <?php else : ?>
                                <option value='<?php echo h($key); ?>'><?php echo $key; ?></option>
                            <?php endif ; ?>
                        <?php endforeach ; ?>
                    </select>
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="UserAddress2">市区町村以下</label>
                </dt>
                <dd class="form__dd">
                    <input type="text" class="form__input" name="UserAddress2" id="UserAddress2" value="<?php echo h($strUserAddress2) ?>" placeholder="大阪市" autocomplete="shipping address-line1">
                </dd>
            </dl>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="csrfToken" value="<?php echo h(setToken()); ?>">
            <button type="submit" class="form__button"><?php echo $strSubmit ?></button>
        </form>
    </div>
</main>
<?php require_once './_footer_body.php'; ?>