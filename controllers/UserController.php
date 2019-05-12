<?php

class UserController
{

    public function actionRegister()
    {
        $title = "Регистрация";
        
        $categories = array();
        $categories = Category::getCategoriesList();
        
        $name = '';
        $surname = '';
        $fathersname = '';
        $gender = '';
        $email = '';
        $phone = '';
        $userCity = '';
        $userStreet = '';
        $userHouse = '';
        $userAppartment = '';
        $login = '';
        $password = '';
        $password_check = '';
        $birthdate = NULL;
        $result = false;
        
        if (isset($_POST['submit'])) {
            $name = User::upperFirst(trim(htmlspecialchars($_POST['name'])));
            $surname = User::upperFirst(trim(htmlspecialchars($_POST['surname'])));
            if(!empty($_POST['fathersname']))
		$fathersname = User::upperFirst(trim(htmlspecialchars($_POST['fathersname'])));	
            if(!empty($_POST['gender']))
		$gender=$_POST['gender'];
            $email = $_POST['email'];	
            $phone = $_POST['phone'];
            if(!empty($_POST['userCity']))
		$userCity = trim(htmlspecialchars($_POST['userCity']));
            if(!empty($_POST['userStreet']))
		$userStreet = trim(htmlspecialchars($_POST['userStreet']));
            if(!empty($_POST['userHouse']))
		$userHouse = trim(htmlspecialchars($_POST['userHouse']));
            if(!empty($_POST['userAppartment']))
		$userAppartment = trim(htmlspecialchars($_POST['userAppartment']));
            if(empty($_POST['login']))
		$login = $email;
            else
                $login = trim(htmlspecialchars($_POST['login']));
            $password = $_POST['password'];
            $password_check = $_POST['password_check'];
            if(!empty($_POST['birthdate']))
		$birthdate=$_POST['birthdate'];
            
            $errors = false;
            
            // Проверки правильности ввода данных в формы
            
            if (!User::checkName($name))
                $errors[] = 'Имя не должно быть короче 2-х символов';
            
            if (!User::checkName($surname))
                $errors[] = 'Фамилия не должна быть короче 2-х символов';
            
            if (!User::checkFathersName($fathersname))
                $errors[] = 'Отчество не должно быть короче 2-х символов';
            
            if (!User::checkGender($gender))
                $errors[] = 'Неверно выбранный пол';
            
            if (!User::checkEmail($email))
                $errors[] = 'Неверный email';
            
            if (!User::checkPhone($phone))
                $errors[] = 'Недопустимый номер телефона. Номер телефона состоит из 10 цифр и начинается с девятки. Например, 9111222333.';
            
            if (!User::checkLogin($login))
                $errors[] = 'Недопустимый логин. Логин должен состоять минимум из 6 символов, доступны только буквы латинского алфавита, цифры и специальные символы -, _ и .';
            
            if (!User::checkCity($userCity))
                $errors[] = 'Недопустимый город';
            
            if (!User::checkStreet($userStreet))
                $errors[] = 'Недопустимая улица';
            
            if (!User::checkHouse($userHouse))
                $errors[] = 'Недопустимый дом';
            
            if (!User::checkHouse($userAppartment))
                $errors[] = 'Недопустимая квартира';
            
            if (!User::checkPassword($password))
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            
            if (!User::checkPasswordEqual($password, $password_check))
                $errors[] = 'Введённые пароли не совпадают';
            
            if (User::checkEmailExists($email))
                $errors[] = 'Такой email уже используется';
            
            if ($errors == false)
                $result = User::register($name, $surname, $fathersname, $login, $userCity, $userStreet, $userHouse, $userAppartment, $email, $phone, password_hash($password, PASSWORD_ARGON2I), $birthdate, $gender);
        }

        require_once(ROOT . '/views/user/register.php');

        return true;
    }

    public function actionLogin()
    {
        $title = "Вход";
        
        $categories = array();
        $categories = Category::getCategoriesList();
        
        $login = '';
        $password = '';
        
        if (isset($_POST['submit'])) {
            $login = trim($_POST['login']);
            $password = trim($_POST['password']);
            
            $errors = false;
                        
            // Валидация полей
            if (!User::checkLogin($login))
                $errors[] = 'Неверный логин';
            
            if (!User::checkPassword($password))
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            
            // Проверяем существует ли пользователь
            $userId = User::checkUserData($login, $password);
            
            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);
                
                // Перенаправляем пользователя в закрытую часть - кабинет 
                header("Location: /cabinet/"); 
            }

        }

        require_once(ROOT . '/views/user/login.php');

        return true;
    }
    
    /**
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout()
    {
        session_start();
        unset($_SESSION["user"]);
        header("Location: /");
    }
}
