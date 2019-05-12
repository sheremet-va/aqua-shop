<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/order">Управление заказами</a> <span class="divider">/</span></li>
                    <li class="active">Редактировать заказ</li>
                </ol>
            </div>


	<div class="well admin-well">
            <h4>Редактировать заказ #<?php echo $id; ?></h4>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post">
                        <div class="span4">
                        <p>Имя клиента</p>
                        <input type="text" name="userName" placeholder="" value="<?php echo $order['user_name']; ?>">

                        <p>Телефон клиента</p>
                        <input type="text" name="userPhone" placeholder="" value="<?php echo $order['user_phone']; ?>">

                        <p>Комментарий клиента</p>
                        <input type="text" name="userComment" placeholder="" value="<?php echo $order['user_comment']; ?>">

                        <p>Дата оформления заказа</p>
                        <input type="text" name="date" placeholder="" value="<?php echo $order['date']; ?>">

                        <p>Статус</p>
                        <select name="status">
                            <option value="1" <?php if ($order['status'] == 1) echo ' selected="selected"'; ?>>Новый заказ</option>
                            <option value="2" <?php if ($order['status'] == 2) echo ' selected="selected"'; ?>>В обработке</option>
                            <option value="3" <?php if ($order['status'] == 3) echo ' selected="selected"'; ?>>Доставляется</option>
                            <option value="4" <?php if ($order['status'] == 4) echo ' selected="selected"'; ?>>Закрыт</option>
                            <option value="5" <?php if ($order['status'] == 5) echo ' selected="selected"'; ?>>Отменён</option>
                        </select>
                        <br>
                        <br>
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                        </div>
                        <div class="span4">
                        <p>Нужна ли доставка</p>
                        <select name="delivery">
                            <option value="0" <?php if ($order['delivery'] == 0) echo ' selected="selected"'; ?>>Без доставки</option>
                            <option value="1" <?php if ($order['delivery'] == 1) echo ' selected="selected"'; ?>>Нужна доставка</option>
                        </select>
                        <div class="control-group">
                                <label class="control-label" for="inputCity">Город</label>
                                <div class="controls">
                                    <input type="text" id="inputCity" name="userCity" placeholder="Город" value="<?php echo $order['user_city']; ?>">
                                </div>  
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputStreet">Улица</label>
                                <div class="controls">
                                    <input type="text" id="inputStreet" name="userStreet" placeholder="Улица" value="<?php echo $order['user_street']; ?>">
                                </div>  
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputHouse">Дом</label>
                                <div class="controls">
                                    <input type="text" id="inputHouse" name="userHouse" placeholder="Дом" value="<?php echo $order['user_house']; ?>">
                                </div>  
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputAppartment">Квартира</label>
                                <div class="controls">
                                    <input type="text" id="inputAppartment" name="userAppartment" placeholder="Квартира" value="<?php echo $order['user_appartment']; ?>">
                                </div>  
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

