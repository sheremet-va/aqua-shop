<?php
class AdminUserController extends AdminBase 
{ 
    /**
     * Action для страницы "Управление клиентами"
     */
    public function actionIndex()
    {
        // Проверка доступа
        $rights = self::checkAdmin();
        $title = "Список пользователей";
        
        $usersList = User::getUsersList();

        // Подключаем вид
        require_once(ROOT . '/views/admin_user/index.php');
        return true;
    }
    
    /**
     * Action для страницы "Управление клиентами"
     */
    public function actionView($id)
    {
        // Проверка доступа
        $rights = self::checkAdmin();

        // Получаем данные о конкретном клиенте
        $user = User::getUserById($id);
        $title = "Просмотр пользователя: " . $user['name'] . " " . $user['surname'];
        
        if ($user['rights_name'] == 'owner' or $user['rights_name'] == 'admin') {
            die("ACCESS DENIED");
        }
        // Подключаем вид
        require_once(ROOT . '/views/admin_user/view.php');
        return true;
    }
    
    /**
     * Action для страницы "Изменение клиента"
     */
    public function actionUpdate($id)
    {
        // Проверка доступа
        $rights = self::checkAdmin();

        // Получаем данные о конкретном клиенте
        $user = User::getUserById($id);
        $title = "Обновление прав пользователя: " . $user['name'] . " " . $user['surname']; 
        
        if ($user['rights_name'] == 'owner' or $user['rights_name'] == 'admin') {
            die("ACCESS DENIED");
        }

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы редактирования. При необходимости можно валидировать значения
            $updated_rights = $_POST['rights'];

            User::updateUserRightsById($id, $updated_rights);
            header("Location: /admin/user");
        }
        
        // Подключаем вид
        require_once(ROOT . '/views/admin_user/update.php');
        return true;
    }
}
