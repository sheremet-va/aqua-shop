<?php

class Order
{
    const SHOW_BY_DEFAULT = 3;

    /**
     * Сохранение заказа 
     * @param type $name
     * @param type $email
     * @param type $password
     * @return type
     */
    public static function save($userName, $userPhone, $userCity, $userStreet, $userHouse, $userAppartment, $userComment, $userId, $delivery, $products, $productsPrices)
    {
        $products = json_encode($products);
        $productsPrices = json_encode($productsPrices);

        $db = Db::getConnection();

        $sql = 'INSERT INTO product_order (user_name, user_phone, user_city, user_street, user_house, user_appartment, user_comment, user_id, delivery, products, products_prices) '
                . 'VALUES (:user_name, :user_phone, :user_city, :user_street, :user_house, :user_appartment, :user_comment, :user_id, :delivery, :products, :products_prices)';

        $result = $db->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_city', $userCity, PDO::PARAM_STR);
        $result->bindParam(':user_street', $userStreet, PDO::PARAM_STR);
        $result->bindParam(':user_house', $userHouse, PDO::PARAM_STR);
        $result->bindParam(':user_appartment', $userAppartment, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':delivery', $delivery, PDO::PARAM_INT);
        $result->bindParam(':products', $products, PDO::PARAM_STR);
        $result->bindParam(':products_prices', $productsPrices, PDO::PARAM_STR);
        
        if ($result->execute()) {
            return $db->lastInsertId();
        } else {
            return false;
        }
    }
    
    
    /**
     * Возвращает список заказов
     * @return array <p>Список заказов</p>
     */
    public static function getOrdersList()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT id, user_name, user_phone, date, status FROM product_order ORDER BY id DESC');
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['status'] = $row['status'];
            $i++;
        }
        return $ordersList;
    }
    
    /**
     * Возвращает список заказов по номеру
     * @return array <p>Список заказов</p>
     */
    public static function getOrderListByPhone($query)
    {
        // Соединение с БД
        $db = Db::getConnection();
        $ordersList = array();

        // Получение и возврат результатов               
        $sql = "SELECT id, user_name, user_phone, date, status FROM product_order WHERE user_phone LIKE ? OR user_name LIKE ?"
            . " ORDER BY id DESC";
        
        $result = $db->prepare($sql);
        $result->execute(array("%$query%","%$query%"));  
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['status'] = $row['status'];
            $i++;
        }
        return $ordersList;
    }

    /**
     * Возвращает текстое пояснение статуса для заказа :<br/>
     * <i>1 - Новый заказ, 2 - В обработке, 3 - Доставляется, 4 - Закрыт</i>
     * @param integer $status <p>Статус</p>
     * @return string <p>Текстовое пояснение</p>
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Новый заказ';
                break;
            case '2':
                return 'В обработке';
                break;
            case '3':
                return 'Доставляется';
                break;
            case '4':
                return 'Закрыт';
                break;
            case '5':
                return 'Отменён';
                break;
        }
    }
    
    /**
     * Возвращает текстое пояснение статуса доставки для заказа :<br/>
     * <i>1 - Новый заказ, 2 - В обработке, 3 - Доставляется, 4 - Закрыт</i>
     * @param integer $status <p>Статус</p>
     * @return string <p>Текстовое пояснение</p>
     */
    public static function getDeliveryText($status)
    {
        switch ($status) {
            case '0':
                return 'Самовывоз';
                break;
            case '1':
                return 'Доставка оформлена';
                break;
        }
    }

    /**
     * Возвращает заказ с указанным id 
     * @param integer $id <p>id</p>
     * @return array <p>Массив с информацией о заказе</p>
     */
    public static function getOrderById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT * FROM product_order WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Выполняем запрос
        $result->execute();

        // Возвращаем данные
        return $result->fetch();
    }

    /**
     * Возвращает заказ с указанным id пользователя 
     * @param integer $id <p>id</p>
     * @return array <p>Массив с информацией о заказе</p>
     */
    public static function getOrdersListByUserId($id, $page = 1)
    {       
        if ($id) {
            
            $page = intval($page);            
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;            
            
            // Соединение с БД
            $db = Db::getConnection();
            $ordersList = array();

            $result = $db->query('SELECT * FROM product_order WHERE user_id = ' . $id . ' '
                    . 'ORDER BY id ASC '          
                    . 'LIMIT '.self::SHOW_BY_DEFAULT
                    . ' OFFSET '. $offset);

            $i = 0;
            while ($row = $result->fetch()) {
                $ordersList[$i]['id'] = $row['id'];
                $ordersList[$i]['user_id'] = $row['user_id'];
                $ordersList[$i]['user_city'] = $row['user_city'];
                $ordersList[$i]['user_street'] = $row['user_street'];
                $ordersList[$i]['user_house'] = $row['user_house'];
                $ordersList[$i]['user_appartment'] = $row['user_appartment'];
                $ordersList[$i]['user_comment'] = $row['user_comment'];
                $ordersList[$i]['date'] = $row['date'];
                $ordersList[$i]['closing_date'] = $row['closing_date'];
                $ordersList[$i]['products_prices'] = $row['products_prices'];
                $ordersList[$i]['products'] = $row['products'];
                $ordersList[$i]['status'] = $row['status'];
                $ordersList[$i]['delivery'] = $row['delivery'];
                $i++;
            }

            // Возвращаем данные
            return $ordersList;
        }
    }
    /**
     * Returns total orders
     */
    public static function getTotalOrders($id)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM product_order '
                . 'WHERE user_id='.$id.'');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }

    /**
     * Возвращает все заказы 
     * @return array <p>Массив с информацией о заказах</p>
     */
    public static function getOrdersByDate($startDate, $endDate)
    {
        $db = Db::getConnection();
        $ordersList = array();

        $result = $db->query('SELECT closing_date, products, products_prices FROM product_order '
                . 'WHERE status = "4" AND closing_date >= "' . $startDate . '" AND closing_date <= "' . $endDate
                . '" ORDER BY closing_date ');

        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['closing_date'] = $row['closing_date'];
            $ordersList[$i]['products'] = $row['products'];
            $ordersList[$i]['products_prices'] = $row['products_prices'];
            $i++;
        }
        
        return $ordersList;
    }

    /**
     * Удаляет заказ с заданным id
     * @param integer $id <p>id заказа</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function deleteOrderById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'DELETE FROM product_order WHERE id = :id';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Редактирует заказ с заданным id
     * @param integer $id <p>id товара</p>
     * @param string $userName <p>Имя клиента</p>
     * @param string $userPhone <p>Телефон клиента</p>
     * @param string $userComment <p>Комментарий клиента</p>
     * @param string $date <p>Дата оформления</p>
     * @param string $delivery <p>Доставляется ли <i>(доставка есть "1", доставки нет "0")</i></p>
     * @param string $userCity <p>Город проживания</p>
     * @param string $userStreet <p>Улица проживания</p>
     * @param string $userHouse <p>Дом клиента</p>
     * @param string $userAppartment <p>Квартира клиента</p>
     * @param integer $status <p>Статус <i>(новый заказ "1", в обработке "2", доставляется "3", закрыт "4")</i></p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateOrderById($id, $userName, $userPhone, $userComment, $date, $status, $delivery, $userCity, $userStreet, $userHouse, $userAppartment)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE product_order
            SET 
                user_name = :user_name, 
                user_phone = :user_phone, 
                user_comment = :user_comment, 
                date = :date, 
                status = :status,
                delivery = :delivery,
                user_city = :user_city, 
                user_street = :user_street, 
                user_house = :user_house, 
                user_appartment = :user_appartment
            WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':delivery', $delivery, PDO::PARAM_INT);
        $result->bindParam(':user_city', $userCity, PDO::PARAM_STR);
        $result->bindParam(':user_street', $userStreet, PDO::PARAM_STR);
        $result->bindParam(':user_house', $userHouse, PDO::PARAM_STR);
        $result->bindParam(':user_appartment', $userAppartment, PDO::PARAM_STR);
        return $result->execute();
    }
    
    
    /**
     * Редактирует заказ с заданным id
     * @param integer $id <p>id товара</p>
     * @param string $userCity <p>Город проживания</p>
     * @param string $userStreet <p>Улица проживания</p>
     * @param string $userHouse <p>Дом клиента</p>
     * @param string $userAppartment <p>Квартира клиента</p>
     * @param integer $status <p>Статус <i>(новый заказ "1", в обработке "2", доставляется "3", закрыт "4")</i></p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateOrderByIdBySalesman($id, $status, $userCity, $userStreet, $userHouse, $userAppartment)
    {
        date_default_timezone_set('Europe/Moscow');
        // Соединение с БД
        $db = Db::getConnection();
        $date = date("Y-m-d H:i:s");

        // Текст запроса к БД
        $sql = "UPDATE product_order
            SET 
                status = :status,
                user_city = :user_city, 
                user_street = :user_street, 
                user_house = :user_house, 
                user_appartment = :user_appartment,
                closing_date = :closing_date
            WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);
        $result->bindParam(':user_city', $userCity, PDO::PARAM_STR);
        $result->bindParam(':user_street', $userStreet, PDO::PARAM_STR);
        $result->bindParam(':user_house', $userHouse, PDO::PARAM_STR);
        $result->bindParam(':user_appartment', $userAppartment, PDO::PARAM_STR);
        $result->bindParam(':closing_date', $date, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Добавляет дату закрытия заказа
     * /
     * 
     * @param type $id
     * @return type
     */
    public static function addCloseDate($id)
    {
        date_default_timezone_set('Europe/Moscow');
        // Соединение с БД
        $db = Db::getConnection();
        $date = date("Y-m-d H:i:s");

        // Текст запроса к БД
        $sql = "UPDATE product_order
            SET 
                closing_date = :closing_date, 
            WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':closing_date', $date, PDO::PARAM_STR);
        return $result->execute();
    }
    
    /**
     * Уменьшает кол-во доступного товара, если заказ закрываетсся
     * @param array $getOrder <p>Массив с информацией о заказе</p>
     */
    public static function changeStock($getOrder)
    {
        // Соединение с БД
        $db = Db::getConnection();
        $products = json_decode($getOrder['products'], true);
        
        // Текст запроса к БД
        foreach ($products as $id => $q) {
            $product = Product::getProductById($id);
            $stock = $product['stock'] - intval($q);              
            
            $result = $db->query('UPDATE product SET stock = ' . $stock . ' WHERE id = ' . $id );
            $result->execute();
        }
        return true;
    }
    
    /**
     * Возвращает список заказов
     * @return array <p>Список заказов</p>
     */
    public static function getOrdersRaitingList()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT id, products, products_prices FROM product_order ORDER BY id DESC');
        //$result = $db->query('SELECT id, products, product_prices FROM product_order WHERE status = 4 ORDER BY id DESC');
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['products'] = $row['products'];
            $ordersList[$i]['products_prices'] = $row['products_prices'];
            $i++;
        }
        return $ordersList;
    }

}
