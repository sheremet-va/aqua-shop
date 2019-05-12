<?php

class User
{

    /**
     * Регистрация пользователя 
     * @params string $name, $password, $surname, $login, $fathersname, $address, $email, $phone, $gender
     * @param date $birthdate
     * @return sql execute
     */
    public static function register($name, $surname, $fathersname, $login, $city, $street, $house, $appartment, $email, $phone, $password, $birthdate, $gender)
    {

        $db = Db::getConnection();

        $sql = "INSERT INTO user (name, surname, fathersname, login, city, street, house, appartment, email, phone, password, birthdate, gender) "
                . "VALUES (:name, :surname, :fathersname, :login, :city, :street, :house, :appartment, :email, :phone, :password, :birthdate, :gender)";

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':surname', $surname, PDO::PARAM_STR);
        $result->bindParam(':fathersname', $fathersname, PDO::PARAM_STR);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':city', $city, PDO::PARAM_STR);
        $result->bindParam(':street', $street, PDO::PARAM_STR);
        $result->bindParam(':house', $house, PDO::PARAM_STR);
        $result->bindParam(':appartment', $appartment, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $result->bindParam(':gender', $gender, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Редактирование данных пользователя
     * @params string $name, $password, $surname, $login, $fathersname, $address, $email, $phone, $gender
     * @param date $birthdate
     * @return sql execute
     */
    public static function edit($id, $name, $password, $surname, $login, $fathersname, $city, $street, $house, $appartment, $email, $phone, $birthdate, $gender)
    {
        $db = Db::getConnection();
        
        $sql = "UPDATE user 
            SET name = :name, password = :password, surname = :surname, login = :login, fathersname = :fathersname,
            city = :city, street = :street, house = :house, appartment = :appartment, email = :email, phone = :phone, 
            birthdate = :birthdate, gender = :gender WHERE id = :id";
        
        $result = $db->prepare($sql);                                  
        $result->bindParam(':id', $id, PDO::PARAM_INT);       
        $result->bindParam(':name', $name, PDO::PARAM_STR);    
        $result->bindParam(':password', $password, PDO::PARAM_STR);     
        $result->bindParam(':surname', $surname, PDO::PARAM_STR);     
        $result->bindParam(':login', $login, PDO::PARAM_STR);     
        $result->bindParam(':fathersname', $fathersname, PDO::PARAM_STR);   
        $result->bindParam(':city', $city, PDO::PARAM_STR);  
        $result->bindParam(':street', $street, PDO::PARAM_STR);  
        $result->bindParam(':house', $house, PDO::PARAM_STR);  
        $result->bindParam(':appartment', $appartment, PDO::PARAM_STR);    
        $result->bindParam(':email', $email, PDO::PARAM_STR);     
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);       
        $result->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);    
        $result->bindParam(':gender', $gender, PDO::PARAM_STR); 
        return $result->execute();
    }

    /**
     * Редактирует клиента с заданным id
     * @param integer $id <p>id клиента</p>
     * @param string $rights <p>Название прав</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateUserRightsById($id, $rights)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE user
            SET 
                rights_name = :rights_name
            WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':rights_name', $rights, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Проверяем существует ли пользователь с заданными $login и $password
     * @param string $login
     * @param string $password
     * @return mixed : ingeger user id or false
     */
    public static function checkUserData($login, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE login = :login';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }

        return false;
    }

    /**
     * Запоминаем пользователя
     * @param string $email
     * @param string $password
     */
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    public static function checkLogged()
    {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    public static function isAdmin()
    {
        if (isset($_SESSION['user'])) {
            $user = self::getUserById($_SESSION['user']);;
        } else {
            return false;
        }
        
        if ($user['rights_name'] == 'owner' or $user['rights_name'] == 'admin' or $user['rights_name'] == 'salseman') {
            return true;
        }
        return false;
    }
    public static function isSalseman()
    {
        if (isset($_SESSION['user'])) {
            $user = self::getUserById($_SESSION['user']);;
        } else {
            return false;
        }
        
        if ($user['rights_name'] == 'salseman') {
            return true;
        }
        return false;
    }

    public static function isGuest()
    {
        if (isset($_SESSION['user']))
            return false;
        return true;
    }

    /**
     * Проверяет имя: не меньше, чем 2 символа
     */
    public static function checkName($name)
    {
        if (preg_match("/^[а-яА-ЯёЁ\s\-]{2,25}$/", trim($name)))
            return true;
        return false;
    }

    /**
     * Проверяет адрес: не меньше, чем 2 символа, только русские буквы
     */
    public static function checkStreet($name)
    {
        if (strlen($name) >= 2 AND strlen($name) <= 25 AND preg_match("/^[0-9а-яА-Яё\s\-]+$/", trim($name)) or strlen($name) == 0)
            return true;
        return false;
    }
    
    /**
     * Проверяет адрес: не меньше, чем 2 символа, только русские буквы
     */
    public static function checkCity($name)
    {
        if (strlen($name) >= 2 AND strlen($name) <= 25 AND preg_match("/^[а-яА-Яё\s\-]+$/", trim($name)) or strlen($name) == 0)
            return true;
        return false;
    }

    /**
     * Проверяет дом: только цифры, русские буквы и \ /
     */
    public static function checkHouse($name)
    {
        if (preg_match("/^[0-9а-яА-Яё\\/]{1,}$/", trim($name)) or strlen($name) == 0)
            return true;
        return false;
    }
    
    /**
     * Проверяет отчество: не меньше, чем 2 символа, или ноль
     */
    public static function checkFathersName($name)
    {
        if (preg_match("/^[0-9а-яА-Яё\\/]{2,}$/", trim($name)) or strlen($name) == 0)
            return true;
        return false;
    }    

    /**
     * Проверяет пол
     */
    public static function checkGender($gender) 
    {
        if ($gender === 0 || $gender == 1 || $gender == 2)
            return true;
        return false;
    }
    
    /**
     * Проверяет телефон (только 10 цифр)
     */
    public static function checkPhone($phone)
    {
        if (preg_match("/^[0-9]{10}$/", trim($phone)))
            return true;
        return false;
    }

    /**
     * Проверяет пароль: не меньше, чем 6 символов
     */
    public static function checkPassword($password)
    {
        if (preg_match("/^[a-zA-Z0-9\_\-\.]{6,}$/", $password))
            return true;
        return false;
    }
    
    /**
     * Проверяет, совпадают ли введенные пароли
     */
    public static function checkPasswordEqual($password, $password_check)
    {
        if ($password === $password_check) 
            return true;
        return false;
    }

    /**
     * Проверяет email
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            return true;
        return false;
    }

    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function checkLogin($login)
    {        
        if (preg_match("/@/", $login))
            return self::checkEmail($login);
        
        if (preg_match("/^[a-zA-Z0-9\_\-\.\$]{5,}$/", $login))
            return true;
        
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE login = :login';

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return false;
        return true;
    }

    /**
     * Returns user by id
     * @param integer $id
     */
    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM user WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            // Указываем, что хотим получить данные в виде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }

    /**
     * Returns boolin if true
     * @param array $user, string $name
     */
    public static function getIfRights($user, $name)
    {        
        if ($user['rights_name'] == $name)
            return true;
        return false;
        
    }
    
    /**
     * Генерирует пароль
     */
    public static function generatePassword()
    {
        $chars = "qazxswedcvfrtgbnhyujmkip123456789QAZXSWEDCVFRTGBNHYUJMKLP_.-";
        $password = null;
        $max = 8;
        $size = StrLen($chars)-1;
        
        while($max--)
            $password .= $chars[rand(0,$size)]; 
        
        return $password;
    }
    
    /**
     * Возвращает список клиентов
     * @return array <p>Массив с клиентами</p>
     */
    public static function getUsersList()
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT id, name, surname, birthdate, email, login, rights_name FROM user WHERE NOT rights_name = "owner" AND NOT rights_name = "admin" ORDER BY id ASC');
        $usersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $usersList[$i]['id'] = $row['id'];
            $usersList[$i]['name'] = $row['name'] . " " . $row['surname'];
            $usersList[$i]['birthdate'] = $row['birthdate'];
            $usersList[$i]['email'] = $row['email'];
            $usersList[$i]['login'] = $row['login'];
            $usersList[$i]['rights_name'] = $row['rights_name'];
            $i++;
        }
        return $usersList;
    }
    
    /**
     * Возвращает список товары для страницы поиска
     */
    public static function searchByQuery($query)
    {
        $users = array();
        
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE (name LIKE ? OR surname LIKE ?'
            . ' OR fathersname LIKE ? OR email LIKE ?) WHERE NOT'
            . ' rights_name = "owner" AND NOT rights_name = "admin" ORDER BY name';
        
        $result = $db->prepare($sql);
        $result->execute(array("%$query%","%$query%","%$query%","%$query%"));        
        
        $i = 0;
        while ($row = $result->fetch()) {
            $users[$i]['id'] = $row['id'];
            $users[$i]['name'] = $row['name'] . " " . $row['surname'];
            $users[$i]['fathersname'] = $row['fathersname'];
            $users[$i]['email'] = $row['email'];
            $users[$i]['birthdate'] = $row['birthdate'];
            $i++;
        }
        return $users;
    }
    
    /**
     * Возвращает список товаров под полем поиска
     */
    public static function searchAjax($query)
    {        
        $userList = array();
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM user WHERE (name LIKE ? OR surname LIKE ?'
            . ' OR fathersname LIKE ? OR email LIKE ?) AND NOT '
            . ' rights_name = "owner" AND NOT rights_name = "admin" ORDER BY name LIMIT 6';
        
        $result = $db->prepare($sql);
        $result->execute(array("%$query%","%$query%","%$query%","%$query%"));  
        
        while($data = $result->fetch()){
            $userList[] = $data['id']. "-" . $data['name'] . " " . $data['surname'] . " " . $data['fathersname']; 
        }
        return $userList;
    }

    /**
     * Возвращает текстое пояснение названия прав
     * @param integer $rights <p>Права</p>
     * @return string <p>Текстовое пояснение</p>
     */
    public static function getRightsText($rights)
    {
        switch ($rights) {
            case 'common_user':
                return 'Обычный пользователь';
                break;
            case 'admin':
                return 'Администратор';
                break;
            case 'owner':
                return 'Владелец';
                break;
            case 'salseman':
                return 'Продавец';
                break;
        }
    }
    
    /**
     * Returns username with uppercase
     * @param integer $id
     */
    public static function upperFirst($word) {
	$word_first = mb_strtoupper(mb_substr($word, 0, 1, "UTF-8"), "UTF-8");
	$word_last = mb_strtolower(mb_substr($word, 1, strlen($word), "UTF-8"), "UTF-8");
	$result = $word_first . $word_last;	
	return $result;
    }

}
