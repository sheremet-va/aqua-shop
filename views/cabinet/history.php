<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="row">
    <div id="sidebar" class="span3">
        <div class="well well-small">
            <ul class="nav nav-list">
                <li><a href="/cabinet/edit"><span class="icon-chevron-right"></span>Редактировать данные</a></li>
                <li class="active"><a href="/cabinet/history"><span class="icon-chevron-right"></span>Список покупок</a></li>
            </ul>
        </div>
    </div>
<?php foreach ($ordersList as $number => $order): ?>
<div class="span3"></div>
<div class="span9">
<div class="well well-small">
    <h5>Информация о заказе #<?php echo $order['id']; ?></h5>
    <table class="table-admin-small table-bordered table-striped table">
        <tr>
            <td><b>Номер заказа</b></td>
            <td><b><?php echo $order['id']; ?></b></td>
        </tr>
        <?php if ($order['user_comment'] != 0): ?>
        <tr>
            <td>Комментарий</td>
            <td><?php echo $order['user_comment']; ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>Статус заказа</td>
            <td><?php echo Order::getStatusText($order['status']); ?></td>
        </tr>
        <tr>
            <td>Тип доставки</td>
            <td><?php echo Order::getDeliveryText($order['delivery']); ?></td>
        </tr>
        <tr>
            <td>Дата открытия заказа</td>
            <td><?php echo $order['date']; ?></td>
        </tr>
        <?php if ($order['closing_date'] != 0): ?>
        <tr>
            <td>Дата закрытия заказа</td>
            <td><?php echo $order['closing_date']; ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($order['user_city'] != 0 && $order['user_appartment'] != 0): ?>
        <tr>
            <td>Адрес</td>
            <td><?php echo $order['user_city'] . ", " . $order['user_street'] . ", " . $order['user_house'] . ", " . $order['user_appartment'];?></td>
        </tr>
        <?php endif; ?>
        <?php if ($order['user_city'] != 0 && $order['user_appartment'] == 0): ?>
        <tr>
            <td>Адрес</td>
            <td><?php echo $order['user_city'] . ", " . $order['user_street'] . ", " . $order['user_house'];?></td>
        </tr>
        <?php endif; ?>
    </table>

    <table class="table-admin-medium table-bordered table-striped table ">
        <tr>
            <th>ID товара</th>
            <th>Артикул товара</th>
            <th>Название</th>
            <th>Цена в заказе</th>
            <th>Количество</th>
        </tr>
        <h5>Товары в заказе</h5>
                <?php foreach ($products[$number] as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['articul']; ?></td>
                        <td><a href='/product/<?php echo $product['id']; ?>'><?php echo $product['name']; ?></a></td>
                        <td><?php echo $order['products_prices'][$product['id']]; ?> ₽</td>
                        <td><?php echo $order['products'][$product['id']];; ?></td>
                    </tr>
                <?php endforeach; ?>
		<tr>
                  <td colspan="3" class="alignR">Итоговая стоимость:</td>
                  <th colspan="2" id="total-price"><?php echo $totalPrice[$number];?> ₽</th>
                </tr>
            </table>
</div></div>
<?php endforeach; ?>
<div class="span3"></div>
<div class="span8">
<?php echo $pagination->get(); ?>
</div>
<?php include ROOT . '/views/layouts/footer.php'; ?>