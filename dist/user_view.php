<?php
require_once './_header.php';  
require_once './loginLevel.php';

$token = h(setToken());
// SQL実行
$strSQL = Dbq::createSelectSQL('MstUser');
$dbc = connect();
$stmt = $dbc->prepare($strSQL);
$stmt->execute();

require_once './_header_head.php';
require_once './_header_body.php'; 
?>
<div class="l-header-bar">
        <h1 class="l-header-bar__title">顧客管理</h1>
        <a href="user_add.php" class="l-header-bar__button">
            <span class="l-header-bar__button--plus"></span>
            <p class="l-header-bar__button--text">新規追加</p>
        </a>
    </div>
    <div class="l-header__mask"></div>
</header>
<main class="l-main">
    <div class="table">
        <!-- レコードがある数繰り返す 変数にレコードの結果を入れる -->
        <?php while ($row = $stmt->fetch()) :?>
            <div class='l-wrap table__wrap'>
                <table class='table__table'>
                    <!-- 顧客ID -->
                    <tr class='table__tr'>
                        <th class='table__th'>No.</td>
                        <td class='table__td'><?php echo $row['UserID']; ?></td>
                    </tr>
                    <!-- 顧客ID -->
                    <tr class='table__tr'>
                        <th class='table__th'>顧客名</td>
                        <td class='table__td'><p class='table__td--subtext'><?php echo h($row['UserKana']); ?></p><p><?php echo $row['UserName']; ?></p></td>
                    </tr>
                    <!-- 住所 -->
                    <tr class='table__tr'>
                        <th class='table__th'>住所</td>
                        <td class='table__td table__tds'><p class='table__td--subtext'><span>〒</span><?php echo $row['UserZipCode']; ?></p><p><?php echo $row['UserAddress1'], h($row['UserAddress2']); ?></p></td>
                    </tr>
                    <!-- 編集 -->
                    <tr class='table__tr'>
                        <th class='table__th'>編集</td>
                        <td class='table__td'>
                            <a href='user_add.php?id=<?php echo $row['UserID']; ?>' class='table__td--img table__td--edit'></a>
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
                    <!-- idを送る -->
                    <form action="user_DBupdate.php?id=<?php echo $row['UserID']; ?>&tp=waste" method="POST">
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