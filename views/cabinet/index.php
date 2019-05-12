<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div id="sidebar" class="span3">
        <div class="well well-small">
            <ul class="nav nav-list">
                <li><a href="/cabinet/edit"><span class="icon-chevron-right"></span>Редактировать данные</a></li>
                <li><a href="/cabinet/history"><span class="icon-chevron-right"></span>Список покупок</a></li>
            </ul>
        </div>
    </div>
<div class="well well-small span8">
    <h3>Кабинет пользователя</h3>
    <h3>Здравствуйте, <?php echo $user['name'];?>!</h3>
    <p>Имя: <?php echo $user['name'];?></p>
    <p>Фамилия: <?php echo $user['surname'];?></p>
    <p>Отчество: <?php echo $user['fathersname'];?></p>
    <p>Логин: <?php echo $user['login'];?></p>
    <p>E-mail: <?php echo $user['email'];?></p>
    <p>Телефон: <?php echo $user['phone'];?></p>
    <p>Дата рождения: <?php echo $user['birthdate'];?></p>
    <p>Пол: <?php echo $user['gender'];?></p>
    <p>Город: <?php echo $user['city'];?></p>
    <p>Улица: <?php echo $user['street'];?></p>
    <p>Дом: <?php echo $user['house'];?></p>
    <p>Квартира: <?php echo $user['appartment'];?></p>
</div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>