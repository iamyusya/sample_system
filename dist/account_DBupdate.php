<?php
require_once './_header.php'; 
require_once './loginLevel.php';
// トークンがあれば変数に入れる
$token = filter_input(INPUT_POST, 'csrfToken');
// トークンがない場合
if (!isset($_SESSION['csrfToken']) || $token !== $_SESSION['csrfToken']) {
    exit('不正なアクセスです');
} 
// トークン削除
unset($_SESSION['csrfToken']);

// 変数初期化
$strErrMsg = '';
// 削除機能
if (isset($_GET['tp']) && $_GET['tp'] === 'waste') {
    // 変数にidを入れる
    $lngAccountID = intval($_GET['id']);
    // 削除失敗の場合
    if (!$result = Dbq::updateFlagSQL('MstAccount', 'AccountID', $lngAccountID)) {
        // 変数にエラーメッセージを入れる
        $strErrMsg = '削除に失敗しました';
    }
} else {
    // idがあったらidを、ないなら-1を入れる（クローラー対策）
    $lngAccountID = isset($_POST['id']) ? intval($_POST['id']) : intval(-1);

    if ($lngAccountID == -1) {
        // 変数にエラーメッセージを入れる
        $strErrMsg = "不正なアクセスです！";
    } else {
        // 新規追加
        if ($lngAccountID === 0) {
            // 変数にSQL文を入れる
            $strSQL = "INSERT INTO MstAccount(
            AccountName,
            AccountLoginID,
            AccountLoginPassword,
            AccountEmail,
            AccountSecurityLevel,

            IsWaste,
            AddTime,
            UpdateTime
            )
            VALUES(?, ?, ?, ?, ?,
            0,
            '" . date("Y/m/d H:i:s", $m_dtmNow) . "',
            '" . date("Y/m/d H:i:s", $m_dtmNow) . "'
            );";

            $array = [];
            // 配列にPOSTの値を入れる
            $array = [
                $_POST['AccountName'],
                $_POST['AccountLoginID'],
                $_POST['AccountLoginPassword'],
                $_POST['AccountEmail'],
                $_POST['AccountSecurityLevel'],
            ];
            // インスタンスの作成
            $result = Dbq::runSQL($strSQL, $array);
            // SQLが失敗した場合
            if (!$result) {
                // 変数にエラーメッセージを入れる
                $strErrMsg = '登録に失敗しました';
            }
        } else {
            // 編集登録
            // 変数にSQL文を入れる
            $strSQL = "UPDATE MstAccount SET
            AccountName = ?,
            AccountLoginID = ?,
            AccountLoginPassword = ?,
            AccountEmail = ?,
            AccountSecurityLevel = ?,
            UpdateTime = ' " . date("Y/m/d H:i:s", $m_dtmNow) . "'
            WHERE AccountID = ?;";

            $array = [];
            // 配列にPOSTの値を入れる
            $array = [
                $_POST['AccountName'],
                $_POST['AccountLoginID'],
                $_POST['AccountLoginPassword'],
                $_POST['AccountEmail'],
                $_POST['AccountSecurityLevel'],
                $lngAccountID
            ];
            // インスタンスの作成
            $result = Dbq::runSQL($strSQL, $array);
            // SQLが失敗した場合
            if (!$result) {
                // 変数にエラーメッセージを入れる
                $strErrMsg = '更新に失敗しました';
            }
        }
    }
}
?>
<?php 
if ($strErrMsg === '') : 
    // エラーがない場合 一覧画面へ飛ばす
    header('Location: account_view.php'); 
    exit();
?>
<?php else : ?> 
    <!-- エラーがある場合 -->

    <!-- エラーメッセージ出力 -->
    <a href='account_view.php' class='form__msg'><?php echo $strErrMsg; ?></a>
<?php endif; ?>

<?php require_once './_footer_body.php'; ?>
