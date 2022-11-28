<?php
require_once './_header.php';
require_once './classes/loginLogic.php';

// 変数初期化
$strErrMsg = [];

// トークンがあれば変数に入れる
$token = filter_input(INPUT_POST, 'csrfToken');
// 変数に入れる 
$loginID = filter_input(INPUT_POST, 'loginID');
$password = filter_input(INPUT_POST, 'password');

// トークンがない場合 未実装
// if (!isset($_SESSION['csrfToken']) || $token !== $_SESSION['csrfToken']) {
//     exit('不正なアクセスです');
// }

// トークン削除
unset($_SESSION['csrfToken']);

// 変数がからの場合、変数にエラーを入れる
if (!$loginID) {
    $strErrMsg['strErrLogin'] = "'ログインID'を記入してください";
}
if (!$password) {
    $strErrMsg['strErrPassword'] = "'パスワード'を記入してください";
}

// エラーの数が1つ以上ある場合
if (count($strErrMsg) > 0) {
    // SESSIONにエラーを入れる
    $_SESSION = $strErrMsg;
    // ログインフォームへ飛ばす
    header('Location: index.php');
    exit();
}
// インスタンス作成
$result = loginLogic::login($loginID, $password);
// ログイン失敗
if (!$result) {
    // ログインフォームへ飛ばす
    header('Location: index.php');
    exit();
} 
// ログイン成功
// securityLevelにAccountSecurityLevelを入れる
$_SESSION['securityLevel'] = $_SESSION['loginUser']['AccountSecurityLevel'];
// 顧客管理に飛ばす
header('Location: user_view.php');
exit();
?>