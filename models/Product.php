<?php

class Product
{

    const SHOW_BY_DEFAULT = 6;

    /**
     * Returns an array of products
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT, $page = 1)
    {
        $count = intval($count);
        $page = intval($page);
        $offset = $page * $count;
        
        $db = Db::getConnection();
        $productsList = array();

        $result = $db->query('SELECT id, name, price, image, short_description FROM product '
                . 'WHERE status = "1"'
                . 'ORDER BY id DESC '                
                . 'LIMIT ' . $count
                . ' OFFSET '. $offset);

        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['short_description'] = $row['short_description'];
            $i++;
        }

        return $productsList;
    }
    
    /**
     * Returns an array of products
     */
    public static function getProductsListByCategory($categoryId = false, $page = 1)
    {
        if ($categoryId) {
            
            $page = intval($page);            
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        
            $db = Db::getConnection();            
            $products = array();
            $result = $db->query("SELECT id, name, price, image, short_description FROM product "
                    . "WHERE status = '1' AND category_id = '$categoryId' "
                    . "ORDER BY id ASC "                
                    . "LIMIT ".self::SHOW_BY_DEFAULT
                    . ' OFFSET '. $offset);

            $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id'] = $row['id'];
                $products[$i]['name'] = $row['name'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['short_description'] = $row['short_description'];
                $i++;
            }

            return $products;       
        }
    }
    
    
    /**
     * Returns product item by id
     * @param integer $id
     */
    public static function getProductById($id)
    {
        $id = intval($id);

        if ($id) {                        
            $db = Db::getConnection();
            
            $sql = 'SELECT * FROM product WHERE id=?';
            $result = $db->prepare($sql);
            $result->execute(array($id));
            
            return $result->fetch();
        }
    }
    
    /**
     * Returns product item by name
     * @param integer $id
     */
    public static function getProductByName($name)
    {
        if ($name) {                        
            $db = Db::getConnection();
            
            $result = $db->query('SELECT * FROM product WHERE name="' . $name . '"');
            $result->setFetchMode(PDO::FETCH_ASSOC);
            
            return $result->fetch();
        }
    }
    /**
     * Returns product item by articul
     * @param integer $id
     */
    public static function getProductByArticul($articul)
    {
        if ($articul) {                        
            $db = Db::getConnection();
            
            $result = $db->query('SELECT * FROM product WHERE articul="' . $articul . '"');
            $result->setFetchMode(PDO::FETCH_ASSOC);
            
            return $result->fetch();
        }
    }
    
    /**
     * Returns total products
     */
    public static function getTotalProductsInCategory($categoryId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT count(id) AS count FROM product '
                . 'WHERE status="1" AND category_id ="'.$categoryId.'"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['count'];
    }
    /**
     * Returns products
     */
    public static function getProductsByIds($idsArray)
    {
        $products = array();
        
        $db = Db::getConnection();
        
        $idsString = implode(',', $idsArray);

        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";

        $result = $db->query($sql);        
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['category_id'] = $row['category_id'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['procurement_price'] = $row['procurement_price'];
            $products[$i]['stock'] = $row['stock'];
            $products[$i]['articul'] = $row['articul'];
            $i++;
        }

        return $products;
    }
    
    
    /**
     * Возвращает список товары для страницы поиска
     */
    public static function searchByQuery($query)
    {
        $products = array();
        
        $db = Db::getConnection();

        $sql = "SELECT * FROM product WHERE status=1 AND (name LIKE ? OR short_description LIKE ?"
            . " OR full_description LIKE ? OR articul LIKE ?)";
        
        $result = $db->prepare($sql);
        $result->execute(array("%$query%","%$query%","%$query%","%$query%"));        
        
        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['articul'] = $row['articul'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['short_description'] = $row['short_description'];
            $products[$i]['image'] = $row['image'];
            $i++;
        }
        return $products;
    }
    
    /**
     * Возвращает список товары для страницы поиска
     */
    public static function searchByQueryForAdmin($query)
    {
        $products = array();
        
        $db = Db::getConnection();

        $sql = "SELECT * FROM product WHERE name LIKE ? OR short_description LIKE ?"
            . " OR full_description LIKE ? OR articul LIKE ?";
        
        $result = $db->prepare($sql);
        $result->execute(array("%$query%","%$query%","%$query%","%$query%"));        
        
        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['articul'] = $row['articul'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['short_description'] = $row['short_description'];
            $products[$i]['image'] = $row['image'];
            $i++;
        }
        return $products;
    }
    
    /**
     * Возвращает список товаров под полем поиска
     */
    public static function searchAjax($query)
    {
        $productsList = array();
        $db = Db::getConnection();
        
        $sql = "SELECT * FROM product WHERE status=1 AND (name LIKE ? OR short_description LIKE ?"
            . " OR full_description LIKE ? OR articul LIKE ?) ORDER BY name LIMIT 6";
        
        $result = $db->prepare($sql);
        $result->execute(array("%$query%","%$query%","%$query%","%$query%"));  
        
        while($data = $result->fetch()){
            $productsList[] = $data['id']. "-" . $data['name']; 
        }
        return $productsList;
    }
    
