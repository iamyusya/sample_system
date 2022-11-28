<?php
/**
 * XSS対策：エスケープ処理
 * @param string $str
 * @return string $処理された文字列
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * CSRF対策
 * @param void
 * @return string $csrfToken
 */
function setToken() {
    $csrfToken = bin2hex(random_bytes(32));
    $_SESSION['csrfToken'] = $csrfToken;

    return $csrfToken;
}
?>