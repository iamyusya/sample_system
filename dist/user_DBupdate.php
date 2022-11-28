<?php
require_once './_header.php'; 
require_once './loginLevel.php';
// トークンがあれば変数に入れる
$token = filter_input(INPUT_POST, 'csrfToken');

// トークンがない場合　未実装
// if (!isset($_SESSION['csrfToken']) || $token !== $_SESSION['csrfToken']) {
//     exit('不正なアクセスです');
// } 
// トークン削除
unset($_SESSION['csrfToken']);

// 変数初期化
$strErrMsg = '';
// 削除機能
if (isset($_GET['tp']) && $_GET['tp'] === 'waste') {
    // 変数にidを入れる
    $lngUserID = intval($_GET['id']);
    // 削除失敗の場合
    if (!$result = Dbq::updateFlagSQL('MstUser', 'UserID', $lngUserID)) {
        // 変数にエラーメッセージを入れる
        $strErrMsg = '削除に失敗しました';
    }
    
} else {
    // idがあったらidを、ないなら-1を入れる（クローラー対策）
    $lngUserID = isset($_POST['id']) ? intval($_POST['id']) : intval(-1);

    if ($lngUserID === -1) {
        // 変数にエラーメッセージを入れる
        $strErrMsg = "不正なアクセスです！";
    } else {
        // 新規追加
        if ($lngUserID === 0) {
            // 変数にSQL文を入れる
            $strSQL = "INSERT INTO MstUser (
            UserName,
            UserKana,
            UserZipCode,
            UserAddress1,
            UserAddress2,
            IsWaste,
            AddTime,
            UpdateTime
            )
            VALUES (?, ?, ?, ?, ?, 0,
            ' " . date("Y/m/d H:i:s", $m_dtmNow) . " ',
            ' " . date("Y/m/d H:i:s", $m_dtmNow) . " '
            );";
            $array = [];
            // 配列にPOSTの値を入れる
            $array =[
                $_POST['UserName'], 
                $_POST['UserKana'], 
                $_POST['UserZipCode'], 
                $_POST['UserAddress1'], 
                $_POST['UserAddress2']
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
            $strSQL = "UPDATE MstUser SET 
            UserName = ?,
            UserKana = ?,
            UserZipCode = ?,
            UserAddress1 = ?,
            UserAddress2 = ?,
            UpdateTime = ' " . date("Y/m/d H:i:s", $m_dtmNow) . " ' 
            WHERE UserID = ?;";

            $array = [];
            // 配列にPOSTの値を入れる
            $array = [
                h($_POST['UserName']), 
                h($_POST['UserKana']), 
                h($_POST['UserZipCode']), 
                h($_POST['UserAddress1']), 
                h($_POST['UserAddress2']),
                $lngUserID
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
    header('Location: user_view.php'); 
    exit();
?>
<?php else : ?> 
    <!-- エラーがある場合 -->

    <!-- エラーメッセージ出力 -->
    <a href='user_view.php' class='form__msg'><?php echo $strErrMsg; ?></a>
<?php endif; ?>

<?php require_once './_footer_body.php'; ?>
