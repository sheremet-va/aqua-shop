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
<!-- 
	Upper Header Section 
-->
<div id ="wrap">
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="topNav">
        <div class="container">
            <div class="alignR">
            <!--<div class="search_area" style="float: left">
             <form action="/admin/search/" method="GET" class="navbar-search" style="margin-top: 3px;">
                <input type="text" id="search_box" autocomplete="off" placeholder="Поиск" name="query" class="span3" style="margin-bottom: 0px;">
                <button type="submit" class="btn btn-default" style="margin-top: 0;"><i class="icon-search"></i></button>
            </form>
                <div id="search_advice_wrapper"></div> 
            </div>-->
                <?php if (User::isSalseman()): ?><a class="active" href="/admin"><span class="icon-lock"></span> Кабинет продавца </a><?php endif;?>
                <?php if (!User::isSalseman()): ?><a class="active" href="/admin"><span class="icon-lock"></span> Панель администратора </a><?php endif;?>
                <a href="/"><span class="icon-user"></span> На сайт</a>
            </div>
        </div>
    </div>
</div>