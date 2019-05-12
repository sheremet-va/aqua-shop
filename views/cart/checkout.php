<?php include ROOT . '/views/layouts/header.php'; ?>

<div class="row">
    <div class="span12">
	<div class="well well-small">
            <h1>Корзина</h1>
	<hr class="soften"/>
        <?php if ($result): ?>

            <p>Заказ оформлен. Мы Вам перезвоним. Номер вашего заказа: <?php echo $result; ?>.</p>

        <?php else: ?>

            <p>Выбрано товаров: <?php echo $totalQuantity; ?>, на сумму: <?php echo $totalPrice; ?> ₽</p><br/>

            <div class="col-sm-4">
                <?php if (isset($errors) && is_array($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <p>Для оформления заказа заполните форму. Наш менеджер свяжется с Вами.</p>

                <div class="login-form">
                    <form class="form-horizontal auth" method="POST" action="#">
                        <div class="control-group">
                            <label class="control-label" for="inputName">Имя</label>
                            <div class="controls">
                                <input type="text" id="inputName" name="userName" placeholder="Имя" value="<?php echo $userName; ?>" required>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="inputPhone">Номер телефона</label>
                            <div class="controls">
                                <input type="text" id="inputPhone" name="userPhone" placeholder="Номер телефона" value="<?php echo $userPhone; ?>" required>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label">Доставка</label>
                            <div class="controls">
                                <input type="radio" name="delivery" value="0" id="closeAddress" checked> <label style="display: inline;" for="closeAddress">Нет</label>
                                <input type="radio" name="delivery" value="1" id="openAddress"> <label style="display: inline;" for="openAddress">Да</label>
                            </div>
                        </div>
                        
                        <div class="address" style="display: none">
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
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label" for="inputComment">Комментарий к заказу</label>
                            <div class="controls">
                                <input type="text" id="inputComment" name="userComment" placeholder="Комментарий" value="<?php echo $userComment; ?>">
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="controls">
                                <input type="submit" name="submit" class="exclusive shopBtn" value="Оформить" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php endif; ?>
	<a href="/cart" class="shopBtn btn-large"><span class="icon-arrow-left"></span> Назад </a>

        </div>
    </div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>

<script>
$("#closeAddress").click(function() {
    $(".address").css('display', 'none');
    $(".address .required").prop('required', false);
});
$("#openAddress").click(function() {
    $(".address").css('display', 'block');
    $(".address .required").prop('required', true);
});
</script>