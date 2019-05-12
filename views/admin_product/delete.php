<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a> <span class="divider">/</span></li>
                    <li><a href="/admin/product">Управление товарами</a> <span class="divider">/</span></li>
                    <li class="active">Удалить товар</li>
                </ol>
            </div>


	<div class="well well-small">
            <h4>Удалить товар «<?php echo $product['name']; ?>»</h4>


            <p>Вы действительно хотите удалить этот товар?</p>

            <form method="post">
                <input  class="btn btn-default back" type="submit" name="submit" value="Удалить" />
            </form>

        </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>