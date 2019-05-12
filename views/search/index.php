<?php include ROOT . '/views/layouts/header.php'; ?>

<div class="row">
    <div class="span12">
        <ul class="breadcrumb">
            <li><a href="/">Главная</a> <span class="divider">/</span></li>
            <li class="active">Поиск</li>
        </ul>
	<div class="well well-small">
            <h2><?php echo $searchText;?></h2>
            <form action="/search/" method="GET" style="padding-right: 9px;">
                <input type="text" placeholder="Введите запрос для поиска..." name="query" class="span10">
                <button type="submit" class="btn btn-default" style="margin-top: -7px;"><i class="icon-search"></i> Найти</button>
            </form>
	<hr class="soften"/>
        
        <?php if ($queryCount > 0):
            foreach ($productsList as $product): ?>
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
        <?php endforeach; else:?>
            <div class="row-fluid">
                <div class="span12">
                    <p><?php echo $searchNoProductsText;?></p>
                </div>
            </div>
            <hr class="soften">
        <?php endif;?>
</div>
</div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>