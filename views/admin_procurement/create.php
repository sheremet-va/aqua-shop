<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li class="active">Добавление накладной</li>
                </ol>
            </div>
	<div class="well admin-well">
            <h4>Добавить накладную о закупленных товарах</h4>

            <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="col-lg-4">
                <div class="login-form">
                    <?php if ($idEntry): ?>
                    <p>Запись о закупленных товарах успешно добавлена в таблицу.</p>
                    <?php else: ?>                    
                    <p><!-- Заполнять необходимо либо первый, либо второй столбец (количество и цена обязательны). Если заполнены все столбцы, то приоритет отдаётся ID товара.-->
                    Все столбцы необходимы для заплнения.
                    </p>
                    <form action="#" method="post" enctype="multipart/form-data">
                        
                        <table id="productsTable" class="table-bordered table">
                        <tr>
                            <th>ID товара</th>
                            <!--<th>Название товара</th>-->
                            <th>Количество</th>
                            <th>Закупная цена</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="productID-1" placeholder="" value=""></td>
                            <!--<td><input type="text" name="productName-1" placeholder="" value=""></td>-->
                            <td><input type="text" name="productQuantity-1" placeholder="" value=""></td>
                            <td><input type="text" name="productCost-1" placeholder="" value=""></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="productID-2" placeholder="" value=""></td>
                            <!--<td><input type="text" name="productName-2" placeholder="" value=""></td>-->
                            <td><input type="text" name="productQuantity-2" placeholder="" value=""></td>
                            <td><input type="text" name="productCost-2" placeholder="" value=""></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="productID-3" placeholder="" value=""></td>
                            <!--<td><input type="text" name="productName-3" placeholder="" value=""></td>-->
                            <td><input type="text" name="productQuantity-3" placeholder="" value=""></td>
                            <td><input type="text" name="productCost-3" placeholder="" value=""></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="productID-4" placeholder="" value=""></td>
                            <!--<td><input type="text" name="productName-4" placeholder="" value=""></td>-->
                            <td><input type="text" name="productQuantity-4" placeholder="" value=""></td>
                            <td><input type="text" name="productCost-4" placeholder="" value=""></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="productID-5" placeholder="" value=""></td>
                            <!--<td><input type="text" name="productName-5" placeholder="" value=""></td>-->
                            <td><input type="text" name="productQuantity-5" placeholder="" value=""></td>
                            <td><input type="text" name="productCost-5" placeholder="" value=""></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="productID-6" placeholder="" value=""></td>
                            <!--<td><input type="text" name="productName-6" placeholder="" value=""></td>-->
                            <td><input type="text" name="productQuantity-6" placeholder="" value=""></td>
                            <td><input type="text" name="productCost-6" placeholder="" value=""></td>
                        </tr>
                        </table>
                        <input type="button" class="shopBtn" id="addProduct" value="Добавить товар">
                        <br><br>
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                    </form>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        </div>
        </div>
</section>
<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
<script>
$(document).ready( function(){
  $("#addProduct").click(function() {
      var last_number = Number($("#productsTable td:last input").attr("name").replace(/\w+\-(\d+)/g, '$1')) + 1;
      $('#productsTable tr:last').after('<tr><td><input type="text" name="productID-' + last_number + '" placeholder="" value=""></td>' +
                            '<td><input type="text" name="productQuantity-' + last_number + '" placeholder="" value=""></td>' +
                            '<td><input type="text" name="productCost-' + last_number + '" placeholder="" value=""></td><tr>');
  });
});

</script>