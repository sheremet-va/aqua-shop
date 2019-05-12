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
    <div id="sidebar" class="span3">
        <div class="well well-small">
            <ul class="nav nav-list">
                <?php foreach ($categories as $categoryItem): ?>
                <li class="<?php if ($categoryId == $categoryItem['id']) echo 'active'; ?>"><a href="/category/<?php echo $categoryItem['id'];?>"><span class="icon-chevron-right"></span><?php echo $categoryItem['name'];?></a></li>
                <?php endforeach; ?>
                <li style="border:0"> &nbsp;</li>
                <li> <a class="totalInCart" href="/cart"><strong>Общая стоимость:  <span class="badge badge-warning pull-right" style="line-height:18px;" id="left-price-count"><?php echo Cart::getTotalPriceFromStart(); ?> ₽</span></strong></a></li>
            </ul>
        </div>
    </div>
    <div class="span9">
    <!--
    New Products
    -->
        <div class="well well-small">
            <h3>Последние поставки </h3>
            <div id="errors" class="warning invisible"></div>
            <hr class="soften"/>
            <div class="row-fluid new-arrival">
                <ul class="thumbnails">

                <?php foreach ($categoryProducts as $product): ?>
                    <li class="span4">
                        <div class="thumbnail">
                            <div class="subimg">
                                <a href="/product/<?php echo $product['id'];?>"><img src="<?php echo $product['image'];?>" alt="<?php echo $product['name'];?>"></a>
                            </div>
                            <div class="caption cntr">
                                <p><?php echo $product['name'];?></p>
                                <p><strong><?php echo $product['price'];?> ₽</strong></p>
                                <h4><a class="shopBtn add-to-cart" data-id="<?php echo $product['id'];?>" href="#" title="добавить в корзину"><span class="icon-shopping-cart"></span> В корзину </a></h4>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?>
                </ul>
            </div>
        <?php echo $pagination->get(); ?>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>