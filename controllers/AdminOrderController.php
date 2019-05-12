<?php

/**
 * Контроллер AdminOrderController
 * Управление заказами в админпанели
 */
class AdminOrderController extends AdminBase
{

    /**
     * Action для страницы "Управление заказами"
     */
    public function actionIndex()
    {
        // Проверка доступа
        $rights = self::checkAdmin();
        $title = "Управление заказами";

        // Получаем список заказов
        $ordersList = Order::getOrdersList();
        $errors = false;
        
        if (isset($_POST['submit_by_name'])) {
            $phonenumber = trim($_POST['orderByNameSearch']);
            
            #if (!User::checkPhone($phonenumber))
            #    $errors[] = 'Недопустимый номер телефона. Номер телефона состоит из 10 цифр и начинается с девятки. Например, 9111222333.';
            
            if (!$errors) {
                $ordersList = Order::getOrderListByPhone($phonenumber);
            }
        }
        
        if (isset($_POST['return'])) {
            $ordersList = Order::getOrdersList();
        }

        // Подключаем вид
        if ($rights == "salseman")
            require_once(ROOT . '/views/admin_order/index_salseman.php');
        else
            require_once(ROOT . '/views/admin_order/index.php');
        return true;
    }

    /**
     * Action для страницы "Редактирование заказа" <b>(БЕЗ ПРОВЕРКИ ПОЛЕЙ)</b>
     */
    public function actionUpdate($id)
    {
        // Проверка доступа
        $rights = self::checkAdmin();
        $title = "Редактирование заказа: " . $id;

        // Получаем данные о конкретном заказе
        $order = Order::getOrderById($id);
        
        if ($rights == "salseman") {
            // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена   
                // Получаем данные из формы
                $status = $_POST['status'];
                $userCity = $_POST['userCity'];
                $userStreet = $_POST['userStreet'];
                $userHouse = $_POST['userHouse'];
                $userAppartment = $_POST['userAppartment'];

                // Сохраняем изменения
                Order::updateOrderByIdBySalesman($id, $status, $userCity, $userStreet, $userHouse, $userAppartment);

                //Если заказ закрывается, уменьшает количество продуктов на складе
                if ($status == 4 && $status != $order['status']) {
                    //Order::addCloseDate($id);
                    Order::changeStock($order);
                }

                // Перенаправляем пользователя на страницу управлениями заказами
                header("Location: /admin/order/view/$id");
            }            
        } else {
             // Обработка формы
            if (isset($_POST['submit'])) {
                // Если форма отправлена   
                // Получаем данные из формы
                $userName = $_POST['userName'];
                $userPhone = $_POST['userPhone'];
                $userComment = $_POST['userComment'];
                $date = $_POST['date'];
                $status = $_POST['status'];
                $delivery = $_POST['delivery'];
                $userCity = $_POST['userCity'];
                $userStreet = $_POST['userStreet'];
                $userHouse = $_POST['userHouse'];
                $userAppartment = $_POST['userAppartment'];

                // Сохраняем изменения
                Order::updateOrderById($id, $userName, $userPhone, $userComment, $date, $status, $delivery, $userCity, $userStreet, $userHouse, $userAppartment);

                //Если заказ закрывается, уменьшает количество продуктов на складе
                if ($status == 4 && $status != $order['status']) {
                    Order::addCloseDate($id);
                    Order::changeStock($order);
                }

                // Перенаправляем пользователя на страницу управлениями заказами
                header("Location: /admin/order/view/$id");
            }
        }

        // Подключаем вид
        if ($rights == "salseman")
            require_once(ROOT . '/views/admin_order/update_salseman.php');
        else
            require_once(ROOT . '/views/admin_order/update.php');
        return true;
    }

    /**
     * Action для страницы "Просмотр заказа"
     */
    public function actionView($id)
    {
        // Проверка доступа
        self::checkAdmin();
        $title = "Просмотр заказа: " . $id;

        // Получаем данные о конкретном заказе
        $order = Order::getOrderById($id);

        // Получаем массив с идентификаторами и количеством товаров
        $productsQuantity = json_decode($order['products'], true);
        $productsPrices = json_decode($order['products_prices'], true);

        // Получаем массив с индентификаторами товаров
        $productsIds = array_keys($productsQuantity);
        
        $totalCost = 0;
        foreach ($productsQuantity as $id => $q) {
            $totalCost += $q * $productsPrices[$id];
        }

        // Получаем список товаров в заказе
        $products = Product::getProductsByIds($productsIds);

        // Подключаем вид
        require_once(ROOT . '/views/admin_order/view.php');
        return true;
    }

    /**
     * Action для страницы "Удалить заказ"
     */
    public function actionDelete($id)
    {
        // Проверка доступа
        $rights = self::checkAdmin();
        $title = "Удаление заказа: " . $id;
        
        if ($rights == "salseman")
            die("Access denied");

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Удаляем заказ
            Order::deleteOrderById($id);

            // Перенаправляем пользователя на страницу управлениями товарами
            header("Location: /admin/order");
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_order/delete.php');
        return true;
    }

}
