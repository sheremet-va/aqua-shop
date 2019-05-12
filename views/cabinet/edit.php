<?php include ROOT . '/views/layouts/header.php'; ?>

<div class="row">
    <div id="sidebar" class="span3">
        <div class="well well-small">
            <ul class="nav nav-list">
                <li class="active"><a href="/cabinet/edit"><span class="icon-chevron-right"></span>Редактировать данные</a></li>
                <li><a href="/cabinet/history"><span class="icon-chevron-right"></span>Список покупок</a></li>
            </ul>
        </div>
    </div>
<div class="well well-small span8">
        <div class="signup-form"><!--sign up form-->
            <h2>Редактирование данных</h2>        
    <?php if ($result): ?>
        <p>Данные отредактированы!</p>
    <?php else: ?>
    <?php if (isset($errors) && is_array($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
        <form action="#" method="post">
            <div class="span3">            
                <p>Имя:</p>
                <input type="text" name="name" placeholder="Имя" value="<?php echo $name; ?>"/>
                <p>Фамилия:</p>
                <input type="text" name="surname" placeholder="Фамилия" value="<?php echo $surname; ?>"/>
                <p>Отчество:</p>
                <input type="text" name="fathersname" placeholder="Отчество" value="<?php echo $fathersname; ?>"/>
                <p>E-mail:</p>
                <input type="text" name="email" placeholder="Email" value="<?php echo $email; ?>"/>
                <p>Телефон:</p>
                <input type="text" name="phone" placeholder="Телефон" value="<?php echo $phone; ?>"/>
            </div>
            <div class="span4">
                <p>Логин:</p>
                <input type="text" name="login" placeholder="Логин" value="<?php echo $login; ?>"/>
                <p>Дата рождения:</p>
                <input type="text" id="inputBdate" value="<?php echo $birthdate; ?>" onfocus="(this.type='date')"  name="birthdate"> 
                <p>Пол:</p>
                <select name="gender">
                    <option value="">-</option>
                    <option value="Мужской">Мужской</option>
                    <option value="Женский">Женский</option>
		</select>
                            
                <p>Новый пароль:</p>
                <input type="password" name="new_password" placeholder="Новый пароль"/>
                            
                <p>Подтвердите старым паролем:</p>
                <input type="password" name="password" required placeholder="Пароль"/>
                <div class="clr"></div>
            </div>
            <div class="span4">            
                <p>Город:</p>
                <input type="text" name="city" placeholder="Город" value="<?php echo $city; ?>"/>
                <p>Улица:</p>
                <input type="text" name="street" placeholder="Улица" value="<?php echo $street; ?>"/>
                <p>Дом:</p>
                <input type="text" name="house" placeholder="Дом" value="<?php echo $house; ?>"/>
                <p>Квартира:</p>
                <input type="text" name="appartment" placeholder="Квартира" value="<?php echo $appartment; ?>"/>
            </div>
        <input type="submit" name="submit" class="btn btn-default" value="Сохранить" style="margin-top: 28px; margin-left: 18px;"/>
        </form>
                
        <?php endif; ?>
        </div><!--/sign up form-->
</div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>