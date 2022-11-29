<?php
session_start();

require_once './classes/dbQuery.php';
require_once './classes/dbconnect.php';
require_once './security.php';

// notice以外のエラーを表示
error_reporting(E_ALL & ~ E_NOTICE);
// ini_set("display_errors", 1);


// 現在時刻
$m_dtmNow = time();

// $_SESSIONがからの場合10000を入れる（10000の場合アクセスできない）
if (!isset($_SESSION['securityLevel'])) {
    $_SESSION['securityLevel'] = 10000;
} 
?>