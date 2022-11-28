<?php
require_once '/home/users/0/oops.jp-portfolio/web/ryusha-design/classes/dbconnect.php';

class Dbq {
    /**
     * SQLの実行
     * @param string $strSQL $array
     * @return bool $result
     */


    public static function runSQL($strSQL, $array) {
        $result = false;
        try {
            $dbc = connect();
            $stmt = $dbc->prepare($strSQL);
            $stmt->execute($array);
            $result = true;
           
            return $result;
        } catch (\Exception $e) {
            return $result;
        }
    }

    /**
     * セレクト文生成
     * @param string $table
     * @return string $strSQL
     */
    public static function createSelectSQL($table) {
        $strSQL = "SELECT * FROM $table WHERE IsWaste = 0;";
        return $strSQL;
    }

    /**
     * レコード取得
     * @param string $table $id
     * @return bool $result
     */
    public static function selectSQL($table, $tableID, $id) {
        $strSQL = "SELECT * FROM $table WHERE $tableID = :id;";
        $result = false;

        try {
            $dbc = connect();
            $stmt = $dbc->prepare($strSQL);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch();
    
            return $row;
        } catch (\Exception $e) {
            return $result;
        }
    }

    /**
     * アップデート文（削除）作成、実行
     * @param string $table $id
     * @return bool $result
     */
    public static function updateFlagSQL($table, $tableID, $id) {
        $m_dtmNow = time();
        $strSQL = "UPDATE $table SET IsWaste = 1, UpdateTime = ' " . date("Y/m/d H:i:s", $m_dtmNow) . " ' WHERE $tableID = :id;";
        $result = false;

        try {
            $dbc = connect();
            $stmt = $dbc->prepare($strSQL);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = true;
    
            return $result;
        } catch (\Exception $e) {
            return $result;
        }
    }
}

?>