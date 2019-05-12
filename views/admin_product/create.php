<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/product">Управление товарами</a> <span class="divider">/</span></li>
                    <li class="active">Добавить товар</li>
                </ol>
            </div>
	<div class="well admin-well">
            <h4>Добавить новый товар</h4>

            <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="span4">  
                        <p>Название товара</p>
                        <input type="text" name="name" placeholder="" value="">

                        <p>Артикул</p>
                        <input type="text" name="articul" placeholder="" value="">

                        <p>Стоимость, ₽</p>
                        <input type="text" name="price" placeholder="" value="">
                        
                        <p>Закупочная цена, ₽</p>
                        <input type="text" name="procurement_price" placeholder="" value="">

                        <p>Категория</p>
                        <select name="category_id">
                            <?php if (is_array($categoriesList)): ?>
                                <?php foreach ($categoriesList as $category): ?>
                                    <option value="<?php echo $category['id']; ?>">
                                        <?php echo $category['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>

                        <p>Количество на складе</p>
                        <input type="text" name="stock" placeholder="" value="">
                        
                        <p>Изображение товара</p>
                        <input type="text" name="filename" placeholder="Название изображения" value="">
                        <input type="file" name="image" placeholder="">
                        
                        </div>
                        <div class="span4">  
                            
                        <p>Семейство</p>
                        <input type="text" name="family" placeholder="" value="">
                        
                        <p>Ареал обитания</p>
                        <input type="text" name="areal" placeholder="" value="">
                        
                        <p>Размер</p>
                        <input type="text" name="size" placeholder="" value="">                        
                        
                        </div>
                        <div class="span4"> 
                        <p>Температура воды</p>
                        <input type="text" name="temperature" placeholder="" value="">
                        
                        <p>Min объём аквариума</p>
                        <input type="text" name="volume" placeholder="" value="">

                        <p>Статус</p>
                        <select name="status">
                            <option value="1" selected="selected">Отображается</option>
                            <option value="0">Скрыт</option>
                        </select>
                        </div>
                        <div class="span4">  
                        
                        <p>Детальное описание</p>
                        <textarea name="full_description" rows="8" style="width: 525px;"></textarea>
                        
                        <p>Короткое описание</p>
                        <textarea name="short_description" rows="4" style="width: 525px;"></textarea>

                        <br/><br/>

                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">

                        <br/><br/>
                        </div>

                    </form>
                </div>
            </div>

        </div>
        </div>
        </div>
</section>
<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
<script>
$('input[name="image"]').on('change', function() {
  var splittedFakePath = this.value.split('\\');
  $('input[name="filename"]').val(splittedFakePath[splittedFakePath.length - 1]);
});
</script>

