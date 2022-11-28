<?php 
require_once '/home/users/0/oops.jp-portfolio/web/ryusha-design/classes/dbconnect.php';


class loginLogic {

    /**
     * ログインID、パスワードの照合
     * @param string $loginID
     * @param string $loginID $password
     * @return bool $result
     */
    public static function login($loginID, $password) {
        $result = false;

        //getLoginIDを引用
        $account = self::getLoginID($loginID);

        // 配列が空の場合
        if (!$account) {
            // sessionにエラーを入れる
            $_SESSION['strErrMsg'] = "'ログインID'か'パスワード'が一致しません";
            // falseを返す
            return $result;
        }

        // パスワード（ログインフォームで入力した）がログインIDのレコードと同じ場合
        if ($password === $account['AccountLoginPassword']) {
            // sessionID再生成
            session_regenerate_id(true);
            // アカウント情報をsessionに入れる
            $_SESSION['loginUser'] = $account;
            $result = true;
            // trueを返す
            return $result;
        }
        // sessionにエラーを入れる
        $_SESSION['strErrMsg'] = "'ログインID'か'パスワード'が一致しません";
        // falseを返す
        return $result;
    }

    /**
     * ログインIDのレコード取得
     * @param string $loginID
     * @return array|bool $account|false
     */
    public static function getLoginID($loginID) {
        // MstAccountからログインIDが同じレコードを取得
        $strSQL = "SELECT * FROM MstAccount 
        WHERE IsWaste = 0 
        AND AccountLoginID = :loginID;";

        try {
            $dbc = connect();
            $stmt = $dbc->prepare($strSQL);
            $stmt->bindValue(':loginID', $loginID, PDO::PARAM_STR);
            $stmt->execute();
            // SQLの結果を返す
            $account = $stmt->fetch();
            return $account;
        } catch(\Exception $e) {
            return false;
        }
    }
}
?>