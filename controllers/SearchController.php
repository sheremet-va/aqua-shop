<?php
/*
 * Контроллер поиска
 */
class SearchController {
    
    public function actionIndex()
    {        
        if (!isset($_GET['query']) or empty($_GET['query'])) {
            $title = "Страница поиска";
            
            $productsList = array();
            $queryCount = 0;      
            
            $searchText = "Введите запрос в поле поиска.";
            $searchNoProductsText = "Запрос не выбран.";              
        } else {
            $query = trim($_GET['query']);
            $title = "Результат поиска по запросу «" . $query . "»"; 
            
            $productsList = Product::searchByQuery($query);
            $queryCount = count($productsList);      
            
            $searchText = "Поиск по запросу «" . $query . "» (" . Site::declination($queryCount, array('совпадение', 'совпадения', 'совпадений')) . ")";
            $searchNoProductsText = "По запросу «" . $query . "» ничего не найдено.";     
        }                
        
        require_once(ROOT . '/views/search/index.php');

        return true;
    }
    
    /*
     * Метод для динамической отправки списка товаров из поиска
     */
    public function actionAjaxSearch()
    {        
        if(!empty($_GET['query'])){
		$query = $_GET['query'];
		$productsList = Product::searchAjax($query);

                echo "['".implode("','", $productsList)."']";
	}
        exit();
        return true;
    }
}
