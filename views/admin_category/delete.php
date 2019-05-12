<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/category">Управление категориями</a> <span class="divider">/</span></li>
                    <li class="active">Удалить категорию</li>
                </ol>
            </div>


	<div class="well well-small">
            <h4>Удалить категорию #<?php echo $id; ?></h4>


            <p>Вы действительно хотите удалить эту категорию?</p>

            <form method="post">
                <input class="btn btn-default back" type="submit" name="submit" value="Удалить" />
            </form>

        </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

