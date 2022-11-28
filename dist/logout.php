<?php
require_once './_header.php';

$_SESSION = [];
session_destroy();
header('Location: index.php');
?>