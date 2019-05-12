<?php include ROOT . '/views/layouts/header.php'; ?>


<div id="parent_popup" style="display: none;">
  <div id="popup">
    <p>К сожалению, на складах не хватает выбранного товара в таком количестве. Пожалуйста, заказывайте товар в доступных пределах, указанных на странице товара. Спасибо!</p>
    <div class="right">
        <a href="#" class="shopBtn" style="cursor: pointer; margin-left: 215px;" onclick="document.getElementById('parent_popup').style.display='none';">Закрыть</a>
    </div>
  </div>
</div>

<div class="row">
    <div class="span12">
        <ul class="breadcrumb">
            <li><a href="/">Главная</a> <span class="divider">/</span></li>
            <li class="active">Корзина</li>
        </ul>
	<div class="well well-small">
            <h1>Корзина <small class="pull-right"> Товаров в корзине: <span id="total-cart-amount"><?php echo Cart::countItems();?></span></small></h1>
            <div id="errors"></div>
	<hr class="soften"/>	

    <?php if ($productsInCart): ?>
	<table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Артикул</th>
                    <th>Название</th>
                    <th>Стоимость за шт.</th>
                    <th>Количество</th>
                    <th>Общая стоимость</th>
                    <th>Удалить</th>
		</tr>
            </thead>
            <tbody>
                  <?php foreach ($products as $product): ?>
                  <tr>
                    <td><?php echo $product['articul'];?></td>
                    <td><a href="/product/<?php echo $product['id'];?>"><?php echo $product['name'];?></a></td>
                    <td><?php echo $product['price'];?> ₽</td>
                    <td><input type="number" class="span1" id="productNumber-<?php echo $product['id'];?>" placeholder="Кол-во" value=<?php echo $productsInCart[$product['id']];?>> <a href="#" class="shopBtn change-number-from-cart" data-id="<?php echo $product['id'];?>" ><span class="icon-ok"></span></a></td>
                    <td id="products-cost-<?php echo $product['id'];?>"><?php echo $product['price']*$productsInCart[$product['id']];?> ₽</td>
                    <td><a href="/cart/delete/<?php echo $product['id'];?>" class="shopBtn"><span class="icon-trash"></span></a></td>
                  </tr>
                   <?php endforeach; ?>
		<tr>
                  <td colspan="4" class="alignR">Итоговая стоимость:</td>
                  <th colspan="2" id="total-price"><?php echo $totalPrice;?> ₽</th>
                </tr>
            </tbody>
            </table>
	<a href="/" class="shopBtn btn-large"><span class="icon-arrow-left"></span> Продолжить покупки </a>
	<a href="/cart/checkout" class="shopBtn btn-large pull-right">Оформить <span class="icon-arrow-right"></span></a>
    <?php else: ?>
        <p>Корзина пуста</p>
    <?php endif; ?>
</div>
</div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>