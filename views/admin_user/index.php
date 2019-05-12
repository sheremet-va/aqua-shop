<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li class="active">Управление пользователями</li>
                </ol>
            </div>

	<div class="well well-small">

            <h4>Список клиентов</h4>            
            
            <?php if (isset($error)): ?>
                <ul>
                    <li><?php echo $error; ?></li>
                </ul>
            <?php endif; ?>

            <p>Поиск клиента:</p>
            <form action="/admin/search/" method="GET">
                <input type="text" id="search_box" autocomplete="off" placeholder="Поиск" name="query" class="search-query">
                <button type="submit" class="btn btn-default" style="margin-top: 0;"><i class="icon-search"></i></button>
                <div id="search_user_advice_wrapper"></div>
            </form>
            
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Логин</th>
                    <th>E-mail</th>
                    <th>Дата рождения</th>
                    <th>Права</th>
                </tr>
                <?php foreach ($usersList as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><a href="/admin/user/view/<?php echo $user['id']; ?>"><?php echo $user['name']; ?></a></td>
                        <td><?php echo $user['login']; ?></td>  
                        <td><?php echo $user['email']; ?></td>  
                        <td><?php echo $user['birthdate']; ?></td>   
                        <td><?php echo User::getRightsText($user['rights_name']); ?></td>   
                    </tr>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
        </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>
