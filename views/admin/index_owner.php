<?php include ROOT . '/views/layouts/header_admin.php';?>
<div class="container" style="margin-top: 55px">
<div class="row">
    <div id="sidebar" class="span3">
        <div class="well well-small">
            <ul class="nav nav-list">
                <li><a href="/admin/product/"><span class="icon-chevron-right"></span>Список товаров</a></li>
                <li><a href="/admin/product/create"><span class="icon-chevron-right"></span>Добавить товар</a></li>
                <li><a href="/admin/category/"><span class="icon-chevron-right"></span>Управление категориями</a></li>
                <li><a href="/admin/order"><span class="icon-chevron-right"></span>Управление заказами</a></li>
                <li><a href="/owner/raiting"><span class="icon-chevron-right"></span>Рейтинг товаров</a></li>
                <li><a href="/admin/user"><span class="icon-chevron-right"></span>Управление пользователями</a></li>
            </ul>
        </div>
    </div>
    <div class="span9">
        <!--
        New Products
        -->
        <div class="well well-small">
        <h3>Панель администратора </h3>
        <hr class="soften"/>
        <p>Через кабинет администратора можно управлять товарами: добавить товар в БД, изменить информацию о товаре, удалить товар из БД, добавить категорию в БД, изменить категорию, удалить категорию из БД, посмотреть информацию о заказах, изменить из статус, а также полностью обновить.</p>
        <p>Пользователям с правами «хозяин» доступна страница рейтинга товара.</p>
            
        </div>
    </div>
</div>
</div>
<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
