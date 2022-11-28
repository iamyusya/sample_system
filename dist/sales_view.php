<?php
require_once './_header.php';
require_once './loginLevel.php';

// ワンタイムトークン生成
$token = h(setToken());
// SQL実行
$strSQL = Dbq::createSelectSQL('TrnSales');
$dbc = connect();
$stmt = $dbc->prepare($strSQL);
$stmt->execute();

require_once './_header_head.php';
require_once './_header_body.php'; 
?>
<div class="l-header-bar">
        <h1 class="l-header-bar__title">売上管理</h1>
        <a href="sales_add.php" class="l-header-bar__button">
            <span class="l-header-bar__button--plus"></span>
            <p class="l-header-bar__button--text">新規作成</p>
        </a>
    </div>
    <div class="l-header__mask"></div>
</header>
<main class="l-main">
    <div class="table">
        <!-- レコードがある数繰り返す 変数にレコードの結果を入れる -->
        <?php while ($row = $stmt->fetch()) : ?>
            <!-- SalesIsCancelに1が入っている場合 -->
            <?php if ($row['SalesIsCancel'] == 1) : ?>
                <div class='l-wrap table__wrap'><table class='table__table is_cancel'>
            <?php else : ?>
                <div class='l-wrap table__wrap'><table class='table__table'>
            <?php endif ; ?>
            <!-- 売上ID -->
            <tr class='table__tr'>
                <th class='table__th'>No.</td>
                <td class='table__td'><?php echo h($row['SalesID']); ?></td>
            </tr>
            <!-- 顧客名 -->
            <?php 
            // 変数にSQL文を入れる MstUserとTrnSalesのテーブルを結合
            $strSQLFunction = "SELECT 
            MstUser . UserID,
            MstUser . UserName
            FROM MstUser INNER JOIN TrnSales ON MstUser . UserID = TrnSales . UserID;";
            // SQL実行
            $dbcFunction = connect();
            $stmtFunction = $dbcFunction->prepare($strSQLFunction);
            $stmtFunction->execute();
            $rowFunction = $stmtFunction->fetch();
            ?>
            <tr class='table__tr'>
                <th class='table__th'>顧客名</td>
                <td class='table__td'><?php echo h($rowFunction['UserName']); ?></td>
            </tr>
            <!-- 売上金額 -->
            <tr class='table__tr'>
                <th class='table__th'>金額</td>
                <td class='table__td'><?php echo h($row['SalesPrice']); ?>円</td>
            </tr>
            <!-- 消費税区分 -->
            <tr class='table__tr'>
                <th class='table__th'>消費税区分</td>
                    <?php
                    // 数値ごとに対応した文字を呼び出す
                    switch ($row['SalesTaxType']) {
                        case 0: 
                            $TaxType = '税込';
                            break;
                        case 1: 
                            $TaxType = '税別';
                            break;
                        default: 
                            $TaxType = '非課税';
                    }
                    ?>
                <td class='table__td'><?php echo $TaxType; ?></td>
            </tr>
            <!-- 備考 -->
            <tr class='table__tr'>
                <th class='table__th'>備考</td>
                <td class='table__td'><?php echo h($row['SalesMemo']); ?></td>
            </tr>
            <!-- キャンセル -->
            <tr class='table__tr'>
                <th class='table__th'>キャンセル</td>
                <td class='table__td'>
                    <!-- SalesIsCancelに1が入っている時、キャンセルと表示 -->
                    <?php if ($row['SalesIsCancel'] == 1) echo "キャンセル"; ?>
                </td>
            </tr>
            <!-- 編集 -->
            <tr class='table__tr'>
                <th class='table__th'>編集</td>
                <td class='table__td'>
                    <a href='sales_add.php?id=<?php echo $row['SalesID']; ?>' class='table__td--img table__td--edit'></a>
                    <p class='table__td--tooltip'>情報を編集します</p>
                </td>
            </tr>
            <!-- 削除 -->
            <tr class='table__tr'>
                <th class='table__th'>削除</td>
                <td class='table__td'>
                    <button class='table__td--img table__td--delete'></button>
                    <p class='table__td--tooltip'>情報を削除します</p>
                </td>
            </tr>
            </table>
            <div class="table__modal">
                <p class="table__modal--text">本当に削除しますか？</p>
                <form action="sales_DBupdate.php?id=<?php echo $row['SalesID']; ?>&tp=waste" method="POST">
                    <div class="table__modal--buttons">
                        <button type="submit" class='table__modal--button-true'>はい</button>
                        <div class="table__modal--button-false">いいえ</div>
                    </div>
                    <!-- ワンタイムトークン -->
                    <input type="hidden" name="csrfToken" value="<?php echo h($token); ?>">
                </form>
            </div>
            </div>
        <?php endwhile ; ?>
    </div>
</main>
<?php require_once './_footer_body.php'; ?>