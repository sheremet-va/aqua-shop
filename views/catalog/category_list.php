<?php include ROOT . '/views/layouts/header.php';?>

<div id="parent_popup" style="display: none;">
  <div id="popup">
    <p>К сожалению, на складах не хватает выбранного товара. Пожалуйста, заказывайте товар в доступных пределах, указанных на странице товара. Спасибо!</p>
    <div class="right">
        <a href="#" class="shopBtn" style="cursor: pointer; margin-left: 215px;" onclick="document.getElementById('parent_popup').style.display='none';">Закрыть</a>
    </div>
  </div>
</div>
<div class="row">
    <div id="sidebar" class="span3">
        <div class="well well-small">
            <ul class="nav nav-list">
                <?php foreach ($categories as $categoryItem): ?>
                <li><a href="/category-list/<?php echo $categoryItem['id'];?>"><span class="icon-chevron-right"></span><?php echo $categoryItem['name'];?></a></li>
                <?php endforeach; ?>
                <li style="border:0"> &nbsp;</li>
                <li><a class="totalInCart" href="/cart"><strong>Общая стоимость:  <span class="badge badge-warning pull-right" style="line-height:18px;" id="left-price-count"><?php echo Cart::getTotalPriceFromStart(); ?> ₽</span></strong></a></li>
            </ul>
        </div>
    </div>
    <div class="span9">
        <!--
        New Products
        -->
        <div class="well well-small">
        <h3>Новые поставки</h3>
        <hr class="soften"/>
            <?php foreach ($categoryProducts as $product): ?>
            <div class="row-fluid">
                <div class="span2">
                    <a href="/product/<?php echo $product['id'];?>"><img src="<?php echo $product['image'];?>" alt="<?php echo $product['name'];?>" style="margin-top: 15px;"></a>
		</div>
		<div class="span6">
                    <h5><a href="/product/<?php echo $product['id'];?>"><?php echo $product['name'];?></a></h5>
                    <p><?php echo $product['short_description'];?>
                    </p>
		</div>
		<div class="span4 alignR">
		<form class="form-horizontal qtyFrm">
                    <h3><?php echo $product['price'];?> ₽</h3>
                    <div class="btn-group">
                      <a href="#" class="defaultBtn add-to-cart" data-id="<?php echo $product['id'];?>"><span class=" icon-shopping-cart"></span> В корзину</a> 
                      <a href="/product/<?php echo $product['id'];?>" class="shopBtn">ПРОСМОТР</a>
                     </div>
		</form>
		</div>
            </div>
            <hr class="soften">
            <?php endforeach;?>
        <?php echo $pagination->get(); ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>

