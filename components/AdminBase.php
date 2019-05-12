<?php

/**
 * Абстрактный класс AdminBase содержит общую логику для контроллеров, которые 
 * используются в панели администратора
 */
abstract class AdminBase
{
    /**
     * Метод, который проверяет пользователя на то, имеет ли он доступ к админ-панели
     * @return boolean
     */
    public static function checkAdmin()
    {
        // Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
        $userId = User::checkLogged();

        // Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);

        // Если роль текущего пользователя "admin", пускаем его в админпанель
        if ($user['rights_name'] == 'owner' or $user['rights_name'] == 'admin' or $user['rights_name'] == 'salseman') {
            return $user['rights_name'];
        }

        // Иначе завершаем работу с сообщением об закрытом доступе
        die('Access denied');
    }
    
    /**
     * Метод, который проверяет пользователя на то, является ли он администратором
     * @return boolean
     */
    public static function checkAdminRight()
    {
        // Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
        $userId = User::checkLogged();

        // Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);

        // Если роль текущего пользователя "admin", пускаем его в админпанель
        if ($user['rights_name'] == 'admin') {
            return true;
        }
        return false;
    }
    
    /**
     * Метод, который проверяет пользователя на то, является ли он владельцем
     * @return boolean
     */
    public static function checkOwnerRight()
    {
        // Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
        $userId = User::checkLogged();

        // Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);

        // Если роль текущего пользователя "owner", пускаем его в админпанель
        if ($user['rights_name'] == 'owner') {
            return true;
        }
        return false;
    }
    
    /**
     * Метод, который проверяет пользователя на то, является ли он продавцом
     * @return boolean
     */
    public static function checkSalesmanRight()
    {
        // Проверяем авторизирован ли пользователь. Если нет, он будет переадресован
        $userId = User::checkLogged();

        // Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);

        // Если роль текущего пользователя "owner", пускаем его в админпанель
        if ($user['rights_name'] == 'salseman') {
            return true;
        }
        return false;
    }


}
