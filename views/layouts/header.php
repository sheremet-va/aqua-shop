<?php if (!isset($title)): $title = "Магазин аквариумных рыбок"; endif; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title; ?> — Магазин аквариумных рыбок</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap styles -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- Customize styles -->
    <link href="/assets/css/main.css" rel="stylesheet"/>
    <!-- font awesome styles -->
	<link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
		<!--[if IE 7]>
			<link href="css/font-awesome-ie7.min.css" rel="stylesheet">
		<![endif]-->

		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

	<!-- Favicons -->
    <link rel="shortcut icon" href="/assets/ico/favicon.ico">
  </head>
<body>
<div id="wrap">
<!-- 
	Upper Header Section 
-->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="topNav">
        <div class="container">
            <div class="alignR">
                <?php if (User::isAdmin()): ?><a href="/admin"><span class="icon-lock"></span> Панель администратора </a><?php endif;?>
                <?php if (User::isGuest()): ?>
                <a <?php if (Site::isIndexActive("user", "login")): ?>class="active"<?php endif; ?> href="/user/login"><span class="icon-user"></span> Войти </a> 
                <?php else: ?>
                <a <?php if (Site::isIndexActive("cabinet")): ?>class="active"<?php endif; ?> href="/cabinet/"><span class="icon-user"></span> Мой аккаунт</a> 
                <?php endif;?>
                <?php if (User::isGuest()): ?>
                <a <?php if (Site::isIndexActive("user", "register")): ?>class="active"<?php endif; ?> href="/user/register"><span class="icon-edit"></span> Регистрация </a> 
                <?php else: ?>
                <a href="/user/logout"><span class="icon-edit"></span> Выйти</a> 
                <?php endif;?>
                <a <?php if (Site::isIndexActive("cart")): ?>class="active"<?php endif; ?> href="/cart"><span class="icon-shopping-cart"></span> Корзина (<span id="cart-count"><?php echo Cart::countItems();?></span>) - <span class="badge badge-warning" id="price-count"> <?php echo Cart::getTotalPriceFromStart(); ?> ₽</span></a>
            </div>
        </div>
    </div>
</div>

<!--
Lower Header Section 
-->
<div class="container">
<div id="gototop"> </div>
<header id="header">
    <div class="row">
        <div class="span4">
            <h1><a class="logo" href="/"><span>Aqua-Shop</span> 
                <img src="/assets/img/aqua-shop-logo.png" alt="Aqua-Shop"></a>
            </h1>
        </div>
        <div class="span4"></div>
        <div class="span4 alignR">
            <p><br> <strong> Служба поддержки (24/7):  0800 1234 678 </strong><br><br></p>
            <a href="/cart" style="color: black"><span class="btn btn-mini">[ <span id="small-cart-count"><?php echo Cart::countItems();?></span> ] <span class="icon-shopping-cart"></span></span></a>
        </div>
    </div>
</header>

<!--
Navigation Bar Section 
-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
          <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="nav-collapse">
            <ul class="nav">
                <li <?php if (Site::isIndexActive("")): ?>class="active"<?php endif; ?>><a href="/">Главная</a></li>
                <li <?php if (Site::isIndexActive("catalog", "list") OR Site::isIndexActive("category-list")): ?>class="active"<?php endif; ?>><a href="/catalog/list">Список</a></li>
                <!-- <li><a href="/catalog/four">Четыре колонки</a></li> -->
            </ul>
            <div class="search_area">
                <form action="/search/" method="GET" class="navbar-search pull-right" style="padding-right: 9px;">
                    <input type="text" id="search_box" autocomplete="off" placeholder="Поиск" name="query" class="search-query span2">
                    <button type="submit" class="btn btn-default" style="margin-top: 0;"><i class="icon-search"></i></button>
                </form>
                <div id="search_advice_wrapper"></div>
            </div>
          </div>
        </div>
    </div>
</div>
