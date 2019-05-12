<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="row">
<div id="sidebar" class="span3">
    <div class="well well-small">
        <ul class="nav nav-list">
            <?php foreach ($categories as $categoryItem): ?>
                <li><a href="/category/<?php echo $categoryItem['id'];?>"><span class="icon-chevron-right"></span><?php echo $categoryItem['name'];?></a></li>
            <?php endforeach; ?>
                <li style="border:0"> &nbsp;</li>
                <li><a class="totalInCart" href="/"><strong>Общая стоимость:  <span class="badge badge-warning pull-right" style="line-height:18px;" id="left-price-count"> $<?php echo Cart::getTotalPriceFromStart(); ?></span></strong></a></li>
        </ul>
    </div>
</div>
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="/">Главная</a> <span class="divider">/</span></li>
        <li><a href="/catalog">Товары</a> <span class="divider">/</span></li>
        <li><a href="/catalog/<?php echo $categoryItem['id'];?>"><?php echo $categoryItem['name'];?></a> <span class="divider">/</span></li>
        <li class="active"><?php echo $product['name'];?></li>
    </ul>	
	<div class="well well-small">
	<div class="row-fluid">
            <div class="span5">
            <img src="assets/img/a.jpg" alt="" style="width:100%">
            </div>
            <div class="span7">
                <h3>Name of the Item [$140.00]</h3>
                <hr class="soft"/>

                <form class="form-horizontal qtyFrm">
                  <div class="control-group">
                        <label class="control-label"><span>$140.00</span></label>
                        <div class="controls">
                        <input type="number" class="span6" placeholder="Qty.">
                        </div>
                  </div>

                  <div class="control-group">
                        <label class="control-label"><span>Color</span></label>
                        <div class="controls">
                          <select class="span11">
                                  <option>Red</option>
                                  <option>Purple</option>
                                  <option>Pink</option>
                                  <option>Red</option>
                        </select>
                        </div>
                  </div>
                  <div class="control-group">
                        <label class="control-label"><span>Materials</span></label>
                        <div class="controls">
                          <select class="span11">
                                  <option>Material 1</option>
                                  <option>Material 2</option>
                                  <option>Material 3</option>
                                  <option>Material 4</option>
                                </select>
                        </div>
                      </div>
                      <h4>100 items in stock</h4>
                      <p>Nowadays the lingerie industry is one of the most successful business spheres.
                      Nowadays the lingerie industry is one of ...
                      <p>
                      <button type="submit" class="shopBtn"><span class=" icon-shopping-cart"></span> Add to cart</button>
                    </form>
            </div>
            </div>
				<hr class="softn clr"/>

            <ul id="productDetail" class="nav nav-tabs">
              <li class="active"><a href="#home" data-toggle="tab">Описание</a></li>
            </ul>
            <div id="myTabContent" class="tab-content tabWrapper">
            <div class="tab-pane fade active in" id="home">
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>

        </div>			
    </div>

</div>
</div>
</div>
            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Последние товары</h2>
                    
                    <?php foreach ($latestProducts as $product): ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="/template/images/home/product1.jpg" alt="" />
                                        <h2><?php echo $product['price'];?>$</h2>
                                        <p>
                                            <a href="/product/<?php echo $product['id'];?>">
                                                <?php echo $product['name'];?>
                                            </a>
                                        </p>
                                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                    </div>
                                    <?php if ($product['is_new']): ?>
                                        <img src="/template/images/home/new.png" class="new" alt="" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>                   

                </div><!--features_items-->


            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>