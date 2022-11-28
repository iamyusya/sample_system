<?php
require_once './_header.php';
?>
<header class="l-header">
        <div class="l-header__inner">
            <p class="l-header__name"><?php echo $_SESSION['loginUser']['AccountName']; ?></p>
            <nav class="l-header-nav js-nav">
                <ul class="l-header-nav__list">
                    <li class="l-header-nav__item">
                        <a href="user_view.php" class="l-header-nav__link">顧客管理</a>
                    </li>
                    <li class="l-header-nav__item">
                        <a href="sales_view.php" class="l-header-nav__link">売上管理</a>
                    </li>
                    <li class="l-header-nav__item">
                        <a href="account_view.php" class="l-header-nav__link">アカウント管理</a>
                    </li>
                    <li class="l-header-nav__item">
                        <a href="" class="l-header-nav__link">パスワード変更</a>
                    </li>
                    <li class="l-header-nav__item">
                        <a href="logout.php" class="l-header-nav__link">ログアウト</a>
                    </li>
                </ul>
            </nav>
            <button class="l-header-hamburger js-hamburger">
                <span class="l-header-hamburger__bar"></span>
                <span class="l-header-hamburger__bar"></span>
                <span class="l-header-hamburger__bar"></span>
            </button>
        </div>