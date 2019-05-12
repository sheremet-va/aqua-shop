<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/order">Управление заказами</a> <span class="divider">/</span></li>
                    <li class="active">Удалить заказ</li>
                </ol>
            </div>


	<div class="well well-small">
            <h4>Удалить заказ #<?php echo $id; ?></h4>


            <p>Вы действительно хотите удалить этот заказ?</p>

            <form method="post">
                <input class="btn btn-default back" type="submit" name="submit" value="Удалить" />
            </form>
        </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