    /**
     * Возвращает список товаров под полем поиска
     */
    public static function searchAjaxForAdmin($query)
    {        
        $productsList = array();
        $db = Db::getConnection();
        
        $sql = "SELECT * FROM product WHERE name LIKE ? OR short_description LIKE ?"
            . " OR full_description LIKE ? OR articul LIKE ? ORDER BY name LIMIT 6";
        
        $result = $db->prepare($sql);
        $result->execute(array("%$query%","%$query%","%$query%","%$query%"));  
        
        while($data = $result->fetch()){
            $productsList[] = $data['id']. "-" . $data['name']; 
        }
        return $productsList;
    }

    /**
     * Возвращает список товаров
     * @return array <p>Массив с товарами</p>
     */
    public static function getProductsList()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT id, name, price, articul FROM product ORDER BY id ASC');
        $productsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['articul'] = $row['articul'];
            $productsList[$i]['price'] = $row['price'];
            $i++;
        }
        return $productsList;
    }
     /**
     * Удаляет товар с указанным id
     * @param integer $id <p>id товара</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function deleteProductById($id)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'DELETE FROM product WHERE id = :id';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Редактирует товар с заданным id
     * @param integer $id <p>id товара</p>
     * @param array $options <p>Массив с информацей о товаре</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateProductById($id, $options)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE product
            SET 
                name = :name, 
                articul = :articul, 
                price = :price, 
                procurement_price = :procurement_price, 
                category_id = :category_id, 
                stock = :stock, 
                short_description = :short_description, 
                full_description = :full_description, 
                family = :family, 
                areal = :areal, 
                size = :size, 
                temperature = :temperature, 
                volume = :volume, 
                status = :status
            WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':articul', $options['articul'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_INT);
        $result->bindParam(':procurement_price', $options['procurement_price'], PDO::PARAM_INT);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':stock', $options['stock'], PDO::PARAM_INT);
        $result->bindParam(':short_description', $options['short_description'], PDO::PARAM_STR);
        $result->bindParam(':full_description', $options['full_description'], PDO::PARAM_STR);
        $result->bindParam(':family', $options['family'], PDO::PARAM_STR);
        $result->bindParam(':areal', $options['areal'], PDO::PARAM_STR);
        $result->bindParam(':size', $options['size'], PDO::PARAM_STR);
        $result->bindParam(':temperature', $options['temperature'], PDO::PARAM_STR);
        $result->bindParam(':volume', $options['volume'], PDO::PARAM_STR);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        return $result->execute();
    }

    /**
     * Редактирует изображение товара с заданным id
     * @param integer $id <p>id товара</p>
     * @param array $string <p>Путь и название изображения</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateImageById($id, $image)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE product
            SET 
                image = :image
            WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Добавляет новый товар
     * @param array $options <p>Массив с информацией о товаре</p>
     * @return integer <p>id добавленной в таблицу записи</p>
     */
    public static function createProduct($options)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'INSERT INTO product '
                . '(name, category_id, price, procurement_price, stock, short_description, full_description,'
                . 'articul, family, areal, size, temperature, volume, status)'
                . 'VALUES '
                . '(:name, :category_id, :price, :procurement_price, :stock, :short_description, :full_description,'
                . ':articul, :family, :areal, :size, :temperature, :volume, :status)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':articul', $options['articul'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_INT);
        $result->bindParam(':procurement_price', $options['procurement_price'], PDO::PARAM_INT);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':stock', $options['stock'], PDO::PARAM_INT);
        $result->bindParam(':short_description', $options['short_description'], PDO::PARAM_STR);
        $result->bindParam(':full_description', $options['full_description'], PDO::PARAM_STR);
        $result->bindParam(':family', $options['family'], PDO::PARAM_STR);
        $result->bindParam(':areal', $options['areal'], PDO::PARAM_STR);
        $result->bindParam(':size', $options['size'], PDO::PARAM_STR);
        $result->bindParam(':temperature', $options['temperature'], PDO::PARAM_STR);
        $result->bindParam(':volume', $options['volume'], PDO::PARAM_STR);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        if ($result->execute()) {
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }
        // Иначе возвращаем 0
        return 0;
    }

    /**
     * Возвращает текстое пояснение наличия товара:<br/>
     * <i>0 - Под заказ, 1 - В наличии</i>
     * @param integer $availability <p>Статус</p>
     * @return string <p>Текстовое пояснение</p>
     */
    public static function getAvailabilityText($availability)
    {
        switch ($availability) {
            case '1':
                return 'В наличии';
                break;
            case '0':
                return 'Под заказ';
                break;
        }
    }

    /**
     * Возвращает путь к изображению
     * @param integer $id
     * @return string <p>Путь к изображению</p>
     */
    public static function getImage($name)
    {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';

        // Путь к папке с товарами
        $path = '/assets/img/fishes/';
        
        $changed_name = mb_strtolower(str_replace(' ', '-', $name), "UTF-8");

        // Путь к изображению товара
        $pathToProductImage = $path . $changed_name . '.png';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }

        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }
    
    /**
     * Возвращает ссумму
     * @param string $array
     * @param string $key
     * @return int <p>Общую сумму</p>
     */
    public static function getSumTwoDemArray($array, $key)
    {
        $total = 0;
        foreach ($array as $someKey => $item) // подсчёт общего количества в двумерной массиве
            $total += $item[$key];
        return $total;        
    }
}