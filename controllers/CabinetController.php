<?php

class CabinetController
{

    public function actionIndex()
    {
        $title = "Личный кабинет";
        
        $categories = array();
        $categories = Category::getCategoriesList();
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        
        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
                
        require_once(ROOT . '/views/cabinet/index.php');

        return true;
    }
    
    public function actionEdit()
    {
        $title = "Редактирование данных о пользователе";
        
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        
        // Получаем информацию о пользователе из БД
        $user = User::getUserById($userId);
        
        $name = $user['name'];
        $password = $user['password'];
        $surname = $user['surname'];
        $fathersname = $user['fathersname'];
        $city = $user['city'];
        $street = $user['street'];
        $house = $user['house'];
        $appartment = $user['appartment'];
        $email = $user['email'];
        $phone = $user['phone'];
        $login = $user['login'];
        $gender = $user['gender'];
        $birthdate = $user['birthdate'];                
                
        $result = false;     

        if (isset($_POST['submit'])) {
            if(!empty($_POST['name']))
		$name = User::upperFirst(trim(htmlspecialchars($_POST['name'])));
            
            if(!empty($_POST['new_password']))
		$new_password = $_POST['new_password'];
            else 
                $new_password = $user['password'];
            
            if(!empty($_POST['surname']))
		$surname = User::upperFirst(trim(htmlspecialchars($_POST['surname'])));
            if(!empty($_POST['fathersname']))
		$fathersname = User::upperFirst(trim(htmlspecialchars($_POST['fathersname'])));
            if(!empty($_POST['city']))
		$city = trim(htmlspecialchars($_POST['city']));
            if(!empty($_POST['street']))
		$street = trim(htmlspecialchars($_POST['street']));
            if(!empty($_POST['house']))
		$house = trim(htmlspecialchars($_POST['house']));
            if(!empty($_POST['appartment']))
		$appartment = trim(htmlspecialchars($_POST['appartment']));
            if(!empty($_POST['login']))
		$login = trim(htmlspecialchars($_POST['login']));
            if(!empty($_POST['email']))
		$email = $_POST['email'];
            if(!empty($_POST['phone']))
		$phone = htmlspecialchars($_POST['phone']);
            if(!empty($_POST['gender']))
		$gender = $_POST['gender'];
            if(!empty($_POST['birthdate']))
		$birthdate = $_POST['birthdate'];
            
            $entered_password = md5(md5($_POST['password']));
            
            $errors = false;
            
            if (!User::checkPasswordEqual($password, $entered_password)) {
                $errors[] = 'Введенный пароль для подтверждения не совпадает с существующим';
            }
            
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            
            if (!User::checkName($surname)) {
                $errors[] = 'Фамилия не должна быть короче 2-х символов';
            }
            
            if (!User::checkFathersName($fathersname)) {
                $errors[] = 'Отчество не должно быть короче 2-х символов';
            }
            
            if (!empty($city) AND !User::checkAddress($city)) {
                $errors[] = 'Неверный город';
            }
            
            if (!empty($street) AND !User::checkAddress($street)) {
                $errors[] = 'Неверная улица';
            }
            
            if (!empty($house) AND !User::checkHouse($house)) {
                $errors[] = 'Неверный дом';
            }
            
            if (!empty($appartment) AND !User::checkHouse($appartment)) {
                $errors[] = 'Неверная квартира';
            }
            
            if (!User::checkGender($gender)) {
                $errors[] = 'Неверно выбранный пол';
            }
            
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }        
                        
            if (!User::checkPhone($phone)) {
                $errors[] = 'Неправильный телефон';
            } 
                        
            if (!User::checkLogin($login)) {
                $errors[] = 'Недопустимый логин. Логин должен состоять минимум из 5 символов, доступны только буквы латинского алфавита, цифры и специальные символы -, _ и .';
            }
            
            if (!empty($_POST['new_password']) AND !User::checkPassword($new_password) ) 
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            else
                $new_password = password_hash($new_password, PASSWORD_ARGON2I);
            
            if ($email != $user['email']) {
                if (User::checkEmailExists($email)) {
                    $errors[] = 'Такой email уже используется';
                }            
            }
            
            if ($login != $user['login']) {
                if (User::checkEmailExists($login)) {
                    $errors[] = 'Такой логин уже используется';
                }            
            }
            
            if ($errors == false) {
                $result = User::edit($userId, $name, $new_password, $surname, $login, $fathersname, $city, $street, $house, $appartment, $email, $phone, $birthdate, $gender);
            }

        }

        require_once(ROOT . '/views/cabinet/edit.php');

        return true;
    }    
    
    public function actionHistory($page = 1)
    {
        $title = "Список покупок";
        
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        $ordersList = Order::getOrdersListByUserId($userId, $page);
        $productsKeys = array();
        
        foreach ($ordersList as $number => $order) {
            $productsQuantitiesArray = json_decode($order['products'], true); // массив с кол-вом заказанного товара
            $productsPricesArray = json_decode($order['products_prices'], true);  // массив с ценами товаров
            
            $ordersList[$number]['products_prices'] = $productsPricesArray;
            $ordersList[$number]['products'] = $productsQuantitiesArray;

            $productsKeys = array_keys($productsQuantitiesArray);         
            $products[$number] = Product::getProductsByIds(array_unique($productsKeys));
            
            $totalPrice[$number] = 0;
            foreach ($productsQuantitiesArray as $p_id => $q)
                $totalPrice[$number] += $q * $productsPricesArray[$p_id];
        }
        
        $total = Order::getTotalOrders($userId); 
        $pagination = new Pagination($total, $page, Order::SHOW_BY_DEFAULT, 'page-');
                
        require_once(ROOT . '/views/cabinet/history.php');

        return true;
    }
    

}