<?php 
require_once './_header.php';   
// require_once './loginLevel.php';

// ワンタイムトークン生成
$token = h(setToken());
// SQL実行
$strSQL = Dbq::createSelectSQL('MstAccount');
$dbc = connect();
$stmt = $dbc->prepare($strSQL);
$stmt->execute();
    
require_once './_header_head.php'; 
require_once './_header_body.php'; 
?>
    <div class="l-header-bar">
        <h1 class="l-header-bar__title">アカウント管理</h1>
        <a href="account_add.php" class="l-header-bar__button">
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
                <div class='l-wrap table__wrap'>
                    <table class='table__table'>
                        <!-- アカウントID -->
                        <tr class='table__tr'>
                            <th class='table__th'>No.</td>
                            <td class='table__td'><?php echo $row['AccountID']; ?></td>
                        </tr>
                        <!-- アカウント名 -->
                        <tr class='table__tr'>
                            <th class='table__th'>アカウント<br class='u-br__500'>名</td>
                            <td class='table__td'><?php echo $row['AccountName']; ?></td>
                        </tr>
                        <!-- ログインID -->
                        <tr class='table__tr'>
                            <th class='table__th'>ログインID</td>
                            <td class='table__td'><?php echo $row['AccountLoginID']; ?></td>
                        </tr>
                        <!-- メールアドレス -->
                        <tr class='table__tr'>
                            <th class='table__th'>メール<br class='u-br__500'>アドレス</td>
                            <td class='table__td'><?php echo $row['AccountEmail']; ?></td>
                        </tr>
                        <!-- アクセス権限 -->
                        <tr class='table__tr'>
                            <th class='table__th'>アクセス<br class='u-br__500'>権限</td>
                            <!-- 数値ごとに対応した文字を呼び出す -->
                            <?php 
                                switch ($row['AccountSecurityLevel']) {
                                    case 0:
                                        $SecurityLevel = '開発者';
                                        break;
                                    case 100:
                                        $SecurityLevel = '管理者';
                                        break;
                                    case 1000:
                                        $SecurityLevel = 'スタッフ';
                                        break;
                                    default:
                                        $SecurityLevel = 'ユーザー';
                                }
                            ?>
                            <td class='table__td'><?php echo $SecurityLevel; ?></td>
                        </tr>
                        <!-- 編集 -->
                        <tr class='table__tr'>
                            <th class='table__th'>編集</td>
                            <td class='table__td'><a href='account_add.php?id=<?php echo $row['AccountID']; ?>'class='table__td--img table__td--edit'></a>
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
                        <form action="account_DBupdate.php?id=<?php echo $row['AccountID']; ?>&tp=waste" method="POST">
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

