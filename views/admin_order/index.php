<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>
                        
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li class="active">Управление заказами</li>
                </ol>
            </div>

	<div class="well well-small">
            <h4>Список заказов</h4>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                <li class="warning"><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
         <?php endif; ?>
            <div class="span5">
                <p>Введите id заказа:</p>
                <input type="text" name="orderSearch" placeholder="" value=""> <a name="submit" class="shopBtn view" href="#">Просмотреть</a>
            </div>
            <div class="span5">
                <p>Найти заказы покупателя:</p>
                <form action="" method="POST"><input type="text" name="orderByNameSearch" placeholder="" value=""> <input type="submit" name="submit_by_name" class="shopBtn exclusive" value="Просмотреть"></form>
            </div>
            <div class="span5"><form action="" method="POST"><input type="submit" name="return" class="shopBtn exclusive" value="Открыть весь список"></form></div>
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID заказа</th>
                    <th>Имя покупателя</th>
                    <th>Телефон покупателя</th>
                    <th>Дата оформления</th>
                    <th>Статус</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($ordersList as $order): ?>
                    <tr>
                        <td>
                            <a href="/admin/order/view/<?php echo $order['id']; ?>">
                                <?php echo $order['id']; ?>
                            </a>
                        </td>
                        <td><?php echo $order['user_name']; ?></td>
                        <td><?php echo $order['user_phone']; ?></td>
                        <td><?php echo $order['date']; ?></td>
                        <td><?php echo Order::getStatusText($order['status']); ?></td>    
                        <td><a href="/admin/order/view/<?php echo $order['id']; ?>" title="Смотреть" class="shopBtn"><span class="icon-eye-open"></span></a></td>
                        <td><a href="/admin/order/update/<?php echo $order['id']; ?>" title="Редактировать" class="shopBtn"><span class="icon-edit"></span></a></td>
                        <td><a href="/admin/order/delete/<?php echo $order['id']; ?>" title="Удалить" class="shopBtn"><span class="icon-trash"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

<script>
$(document).ready(function(){
    $(".view").click(function () {
        var id = $('input[name="orderSearch"]').val();
        var url = "http://aqua-shop.ru/admin/order/view/" + id;
        $(location).attr('href',url);
    });
});
</script>