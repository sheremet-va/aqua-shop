<?php

/**
 * Контроллер AdminProductController
 * Управление товарами в админпанели
 */
class AdminProductController extends AdminBase
{

    /**
     * Action для страницы "Управление товарами"
     */
    public function actionIndex()
    {
        // Проверка доступа
        $rights = self::checkAdmin();
        $title = "Управление товарами";

        // Получаем список товаров
        $productsList = Product::getProductsList();
        
        if (isset($_POST['submit'])) {
            $productSearch = $_POST['productSearch'];
        
            if(preg_match("([0-9]+)", $productSearch)) {
                header("Location: /admin/product/update/" . $productSearch);
            }
            else {
                $product = Product::getProductByName(trim($productSearch));
                if (!empty($product)) {
                    header("Location: /admin/product/update/" . $product['id']);
                }
            }
        }

        // Подключаем вид
        if ($rights == "salseman")
            require_once(ROOT . '/views/admin_product/index_salesman.php');
        else
            require_once(ROOT . '/views/admin_product/index.php');
        
        return true;
    }

    /**
     * Action для страницы "Добавить товар"
     */
    public function actionCreate()
    {
        // Проверка доступа
        self::checkAdmin();
        $title = "Добавить товар";

        // Получаем список категорий для выпадающего списка
        $categoriesList = Category::getCategoriesListAdmin();

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $options['name'] = $_POST['name'];
            $options['articul'] = $_POST['articul'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['stock'] = $_POST['stock'];
            $options['family'] = $_POST['family'];
            $options['procurement_price'] = $_POST['procurement_price'];
            $options['short_description'] = $_POST['short_description'];
            $options['full_description'] = $_POST['full_description'];
            $options['family'] = $_POST['family'];
            $options['areal'] = $_POST['areal'];
            $options['size'] = $_POST['size'];
            $options['temperature'] = $_POST['temperature'];
            $options['volume'] = $_POST['volume'];
            $options['status'] = $_POST['status'];
            $filename = mb_strtolower(str_replace(' ', '-', $_POST['filename']), "UTF-8");

            // Флаг ошибок в форме
            $errors = false;

            // При необходимости можно валидировать значения нужным образом
            if (!isset($options['name']) || empty($options['name'])) {
                $errors[] = 'Заполните поля';
            }

            if ($errors == false) {
                // Если ошибок нет
                // Добавляем новый товар
                $id = Product::createProduct($options);

                // Если запись добавлена
                if ($id) {
                    // Проверим, загружалось ли через форму изображение
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        // Если загружалось, переместим его в нужную папке, дадим новое имя и добавим в БД
                        move_uploaded_file($_FILES["image"]["tmp_name"], ROOT . "/assets/img/fishes/" . $filename);
                        
                        $newname = "/assets/img/fishes/" . $filename;
                        
                        Product::updateImageById($id, $newname);                        
                    }
                };

                // Перенаправляем пользователя на страницу управлениями товарами
                header("Location: /admin/product");
            }
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_product/create.php');
        return true;
    }

    /**
     * Action для страницы "Редактировать товар"
     */
    public function actionUpdate($id)
    {
        // Проверка доступа
        $rights = self::checkAdmin();
        $title = "Редактировать товар";

        // Получаем список категорий для выпадающего списка
        $categoriesList = Category::getCategoriesListAdmin();

        // Получаем данные о конкретном продукте
        $product = Product::getProductById($id);

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы редактирования. При необходимости можно валидировать значения
            $options['name'] = $_POST['name'];
            $options['articul'] = $_POST['articul'];
            $options['price'] = $_POST['price'];
            $options['procurement_price'] = $_POST['procurement_price'];
            $options['category_id'] = $_POST['category_id'];
            $options['stock'] = $_POST['stock'];
            $options['short_description'] = $_POST['short_description'];
            $options['full_description'] = $_POST['full_description'];
            $options['family'] = $_POST['family'];
            $options['areal'] = $_POST['areal'];
            $options['size'] = $_POST['size'];
            $options['temperature'] = $_POST['temperature'];
            $options['volume'] = $_POST['volume'];
            $options['status'] = $_POST['status'];
            
            $filename =  mb_strtolower(str_replace(' ', '-', $_POST['filename']), "UTF-8");

            // Сохраняем изменения
            if (Product::updateProductById($id, $options)) {
                
                // Если запись сохранена
                // Проверим, загружалось ли через форму изображение
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    $oldname = $product['image'];
                    $newname = $product['image'];  

                    // Если загружалось, переместим его в нужную папке
                    move_uploaded_file($_FILES["image"]["tmp_name"], ROOT . "/assets/img/fishes/" . $filename);

                    $newname = "/assets/img/fishes/" . $filename;
                    
                    // Добавление информации о новом изображении в БД
                    Product::updateImageById($id, $newname);
                   
                    // Если имена загруженных файлов отличаются, удалить старый файл
                    if ($newname != $oldname) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . "/assets/img/fishes/" . $oldname);
                    }
                }
            }

            // Перенаправляем пользователя на страницу управлениями товарами
            header("Location: /admin/product");
        }

        // Подключаем вид
        require_once(ROOT . '/views/admin_product/update.php');
        return true;
    }

    /**
     * Action для страницы "Удалить товар"
     */
    public function actionDelete($id)
    {
        // Проверка доступа
        $rights = self::checkAdmin();
        $title = "Удалить товар";
        $product = Product::getProductById($id);

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Удаляем товар
            Product::deleteProductById($id);

            // Перенаправляем пользователя на страницу управлениями товарами
            header("Location: /admin/product");
        }

        // Подключаем вид
        if ($rights == "salseman")
            die("Access denied");
        else
            require_once(ROOT . '/views/admin_product/delete.php');
        return true;
    }

}

