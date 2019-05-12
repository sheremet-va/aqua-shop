<?php include ROOT . '/views/layouts/header.php'; ?>

<?php if (!User::isGuest()): header("Location: /cabinet/"); endif; ?>

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
            <li class="active">Регистрация</li>
        </ul>
        <?php if ($result): ?>
            <p class="success">Вы зарегистрированы!</p>
        <?php else: ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                <li class="warning"><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
         <?php endif; endif; ?>
	<div class="well">
            <form class="form-horizontal auth" method="POST" action="#">
                <h3 style="margin-top: 0;">Персональная информация</h3>
                <div class="control-group">
                    <label class="control-label" for="inputFname">Имя <sup>*</sup></label>
                    <div class="controls">
                        <input type="text" id="inputName" name="name" placeholder="Имя" value="<?php echo $name; ?>">
                    </div>
                 </div>
                 <div class="control-group">
                    <label class="control-label" for="inputLname">Фамилия <sup>*</sup></label>
                    <div class="controls">
                        <input type="text" id="inputLname" name="surname" placeholder="Фамилия" value="<?php echo $surname; ?>">
                    </div>
                 </div>
                 <div class="control-group">
                    <label class="control-label" for="inputLname">Отчество</label>
                    <div class="controls">
                        <input type="text" id="inputFname" name="fathersname" placeholder="Отчество" value="<?php echo $fathersname; ?>">
                    </div>
                 </div>
                <div class="control-group">
                    <label class="control-label">Пол</label>
                    <div class="controls">
                        <select class="span1" name="gender">
                            <option value="">-</option>
                            <option value="Мужской">Мужской</option>
                            <option value="Женский">Женский</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Дата рождения</label>
                    <div class="controls">
                        <input type="date" id="inputBdate" name="birthdate" placeholder="Дата рождения">
                    </div>
                </div>
                <h3>Безопасность</h3>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Email <sup>*</sup></label>
                    <div class="controls">
                        <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputLogin">Логин (по желанию)</label>
                    <div class="controls">
                        <input type="text" name="login" placeholder="Логин" value="<?php echo $login; ?>">
                        <span style="display: block;">Если отсутствует, логином считается Email.</span>
                    </div>                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Телефон <sup>*</sup></label>
                    <div class="controls">
                        <input type="tel" name="phone" maxlength="10" placeholder="Телефон (без +7)" value="<?php echo $phone; ?>">
                    </div>
                </div>	  
                <div class="control-group">
                    <label class="control-label">Пароль <sup>*</sup></label>
                    <div class="controls">
                        <input type="password" name="password" placeholder="Пароль">
                        <span style="display: block;">Попробуйте такой пароль: <?php echo User::generatePassword(); ?></span>
                    </div>                
                </div>	  
                <div class="control-group">
                    <label class="control-label">Подтвердите пароль <sup>*</sup></label>
                    <div class="controls">
                        <input type="password" name="password_check" placeholder="Подтвердите пароль">
                    </div>
                </div>                
                <h3>Адрес</h3>
                <div class="control-group">
                    <label class="control-label" for="inputCity">Город</label>
                    <div class="controls">
                        <input type="text" class="required" id="inputCity" name="userCity" placeholder="Город" value="<?php echo $userCity; ?>">
                    </div>  
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputStreet">Улица</label>
                    <div class="controls">
                        <input type="text" class="required" id="inputStreet" name="userStreet" placeholder="Улица" value="<?php echo $userStreet; ?>">
                    </div>  
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputHouse">Дом</label>
                    <div class="controls">
                        <input type="text" class="required" id="inputHouse" name="userHouse" placeholder="Дом" value="<?php echo $userHouse; ?>">
                    </div>  
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputAppartment">Квартира</label>
                    <div class="controls">
                        <input type="text" id="inputAppartment" name="userAppartment" placeholder="Квартира" value="<?php echo $userAppartment; ?>">
                    </div>  
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" name="submit" value="Регистрация" class="exclusive shopBtn">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>

<script>
$("#add").click(function() {
    $(".address").css('display', 'none');
    $(".address .required").prop('required', false);
});
$("#openAddress").click(function() {
    $(".address").css('display', 'block');
    $(".address input").prop('required', true);
});
</script>