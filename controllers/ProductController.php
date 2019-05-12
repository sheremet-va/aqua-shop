<?php

include_once ROOT . '/models/Category.php';
include_once ROOT . '/models/Product.php';

class ProductController
{

    public function actionView($productId)
    {        
        $categories = array();
        $categories = Category::getCategoriesList();
        
        $product = Product::getProductById($productId);        
        if (empty($product['id']) || $product['status'] == 0) {
            require_once(ROOT . '/views/errors/not_found.php');
            die();
        }
        $title = $product['name'];

        require_once(ROOT . '/views/product/view.php');

        return true;
    }

}
