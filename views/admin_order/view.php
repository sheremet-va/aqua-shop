<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/order">Управление заказами</a> <span class="divider">/</span></li>
                    <li class="active">Просмотр заказа</li>
                </ol>
            </div>


	<div class="well well-small">
            <h4>Просмотр заказа #<?php echo $order['id']; ?></h4>

            <h5>Информация о заказе</h5>
            <table class="table-admin-small table-bordered table-striped table">
                <tr>
                    <td>Номер заказа</td>
                    <td><?php echo $order['id']; ?></td>
                </tr>
                <tr>
                    <td>Имя клиента</td>
                    <td><?php echo $order['user_name']; ?></td>
                </tr>
                <tr>
                    <td>Телефон клиента</td>
                    <td><?php echo $order['user_phone']; ?></td>
                </tr>
                <tr>
                    <td>Комментарий клиента</td>
                    <td><?php echo $order['user_comment']; ?></td>
                </tr>
                <?php if ($order['user_id'] != 0): ?>
                    <tr>
                        <td>ID клиента</td>
                        <td><?php echo $order['user_id']; ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td><b>Статус заказа</b></td>
                    <td><?php echo Order::getStatusText($order['status']); ?></td>
                </tr>
                <tr>
                    <td><b>Дата заказа</b></td>
                    <td><?php echo $order['date']; ?></td>
                </tr>
            </table>

            <h5>Товары в заказе</h5>

            <table class="table-admin-medium table-bordered table-striped table ">
                <tr>
                    <th>ID товара</th>
                    <th>Артикул товара</th>
                    <th>Название</th>
                    <th>Цена в заказе</th>
                    <th>Нынешняя цена</th>
                    <th>Количество</th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['articul']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $productsPrices[$product['id']]; ?> ₽</td>
                        <td><?php echo $product['price']; ?> ₽</td>
                        <td><?php echo $productsQuantity[$product['id']]; ?></td>
                    </tr>
                <?php endforeach; ?>
		<tr>
                  <td colspan="3" class="alignR">Итоговая стоимость:</td>
                  <th colspan="3" id="total-price"><?php echo $totalCost;?> ₽</th>
                </tr>
            </table>

            <a href="/admin/order/" class="btn btn-default back"><i class="icon-arrow-left"></i> Назад</a> <a href="/admin/order/update/<?php echo $order['id']; ?>" class="btn btn-default back"><i class="icon-edit"></i> Редактировать</a>
            <br/><br/>
        </div>
        </div>


</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

