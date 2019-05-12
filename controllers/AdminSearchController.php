<?php
/*
 * Контроллер поиска для администраторов
 */
class AdminSearchController extends AdminBase {
    
    public function actionIndex()
    {        
        self::checkAdmin();
        
        if (!isset($_GET['query']) or empty($_GET['query'])) {
            $title = "Страница поиска";
            
            $usersList = array();
            $queryCount = 0;      
            
            $searchText = "Введите запрос в поле поиска.";
            $searchNoUsersText = "Запрос не выбран.";  
        } else {
            $query = trim($_GET['query']);
            $title = "Результат поиска по запросу «" . $query . "»"; 
            
            $usersList = User::searchByQuery($query);
            $queryCount = count($usersList);      
            
            $searchText = "Поиск по запросу «" . $query . "» (" . Site::declination($queryCount, array('совпадение', 'совпадения', 'совпадений')) . ")";
            $searchNoUsersText = "По запросу «" . $query . "» ничего не найдено.";     
        }        
        
        require_once(ROOT . '/views/search/admin_search.php');

        return true;
    }
    
    /*
     * Метод для динамической отправки списка товаров из поиска
     */
    public function actionAjaxSearch()
    {        
        if(!empty($_GET['query'])){
            $query = $_GET['query'];
            $usersList = User::searchAjax($query);

            echo "['".implode("','", $usersList)."']";
	}
        exit();
        return true;
    }
}
