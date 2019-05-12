<?php

class CartController
{

    public function actionAdd($id)
    {
        // Добавляем товар в корзину
        Cart::addProduct($id);

        // Возвращаем пользователя на страницу
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function actionAddAjax($id)
    {
        $isPossible = Cart::checkIfEnough($id, 1);
        
        // Добавляем товар в корзину, если возможно        
        if ($isPossible) {
            echo Cart::addProduct($id);
        } else {
            echo "Не хватает";
        }        
        return true;
    }

    public function actionAddNumber($id, $number)
    {        
        $isPossible = Cart::checkIfEnough($id, $number);
        
        // Добавляем товар в корзину, если возможно    
        if ($isPossible) {
            echo Cart::addNumberOfProducts($id, $number);
        } else {
            echo "Не хватает";
        }  
        return true;
    }

    public function actionChangeNumber($id, $number)
    {                
        $isPossible = Cart::checkIfEnough($id, $number, true);
        
        // Меняем количество товаров в корзине, если возможно    
        if ($isPossible) {
            echo Cart::changeNumberOfProducts($id, $number);
        } else {
            echo "Не хватает";
        }  
        return true;
    }

    public function actionDelete($id)
    {
        // Удаляет товар из корзины
        Cart::deleteProduct($id);
        header("Location: /cart");
    }

    public function actionCountAjax()
    {
        echo Cart::getTotalPriceFromStart() . " ₽";
        return true;
    }

    public function actionCountCost($id, $number)
    {
        $isPossible = Cart::checkIfEnough($id, $number, true);
         
        if ($isPossible) {
            echo Cart::getCountCost($id, $number) . " ₽";
        } else {
            echo "Не хватает";
        }  
        return true;
    }

    public function actionIndex()
    {
        $title = "Корзина товаров";
        
        $productsInCart = false;

        // Получим данные из корзины
        $productsInCart = Cart::getProducts();

        if ($productsInCart) {
            // Получаем полную информацию о товарах для списка
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);

            // Получаем общую стоимость товаров
            $totalPrice = Cart::getTotalPrice($products);
        }

        require_once(ROOT . '/views/cart/index.php');

        return true;
    }
    
    public function actionCheckout()
    {
        // Статус успешного оформления заказа
        $result = false;
        $title = "Оформление заказа";


        // Форма отправлена?
        if (isset($_POST['submit'])) {
            // Форма отправлена? - Да
            // Считываем данные формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userCity = $_POST['userCity'];
            $userStreet = $_POST['userStreet'];
            $userHouse = $_POST['userHouse'];
            $userAppartment = $_POST['userAppartment'];
            $userComment = $_POST['userComment'];
            $delivery = $_POST['delivery'];

            // Валидация полей
            $errors = false;
            if (!User::checkName($userName))
                $errors[] = 'Неправильное имя';
            if (!User::checkPhone($userPhone))
                $errors[] = 'Неправильный телефон';
            if (!empty($_POST['userCity'])) {
                if (!User::checkAddress($userCity))
                    $errors[] = 'Неправильный город';
                if (!User::checkAddress($userStreet))
                    $errors[] = 'Неправильная улица';
                if (!User::checkHouse($userHouse))
                    $errors[] = 'Неправильный дом';
                if (!empty($_POST['userAppartment']) AND !User::checkHouse($userAppartment))
                    $errors[] = 'Неправильная квартира';
            }                

            // Форма заполнена корректно?
            if ($errors == false) {
                // Форма заполнена корректно? - Да
                // Сохраняем заказ в базе данных
                // Собираем информацию о заказе
                $productsInCart = Cart::getProducts();
                $productsInCartByPrices = Cart::getProductsCost();
                if (User::isGuest()) {
                    $userId = null;
                } else {
                    $userId = User::checkLogged();
                }

                // Сохраняем заказ в БД
                $result = Order::save($userName, $userPhone, $userCity, $userStreet, $userHouse, $userAppartment, $userComment, $userId, $delivery, $productsInCart, $productsInCartByPrices);

                if ($result) {
                    // Оповещаем администратора о новом заказе                
//                    $adminEmail = 'aqua-shop-admin@gmail.ru';
//                    $message = 'host-name';
//                    $subject = 'Новый заказ!';
//                    mail($adminEmail, $subject, $message);

                    // Очищаем корзину
                    Cart::clear();
                }
            } else {
                // Форма заполнена корректно? - Нет
                // Итоги: общая стоимость, количество товаров
                $productsInCart = Cart::getProducts();
                $productsInCartByPrices = Cart::getProductsCost();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        } else {
            // Форма отправлена? - Нет
            // Получием данные из корзины      
            $productsInCart = Cart::getProducts();
            $productsInCartByPrices = Cart::getProductsCost();

            // В корзине есть товары?
            if ($productsInCart == false) {
                // В корзине есть товары? - Нет
                // Отправляем пользователя на главную искать товары
                header("Location: /");
            } else {
                // В корзине есть товары? - Да
                // Итоги: общая стоимость, количество товаров
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();

                $userName = false;
                $userPhone = false;
                $userCity = false;
                $userStreet = false;
                $userHouse = false;
                $userAppartment = false;
                $userComment = false;
                $delivery = false;

                // Пользователь авторизирован?
                if (User::isGuest()) {
                    // Нет
                    // Значения для формы пустые
                } else {
                    // Да, авторизирован                    
                    // Получаем информацию о пользователе из БД по id
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    // Подставляем в форму
                    $userName = $user['name'];
                    $userPhone = $user['phone'];
                    $userCity = $user['city'];
                    $userStreet = $user['street'];
                    $userHouse = $user['house'];
                    $userAppartment = $user['appartment'];
                }
            }
        }

        require_once(ROOT . '/views/cart/checkout.php');

        return true;
    }

}
