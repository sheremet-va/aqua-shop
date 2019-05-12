<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/product">Управление товарами</a> <span class="divider">/</span></li>
                    <li class="active">Редактировать товар</li>
                </ol>
            </div>
	<div class="well admin-well">
            <h4>Редактировать товар «<?php echo $product['name']; ?>»</h4>
            
            <div class="col-lg-4">
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="span4">  
                        <p>Название товара</p>
                        <input type="text" name="name" placeholder="" value="<?php echo $product['name']; ?>">

                        <p>Артикул</p>
                        <input type="text" name="articul" placeholder="" value="<?php echo $product['articul']; ?>">

                        <p>Стоимость, ₽</p>
                        <input type="text" name="price" placeholder="" value="<?php echo $product['price']; ?>">

                        <p>Закупочная цена, ₽</p>
                        <input type="text" name="procurement_price" placeholder="" value="<?php echo $product['procurement_price']; ?>">

                        <p>Категория</p>
                        <select name="category_id">
                            <?php if (is_array($categoriesList)): ?>
                                <?php foreach ($categoriesList as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" 
                                        <?php if ($product['category_id'] == $category['id']) echo ' selected="selected"'; ?>>
                                        <?php echo $category['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>

                        <p>Количество на складе</p>
                        <input type="text" name="stock" placeholder="" value="<?php echo $product['stock']; ?>">

                        <p>Изображение товара</p>
                        <img src="<?php echo $product['image']; ?>" width="200" alt="" style="padding-bottom: 5px"/>
                        <input type="text" name="filename" placeholder="" value="<?php echo str_replace('/assets/img/fishes/', '', $product['image']); ?>">
                        <input type="file" name="image" placeholder="" value="<?php echo $product['image']; ?>">
                        
                        </div>
                        <div class="span4">  

                        <p>Семейство</p>
                        <input type="text" name="family" placeholder="" value="<?php echo $product['family']; ?>">
                        
                        <p>Ареал обитания</p>
                        <input type="text" name="areal" placeholder="" value="<?php echo $product['areal']; ?>">
                        
                        <p>Размер</p>
                        <input type="text" name="size" placeholder="" value="<?php echo $product['size']; ?>">
                        
                        </div>
                        <div class="span4">  
                        <p>Температура воды</p>
                        <input type="text" name="temperature" placeholder="" value="<?php echo $product['temperature']; ?>">
                        
                        <p>Min объём аквариума</p>
                        <input type="text" name="volume" placeholder="" value="<?php echo $product['volume']; ?>">

                        <p>Статус</p>
                        <select name="status">
                            <option value="1" <?php if ($product['status'] == 1) echo ' selected="selected"'; ?>>Отображается</option>
                            <option value="0" <?php if ($product['status'] == 0) echo ' selected="selected"'; ?>>Скрыт</option>
                        </select>
                            
                        </div>
                        <div class="span4">  
                        <p>Детальное описание</p>
                        <textarea name="full_description" rows="8" style="width: 525px;"><?php echo $product['full_description']; ?></textarea>
                        
                        <p>Короткое описание</p>
                        <textarea name="short_description" rows="3" style="width: 525px;"><?php echo $product['short_description']; ?></textarea>

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