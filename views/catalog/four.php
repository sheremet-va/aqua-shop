<?php include ROOT . '/views/layouts/header.php'; ?>

	<h3>Вид в четыре колонки</h3>
		<ul class="thumbnails">
                    <?php foreach ($latestProducts as $product): ?>
                    <li class="span3">
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

<?php include ROOT . '/views/layouts/footer.php'; ?>