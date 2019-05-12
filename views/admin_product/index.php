<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li class="active">Управление товарами</li>
                </ol>
            </div>

	<div class="well well-small">
            <a href="/admin/product/create" class="btn btn-default back"><i class="icon-plus"></i> Добавить товар</a>
            
            <h4>Список товаров</h4>            
            
            <?php if (isset($error)): ?>
                <ul>
                    <li><?php echo $error; ?></li>
                </ul>
            <?php endif; ?>

            <p>Введите название или id товара:</p>
            <form action="" method="post"><input type="text" name="productSearch" placeholder="" value=""> <input type="submit" name="submit" class="shopBtn" value="Редактировать"></form>

            
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID товара</th>
                    <th>Артикул</th>
                    <th>Название товара</th>
                    <th>Цена</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($productsList as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['articul']; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?> ₽</td>  
                        <td style="text-align: center;"><a href="/admin/product/update/<?php echo $product['id']; ?>" title="Редактировать" class="shopBtn"><span class="icon-edit"></span></a></td>
                        <td style="text-align: center;"><a href="/admin/product/delete/<?php echo $product['id']; ?>" title="Удалить" class="shopBtn"><span class="icon-trash"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
        </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

