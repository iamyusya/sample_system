<?php
require_once './_header.php';  
require_once './loginLevel.php';

// idを持っていたらidを返す、持っていなかったら0を返す
$lngSalesID = isset($_GET['id']) ? intval($_GET['id']) : 0;
// 変数にテーブル、カラムを入れる
$table = 'TrnSales';
$tableID = 'SalesID';

$intData = [];
$strData = [];
// 配列に消費税区分番号を入れる
$intData = [0, 1, 2];
// 配列に消費税区分名を入れる
$strData = ['税込', '税抜', '非課税'];
// 新規追加
if ($lngSalesID == 0) {
    $intSalesPrice = 0;
    $strSalesMemo = "";
    $intSalesTaxType = 0;
    $intSalesIsCancel = 0;

    $strSubmit = "新規登録";
    $strTitle = "新規売上管理";
} else {
    // 編集登録
    // インスタンスを作成、変数に結果を入れる
    $row = Dbq::selectSQL($table, $tableID, $lngSalesID);
    
    // 変数にSQLの結果を入れる
    $intSalesPrice = $row['SalesPrice'];
    $intSalesTaxType = $row['SalesTaxType'];
    $strSalesMemo = $row['SalesMemo'];
    $intSalesIsCancel = $row['SalesIsCancel'];

    $strSubmit = "編集登録";
    $strTitle = "売上編集";
}

require_once ('_header_head.php');
require_once ('_header_body.php'); 
?>
    <div class="l-header-bar">
        <h1 class="l-header-bar__title"><?php echo $strTitle ?></h1>
    </div>
    <div class="l-header__mask"></div>
</header>
<main class="l-main">
    <div class="l-wrap">
        <form method="post" action="sales_DBupdate.php" class="form">
            <!-- idを送る -->
            <input type='hidden' name='id' value="<?php echo $lngSalesID?>">
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="SalesID">顧客名</label>
                </dt>
                <dd class="form__dd">
                    <select class="form__select" name="UserID" id="UserID">
                        <?php 
                        // 新しい順に顧客の情報を取得
                        $strSQLFunction = "SELECT * FROM MstUser WHERE IsWaste = 0 ORDER BY UpdateTime DESC;";
                        $dbcFunction = connect();
                        $stmtFunction = $dbcFunction->prepare($strSQLFunction);
                        $stmtFunction->execute();
                        while ($rowFunction = $stmtFunction->fetch()) : 
                        ?>
                            <option value='<?php echo h($rowFunction['UserID']); ?>'
                            <?php if ($lngSalesID == 0) $lngSalesID = $rowFunction['UserID']; ?>
                            <?php if ($lngSalesID == $rowFunction['UserID']) echo "selected='selected'"; ?>
                            ><?php echo h($rowFunction['UserName']); ?></option>
                        <?php endwhile ; ?>
                    </select>
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="SalesPrice">売上金額</label>
                </dt>
                <dd class="form__dd">
                    <input type="text" class="form__input form__price" name="SalesPrice" id="SalesPrice" value='<?php echo $intSalesPrice; ?>'>円
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="SalesTaxType">消費税区分</label>
                </dt>
                <dd class="form__dd form__dds">
                    <!-- 3回配列に入っている情報を出力する -->
                    <?php for ($i = 0; $i <= 2; $i++) : ?>
                        <div class='form__radios'>
                            <!-- ラジオボタン生成 -->
                            <input id='<?php echo $intData[$i]; ?>' class='form__radio' type='radio' name='SalesTaxType' value='<?php echo $intData[$i]; ?>'
                                <?php if ($intData[$i] == $intSalesTaxType) echo "checked='checked'"; ?>>
                            <label class='form__radio--label' for='<?php echo $intData[$i]; ?>'><?php echo h($strData[$i]); ?></label>
                        </div>
                    <?php endfor ; ?>
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="SalesMemo">備考</label>
                </dt>
                <dd class="form__dd">
                    <textarea class="form__textarea" name="SalesMemo" id="SalesMemo" cols="30" rows="10"><?php echo h($strSalesMemo) ?></textarea>
                </dd>
            </dl>
            <dl class="form__item">
                <dt class="form__dt">
                    <label for="SalesIsCancel">キャンセル</label>
                </dt>
                <dd class="form__dd">
                    <input class="form__checkbox" type="checkbox" name="SalesIsCancel" id="SalesIsCancel" value="1" <?php if ($intSalesIsCancel == 1) echo "checked='checked'"; ?>>キャンセル
                </dd>
            </dl>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="csrfToken" value="<?php echo h(setToken()); ?>">
            <button type="submit" class="form__button"><?php echo $strSubmit ?></button>
        </form>
    </div>
</main>
<?php require_once './_footer_body.php'; ?>