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
                <li><a href="/category/<?php echo $categoryItem['id'];?>"><span class="icon-chevron-right"></span><?php echo $categoryItem['name'];?></a></li>
                <?php endforeach; ?>
                <li style="border:0"> &nbsp;</li>
                <li> <a class="totalInCart" href="/cart"><strong>Общая стоимость:  <span class="badge badge-warning pull-right" style="line-height:18px;" id="left-price-count"> <?php echo Cart::getTotalPriceFromStart(); ?> ₽</span></strong></a></li>
            </ul>
        </div>
    </div>
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="/">Главная</a> <span class="divider">/</span></li>
            <li><a href="/catalog/list">Товары</a> <span class="divider">/</span></li>
            <li><a href="/category/<?php echo $product['category_id'];?>"><?php foreach ($categories as $categoryItem): 
            if ($categoryItem['id'] == $product['category_id']) 
                    echo $categoryItem['name']; 
            endforeach ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $product['name'];?></li>
        </ul>	
            <div class="well well-small">
            <div class="row-fluid">
                <div class="span5">
                    <img src="<?php echo $product['image'];?>" alt="<?php echo $product['name'];?>" style="width:100%; padding-top: 15px;">
                </div>
                <div class="span7">
                    <h3><?php echo $product['name'];?><br><span style="color: #00BFC9">Цена: <?php echo $product['price'];?> ₽</span></h3>
                    <hr class="soft"/>
                    <form class="form-horizontal qtyFrm" method="POST" action="#">
                        <div class="control-group">
                            <label class="control-label"><span>Артикул</span></label>
                            <div class="controls">
                                <?php echo $product['articul'];?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><span>Семейство</span></label>
                            <div class="controls">
                                <?php echo $product['family'];?>                            
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><span>Ареал</span></label>
                            <div class="controls">
                                <?php echo $product['areal'];?>  
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><span>Предельный размер</span></label>
                            <div class="controls">
                                <?php echo $product['size'];?>  
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><span>Температура воды</span></label>
                            <div class="controls">
                                <?php echo $product['temperature'];?>  
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><span>Min обьём аквариума</span></label>
                            <div class="controls">
                                <?php echo $product['volume'];?>  
                            </div>
                        </div>
                        <h4><?php echo $product['stock'];?> на складах <?php if ($product['stock'] == 0): echo "</br><span style=\"color: red\";>Доступен под заказ:</span> <a href=\"/order/request\">заказать</a>"; endif;?></h4>
                        <p><?php echo $product['short_description'];?><p>
                            <input type="number" class="span3" id="productNumber" placeholder="Кол-во"> <a href="#" class="shopBtn add-number-to-cart" data-id="<?php echo $product['id'];?>" ><span class="icon-shopping-cart"></span> В корзину</a>
                        </form>
                </div>
            </div>
            <hr class="softn clr"/>

            <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Описание</a></li>
            </ul>
            <div id="myTabContent" class="tab-content tabWrapper">
                <div class="tab-pane fade active in" id="home">
                    <p><?php echo $product['full_description'];?></p>
                </div>			
            </div>
        </div>
    </div>
</div>
<?php include ROOT . '/views/layouts/footer.php'; ?>