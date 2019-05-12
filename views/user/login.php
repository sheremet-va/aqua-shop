<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div id="sidebar" class="span3">
    <div class="well well-small">
        <ul class="nav nav-list">
            <?php foreach ($categories as $categoryItem): ?>
            <li><a href="/category/<?php echo $categoryItem['id'];?>"><span class="icon-chevron-right"></span><?php echo $categoryItem['name'];?></a></li>
            <?php endforeach; ?>
            <li style="border:0"> &nbsp;</li>
            <li><a class="totalInCart" href="/"><strong>Общая стоимость:  <span class="badge badge-warning pull-right" style="line-height:18px;"id="left-price-count"> <?php echo Cart::getTotalPriceFromStart(); ?> ₽</span></strong></a></li>
	</ul>
    </div>
    </div>
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="/">Главная</a> <span class="divider">/</span></li>
            <li class="active">Вход</li>
        </ul>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>	
	<div class="row">
            <div class="span4">
                <div class="well">
                    <form action="#" method="post" style="margin: 0;">
                      <div class="control-group">
                        <label class="control-label" for="inputLogin">Логин</label>
                        <div class="controls">
                            <input class="span3" name="login" type="text" placeholder="Логин" value="<?php echo $login; ?>">
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label" for="inputPassword">Пароль</label>
                        <div class="controls">
                            <input type="password" name="password" class="span3" placeholder="Пароль">
                        </div>
                      </div>
                      <div class="control-group">
                        <div class="controls">
                            <input type="submit" name="submit" class="defaultBtn" value="Вход"/> <a href="/user/register">Не зарегистрированы?</a>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
	</div>		
    </div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>