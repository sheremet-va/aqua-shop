<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li class="active">Управление категориями</li>
                </ol>
            </div>

	<div class="well well-small">
            <a href="/admin/category/create" class="btn btn-default back"><i class="icon-plus"></i> Добавить категорию</a>
            
            <h4>Список категорий</h4>
            <p>Введите название или id категории:</p>
            <form action="" method="post"><input type="text" name="categorySearch" placeholder="" value=""> <input type="submit" name="submit" class="shopBtn" value="Редактировать"></form>
            
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID категории</th>
                    <th>Название категории</th>
                    <th>Порядковый номер</th>
                    <th>Статус</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($categoriesList as $category): ?>
                    <tr>
                        <td><?php echo $category['id']; ?></td>
                        <td><?php echo $category['name']; ?></td>
                        <td><?php echo $category['sort_order']; ?></td>
                        <td><?php echo Category::getStatusText($category['status']); ?></td>  
                        <td style="text-align: center;"><a href="/admin/category/update/<?php echo $category['id']; ?>" title="Редактировать" class="shopBtn"><span class="icon-edit"></span></a></td>
                        <td style="text-align: center;"><a href="/admin/category/delete/<?php echo $category['id']; ?>" title="Удалить" class="shopBtn"><span class="icon-trash"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            
        </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

