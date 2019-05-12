<?php

class AdminController extends AdminBase
{

    public function actionIndex()
    {
        $title = "Панель администратора";
        $rights = self::checkAdmin();
        
        if ($rights == "owner")
            require_once(ROOT . '/views/admin/index_owner.php');
        else if ($rights == "admin")
            require_once(ROOT . '/views/admin/index_admin.php');
        else if ($rights == "salseman")        
            require_once(ROOT . '/views/admin/index_salseman.php');
        else
            die("THIS WASN'T SUPPOSED TO HAPPEN");

        return true;
    }

}
