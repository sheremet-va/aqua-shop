<?php

class AdminProcurementController extends AdminBase
{

    /**
     * Action для страницы "Управление накладными"
     */
    public function actionIndex()
    {
        // Проверка доступа
        $rights = self::checkAdmin();
        $title = "Управление накладными";
        date_default_timezone_set('Europe/Moscow');
        
        $startDate = date("Y-m") . "-01"; // первый день текущего месяца
        $endDate = date("Y-m-t"); // последний день текущего месяца
        $date_string = "Информация о закупленных товарах за <strong>текущий месяц</strong>.";
        
        if (isset($_POST['submit'])) {
            // Если форма отправлена   
            // Получаем указанную дату. Если ничего не указано, ошибок быть не должно
            
            if (!empty($_POST['startDate']) AND !empty($_POST['endDate'])) {            
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $date_string = "Информация о закупленных товарах с <strong>" . $startDate . "</strong> по <strong>" . $endDate . "</strong>.";
            } else if (!empty($_POST['startDate'])) {
                $startDate = $_POST['startDate'];
                $date_string = "Информация о закупленных товарах с <strong>" . $startDate . "</strong> до <strong>сегодняшнего</strong> дня.";
            } else if (!empty($_POST['endDate'])) {
                $endDate = $_POST['endDate'];
                $date_string = "Информация о закупленных товарах с <strong>начала</strong> продаж до <strong>" . $endDate ."</strong>.";
            }
        }   

        // Получаем список заказов
        $consList = Consigment::getConsigmentsList($startDate, $endDate);
                
        $outputConsList = array();
        foreach ($consList as $consignment) {  
            $productsСonsignmentQuantity = json_decode($consignment['products_quantity'], true);
            $productsСonsignmentPrices = json_decode($consignment['products_cost'], true);  
            
            foreach ($productsСonsignmentQuantity as $id => $q) { // Заполнят массив количеством заказанного товара и ценами в другой массив
                if (array_key_exists($consignment['id'], $outputConsList)) {
                    $outputConsList[$consignment['id']]['quanity'] += $q;
                    $outputConsList[$consignment['id']]['prices'] += $productsСonsignmentPrices[$id] * $q;
                } else {
                    $outputConsList[$consignment['id']]['quanity'] = $q;
                    $outputConsList[$consignment['id']]['prices'] = $productsСonsignmentPrices[$id] * $q;
                }
            }            
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_procurement/index.php');
        return true;
    }   
    
    /**
     * Action для страницы "Просмотр накладной"
     */
    public function actionView($id)
    {
        // Проверка доступа
        self::checkAdmin();
        $title = "Просмотр накладной: " . $id;

        // Получаем данные о конкретном заказе
        $con = Consigment::getConById($id);

        // Получаем массив с идентификаторами и количеством товаров
        $productsQuantity = json_decode($con['products_quantity'], true);
        $productsPrices = json_decode($con['products_cost'], true);

        // Получаем массив с индентификаторами товаров
        $productsIds = array_keys($productsQuantity);        
        
        $totalCost = 0;
        foreach ($productsQuantity as $id => $q) {
            $totalCost += $q * $productsPrices[$id];
        }

        // Получаем список товаров в заказе
        $products = Product::getProductsByIds($productsIds);

        // Подключаем вид
        require_once(ROOT . '/views/admin_procurement/view.php');
        return true;
    }
    
    /**
     * Action для страницы "Добавление накладной"
     */
    public function actionCreate()
    {
        $rights = self::checkAdmin();
        $title = "Страница закупки товаров";
        
        $idEntry = false;
        
        if (isset($_POST['submit'])) {
            $i = 1;
            $products = array();
            while (!empty($_POST['productQuantity-' . $i])) {
                $id = intval($_POST['productID-' . $i]);
                $quantity = intval($_POST['productQuantity-' . $i]);
                $cost = intval($_POST['productCost-' . $i]);
                
                $productsQuantity[$id] = $quantity;
                $productsCost[$id] = $cost;
                $i += 1;
            }
            
            $productsQuantityTable = json_encode($productsQuantity);
            $productsCostTable = json_encode($productsCost);
            $idEntry = Consigment::addProcurementProduct($productsQuantityTable, $productsCostTable);
        }
        
        require_once(ROOT . '/views/admin_procurement/create.php');
        return true;
    }
}
        