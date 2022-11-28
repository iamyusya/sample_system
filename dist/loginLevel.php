<?php
if ($_SESSION['securityLevel'] > 10000) {
    header("location: index.php");
    exit();
}
?>