<?php

class CatalogController
{

    public function actionIndex()
    {
        $title = "Каталог товаров";
        
        $categories = array();
        $categories = Category::getCategoriesList();

        $latestProducts = array();
        $latestProducts = Product::getLatestProducts(12);

        require_once(ROOT . '/views/catalog/index.php');

        return true;
    }

    public function actionCategory($categoryId, $page = 1)
    {
        $category = Category::getCategoryById($categoryId);
        $title = "Каталог товаров: " . $category['name'];
        
        $categories = array();
        $categories = Category::getCategoriesList();

        $categoryProducts = array();
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        $total = Product::getTotalProductsInCategory($categoryId);

        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once(ROOT . '/views/catalog/category.php');

        return true;
    }

    public function actionList()
    {
        $title = "Каталог товаров";
        
        $categories = array();
        $categories = Category::getCategoriesList();

        $latestProducts = array();
        $latestProducts = Product::getLatestProducts(6);

        require_once(ROOT . '/views/catalog/list.php');

        return true;
    }

    public function actionCategoryList($categoryId, $page = 1)
    {
        $category = Category::getCategoryById($categoryId);
        $title = "Каталог товаров: " . $category['name'];
        
        $categories = array();
        $categories = Category::getCategoriesList();

        $categoryProducts = array();
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        $total = Product::getTotalProductsInCategory($categoryId);

        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        require_once(ROOT . '/views/catalog/category_list.php');

        return true;
    }

//    public function actionFour()
//    {
//        $title = "Каталог товаров";
//        
//        $categories = array();
//        $categories = Category::getCategoriesList();
//
//        $latestProducts = array();
//        $latestProducts = Product::getLatestProducts(6);
//
//        require_once(ROOT . '/views/catalog/four.php');
//
//        return true;
//    }

}
