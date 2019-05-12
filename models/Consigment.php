<?php
class Consigment { 
    
    /**
     * Возвращает список накладных
     * @return array <p>Список накладных</p>
     */
    public static function getConsigmentsList($startDate, $endDate)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT * FROM procurements WHERE date >= "' . $startDate . '" AND date <= "' . $endDate
                . '" ORDER BY id DESC');
        $consList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $consList[$i]['id'] = $row['id'];
            $consList[$i]['date'] = $row['date'];
            $consList[$i]['products_quantity'] = $row['products_quantity'];
            $consList[$i]['products_cost'] = $row['products_cost'];
            $i++;
        }
        return $consList;
    } 
    /**
     * Выдаёт массив с накладными
     * @param string $startDate <p>Дата, с которой выводить накладные</p>
     * @param string $endDate <p>Дата, до которой выводить накладные</p>
     * @return array <p>Массив с накладными</p>
     */
    public static function getProductsConsignments($startDate, $endDate)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT date, products_quantity, products_cost FROM procurements '
                . ' WHERE date >= "' . $startDate . '" AND date <= "' . $endDate . '" ORDER BY date ASC');
        $consignmentsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $consignmentsList[$i]['date'] = $row['date'];
            $consignmentsList[$i]['products_quantity'] = $row['products_quantity'];
            $consignmentsList[$i]['products_cost'] = $row['products_cost'];
            $i++;
        }
        return $consignmentsList;
    }
    
    /**
     * Добавляет новый товар в таблицу с закупленными товарами
     * @param array $products <p>Массив с информацией о товаре</p>
     * @return integer <p>id добавленной в таблицу записи</p>
     */
    public static function addProcurementProduct($productsQuantity, $productsCost)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'INSERT INTO procurements (products_quantity, products_cost) VALUES (:products_quantity, :products_cost)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':products_quantity', $productsQuantity, PDO::PARAM_STR);
        $result->bindParam(':products_cost', $productsCost, PDO::PARAM_STR);
        if ($result->execute()) {
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }
        // Иначе возвращаем 0
        return 0;
    }
    /**
     * Возвращает накладную с указанным id 
     * @param integer $id <p>id</p>
     * @return array <p>Массив с информацией о накладной</p>
     */
    public static function getConById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT * FROM procurements WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Выполняем запрос
        $result->execute();

        // Возвращаем данные
        return $result->fetch();
    }
}
