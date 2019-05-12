<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/procurement">Управление накладными</a> <span class="divider">/</span></li>
                    <li class="active">Просмотр накладной</li>
                </ol>
            </div>


	<div class="well well-small">
            <h4>Просмотр накладной #<?php echo $con['id']; ?></h4>

            <h5>Информация о накладной</h5>
            <table class="table-admin-small table-bordered table-striped table">
                <tr>
                    <td>Номер накладной</td>
                    <td><?php echo $con['id']; ?></td>
                </tr>
                <tr>
                    <td><b>Дата накладной</b></td>
                    <td><?php echo $con['date']; ?></td>
                </tr>
            </table>

            <h5>Товары в накладной</h5>

            <table class="table-admin-medium table-bordered table-striped table ">
                <tr>
                    <th>ID товара</th>
                    <th>Артикул товара</th>
                    <th>Название</th>
                    <th>Стоимость</th>
                    <th>Количество</th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['articul']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $productsPrices[$product['id']]; ?> ₽</td>
                        <td><?php echo $productsQuantity[$product['id']]; ?></td>
                    </tr>
                <?php endforeach; ?>
		<tr>
                  <td colspan="3" class="alignR">Итоговая стоимость:</td>
                  <th colspan="3" id="total-price"><?php echo $totalCost;?> ₽</th>
                </tr>
            </table>

            <a href="/admin/procurement/" class="btn btn-default back"><i class="icon-arrow-left"></i> Назад</a>
            <br/><br/>
        </div>
        </div>


</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

