<?php

/*
 * Известный баг: если выбрать дату продажи так, что будут проданы товары одного id
 * но не будут закуплены товары в течение этого времени, то прибыль посчитается неправильно
 * т.к. не учитывает покупки из прошлого месяца (но баг ли?)
 */


class OwnerRaitingController extends AdminBase
{

    public function actionRaiting()
    {
        $title = "Страница рейтинга товара";
        $rights = self::checkAdmin();
        date_default_timezone_set('Europe/Moscow');
        
        $startDate = date("Y-m") . "-01"; // первый день текущего месяца
        $endDate = date("Y-m-t"); // последний день текущего месяца
        $date_string = "Информация о проданных товарах за <strong>текущий месяц</strong>.";
        
        if (isset($_POST['submit'])) {
            // Если форма отправлена   
            // Получаем указанную дату. Если ничего не указано, ошибок быть не должно
            
            if (!empty($_POST['startDate']) AND !empty($_POST['endDate'])) {            
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $date_string = "Информация о проданных товарах с <strong>" . $startDate . "</strong> по <strong>" . $endDate . "</strong>.";
            } else if (!empty($_POST['startDate'])) {
                $startDate = $_POST['startDate'];
                $date_string = "Информация о проданных товарах с <strong>" . $startDate . "</strong> до <strong>сегодняшнего</strong> дня.";
            } else if (!empty($_POST['endDate'])) {
                $endDate = $_POST['endDate'];
                $date_string = "Информация о проданных товарах с <strong>начала</strong> месяца до <strong>" . $endDate ."</strong>.";
            }
        }   
        
        // Получение информации о товарах в заказах
        
        $products = array(); // Массив с товарами
        $soldProductsQuantity = array(); // Массив типа товар => количество
        $soldProductsPrices = array(); // Массив типа товар => цена
        $soldProductsIds = array(); // Массив с ID всех товаров, которые хранятся в БД
        $totalMoneyFromSoldProducts = 0;
        
        $soldInfo = array();
        
        $orders = Order::getOrdersByDate($startDate, $endDate); // Массив с заказами
        
        foreach ($orders as $number => $order) {            
            $productsQuantity = json_decode($order['products'], true);
            $productsPrices = json_decode($order['products_prices'], true);  
            $date = stristr($order['closing_date'], ' ', true); 
            $soldProductsIds = array_keys($productsQuantity);
            $soldProductsList = Product::getProductsByIds($soldProductsIds);
            $expenses = 0;
            
            foreach ($productsQuantity as $id => $q) { // Заполнят массив количеством купленного товара
                if (array_key_exists($id, $soldProductsQuantity)) {
                    $soldProductsQuantity[$id] += $q;
                    $soldProductsPrices[$id] += $productsPrices[$id] * $q;
                } else {
                    $soldProductsQuantity[$id] = $q;
                    $soldProductsPrices[$id] = $productsPrices[$id] * $q;
                }  
                
                // Массив по датам
                if (array_key_exists($date, $soldInfo)) {
                    $soldInfo[$date]['quantity_sold'] += $q;
                    $soldInfo[$date]['price'] += $productsPrices[$id] * $q;          
                } else {
                    $soldInfo[$date]['quantity_sold'] = $q;
                    $soldInfo[$date]['price'] = $productsPrices[$id] * $q;       
                }     
            }  
            foreach ($soldProductsList as $product) {
               $expenses += $product['procurement_price'] * $soldProductsQuantity[$product['id']];
            }
            $soldInfo[$date]['expenses'] = $expenses; 
        }   
        
        // Получаем массив с индентификаторами товаров
        $soldProductsIds = array_keys($soldProductsPrices);   
        
        $totalMoneyFromSoldProducts = array_sum($soldProductsPrices);
        $totalExpenses = 0;
        foreach ($soldInfo as $date => $info) {
            $totalExpenses += $info['expenses'];            
        }

        // Получаем список товаров в заказе
        if (empty($soldProductsIds)) {
            $productsList = array();
        } else {
            $productsList = Product::getProductsByIds($soldProductsIds);
        }
//        
//        // Получение информации о товарах из накладной
//        
//        $consQuantity = array(); // Массив с количеством закупленного товара
//        $consPrices = array(); // Массив с ценами закулпенного товара
//        $totalProcPrices = 0; // Общая цена, потраченная за закупку продуктов
//        $consInfo = array();
//        $consignments = Consigment::getProductsConsignments($startDate, $endDate);        
//        
//        foreach ($consignments as $number => $consignment) {            
//            $productsСonsignmentQuantity = json_decode($consignment['products_quantity'], true);
//            $productsСonsignmentPrices = json_decode($consignment['products_cost'], true);   
//            $date = stristr($consignment['date'], ' ', true);
//            
//            foreach ($productsСonsignmentQuantity as $id => $q) { // Заполнят массив количеством заказанного товара и ценами в другой массив
//                if (array_key_exists($id, $consQuantity)) {
//                    $consQuantity[$id] += $q;
//                    $consPrices[$id] += $productsСonsignmentPrices[$id] * $q;
//                } else {
//                    $consQuantity[$id] = $q;
//                    $consPrices[$id] = $productsСonsignmentPrices[$id] * $q;
//                }
//                
//                if (array_key_exists($date, $consInfo)) {
//                    $consInfo[$date]['quantity_proc'] += $q;
//                    $consInfo[$date]['proc'] += $productsСonsignmentPrices[$id] * $q;    
//                } else {
//                    $consInfo[$date]['quantity_proc'] = $q;
//                    $consInfo[$date]['proc'] = $productsСonsignmentPrices[$id] * $q;
//                }
//            }
//        }
//        
//        $commonArray = array_replace_recursive($consInfo, $soldInfo); // Объединяет массивы (продажи и закупка), чтобы построить график
//        
//        foreach ($commonArray as $date => $info) {
//            if (!isset($info['quantity_proc']))
//                $commonArray[$date]['quantity_proc'] = 0;
//            if (!isset($info['proc']))
//                $commonArray[$date]['proc'] = 0;
//            if (!isset($info['quantity_sold']))
//                $commonArray[$date]['quantity_sold'] = 0;
//            if (!isset($info['price']))
//                $commonArray[$date]['price'] = 0;
//        }
//        //print_r($commonArray);die();
//        
//        // Получаем массив с индентификаторами товаров
//        $consProductsIds = array_keys($consQuantity);   
//        
//        $totalProcPrices = array_sum($consPrices); // Общая сумма, на которую закупили товаров
//
//        // Получаем список товаров из накладной
//        if (empty($consProductsIds)) {
//            $productsConsList = array();
//        } else {
//            $productsConsList = Product::getProductsByIds($consProductsIds);
//        } 
        
        
        $soldList = array();
        $profitList = array();
        $totalProfit = 0;
        //$productsNames = array();
        
        foreach ($productsList as $number => $product) {
            $soldList[$product['name']] = $soldProductsPrices[$product['id']]; // Массив для диаграммы в форме название => суммарная цена
                        
            $profitList[$product['name']] = $soldProductsPrices[$product['id']] - $product['procurement_price'] * $soldProductsQuantity[$product['id']];
        }
        
        $totalProfit = $totalMoneyFromSoldProducts - $totalExpenses;
        
        $commonSalesArray =  preg_replace('/{(.*)}/', '$1', json_encode($soldInfo, JSON_UNESCAPED_UNICODE));
        
        //print_r($commonSalesArray);die();
        $commonSalesLinesChart = preg_replace('/("[\d\-]+"):{"quantity_sold":\d+,"price":(\d+),"expenses":(\d+)}/', '[$1, $2, $3]', $commonSalesArray);
        
        $productsSalesArray = preg_replace('/{(.*)}/', '$1', json_encode($soldList, JSON_UNESCAPED_UNICODE)); // кодирование массива, чтобы дальше быстрее преобразовать
        $productsSalesArrayChart = preg_replace('/("[^:]+"):(\d+)/', '[$1, $2]', $productsSalesArray); // преобразование массива для отображения в диграмме продаж
                
        if ($rights == "owner")
            require_once(ROOT . '/views/owner/raiting.php');
        else
            die('Access denied');
        
        return true;
    }
    
    
    public function actionRaitingView($id)
    {
        $rights = self::checkAdmin();
                
        $product = Product::getProductById($id);
        $title = "Страница рейтинга товара: " . $product['name'];
        
        date_default_timezone_set('Europe/Moscow');
        
        $startDate = date("Y-m") . "-01"; // первый день текущего месяца
        $endDate = date("Y-m-t"); // последний день текущего месяца
        $date_string = "за <strong>текущий месяц</strong>."; // запись о том, с какого периода выводятс яданные
        
        if (isset($_POST['submit'])) {
            // Если форма отправлена   
            // Получаем указанную дату. Если ничего не указано, ошибок быть не должно            
            if (!empty($_POST['startDate']) AND !empty($_POST['endDate'])) {            
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $date_string = "за период времени с <strong>" . $startDate . "</strong> по <strong>" . $endDate . "</strong>.";
            } else if (!empty($_POST['startDate'])) {
                $startDate = $_POST['startDate'];
                $date_string = "за период времени с <strong>" . $startDate . "</strong> до <strong>сегодняшнего</strong> дня.";
            } else if (!empty($_POST['endDate'])) {
                $endDate = $_POST['endDate'];
                $date_string = "за период времени с <strong>начала месяца</strong> до <strong>" . $endDate ."</strong>.";
            }
        }        
        
        $productsSallesInfo = array(); // массив с информацией о товаре (дата => кол-во, цена, закупная цена, прибыль)
        $proc_price = intval($product['procurement_price']); // закупная цена как число (в массиве хранилась как строка)
        
        $orders = Order::getOrdersByDate($startDate, $endDate);
        
        foreach ($orders as $number => $order) {            
            $productsQuantitiesArray = json_decode($order['products'], true); // массив с кол-вом заказанного товара
            $productsPricesArray = json_decode($order['products_prices'], true);  // массив с ценами товаров
            $date = stristr($order['closing_date'], ' ', true); // ключ, в которой хранятся данные (дата закрытия заказа без времени)
            
            foreach ($productsQuantitiesArray as $p_id => $q) {                
                if ($p_id == $id) { // если id товара совпадают, то
                    if (array_key_exists($date, $productsSallesInfo)) { // если в массиве с информацией о товаре есть элемент с заданной датой, то
                        $productsSallesInfo[$date]['quantity_sold'] += $q; // заносит информацию о  кол-во
                        $productsSallesInfo[$date]['price'] += $productsPricesArray[$p_id] * $q; // заносит инф. о цене, по которой продали
                        $productsSallesInfo[$date]['expenses'] += $proc_price * $q; 
                    } else { // если нет в массиве элемента с заданной датой, тл
                        $productsSallesInfo[$date]['quantity_sold'] = $q; // заносит информацию о  кол-во
                        $productsSallesInfo[$date]['price'] = $productsPricesArray[$p_id] * $q; // заносит инф. о цене, по которой продали
                        $productsSallesInfo[$date]['expenses'] = $proc_price * $q; 
                    }
                    break; // остановить массив, чтобы до конца не шёл (уменьшает время обработки)
                }
            }            
        }
        
//        
//        // Получение информации о товарах из накладной
//        $consInfo = array(); // Вся верхняя информация в одном массиве
//        $totalProcPrices = 0; // Общая цена, потраченная на закупку продуктов
//        $consignments = Consigment::getProductsConsignments($startDate, $endDate);        
//        
//        foreach ($consignments as $number => $consignment) {            
//            $productsСonsignmentQuantity = json_decode($consignment['products_quantity'], true);
//            $productsСonsignmentPrices = json_decode($consignment['products_cost'], true);   
//            $date = stristr($consignment['date'], ' ', true);
//            
//            foreach ($productsСonsignmentQuantity as $p_id => $q) { // Заполнят массив количеством заказанного товара и ценами в другой массив
//                if ($p_id == $id) { // если id товара совпадают, то
//                    if (array_key_exists($date, $consInfo)) {
//                        $consInfo[$date]['quantity_proc'] += $q;
//                        $consInfo[$date]['proc'] += $productsСonsignmentPrices[$id] * $q;    
//                    } else {
//                        $consInfo[$date]['quantity_proc'] = $q;
//                        $consInfo[$date]['proc'] = $productsСonsignmentPrices[$id] * $q;
//                    }
//                    break; // остановить массив, чтобы до конца не шёл (уменьшает время обработки)
//                }
//            }
//        }     
//        
//        $commonArray = array_replace_recursive($consInfo, $productsSallesInfo); // Объединяет массивы (продажи и закупка), чтобы построить график
//        
        $totalSoldQuantity = 0;
        $totalPrice = 0;
        $totalExpenses = 0;
        
        foreach ($productsSallesInfo as $date => $info) {            
            $totalSoldQuantity += $productsSallesInfo[$date]['quantity_sold'];
            $totalPrice += $productsSallesInfo[$date]['price'];
            $totalExpenses += $productsSallesInfo[$date]['expenses'];
        }
//        
//        foreach ($commonArray as $date => $info)
//            ksort($commonArray[$date]); // Сортирует по ключам, чтобы можно было применить регулярное выражение
//                
        $totalProfit = $totalPrice - $totalExpenses;
                
        $productsSalesArray = preg_replace('/{(.*)}/', '$1', json_encode($productsSallesInfo)); // кодирование массива, чтобы дальше быстрее преобразовать
        
        //print_r($productsSalesArray);die();
        $productsQuantityArrayChart = preg_replace('/("[\d\-]+"):{"quantity_sold":(\d+),"price":\d+,"expenses":\d+}/', '[$1, $2]', $productsSalesArray); // преобразование массива для отображения в графике количества
        $productsSallesArrayChart = preg_replace('/("[\d\-]+"):{"quantity_sold":\d+,"price":(\d+),"expenses":(\d+)}/', '[$1, $2, $3]', $productsSalesArray); // преобразование массива для отображения в графике продаж
               
        //print_r($productsQuantityArrayChart);die();
        if ($rights == "owner")
            require_once(ROOT . '/views/owner/raiting_item.php');
        else
            die('Access denied');
        
        return true;
    }
    
}