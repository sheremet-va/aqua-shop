<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/user">Управление пользователями</a> <span class="divider">/</span></li>
                    <li class="active">Просмотр пользователя</li>
                </ol>
            </div>


	<div class="well well-small">
            <h4>Просмотр пользователя #<?php echo $user['id']; ?></h4>

            <h5>Информация о пользователе</h5>
            <table class="table-admin-small table-bordered table-striped table">
                <tr>
                    <td>Имя клиента</td>
                    <td><?php echo $user['name']; ?></td>
                </tr>
                <tr>
                    <td>Фамилия клиента</td>
                    <td><?php echo $user['surname']; ?></td>
                </tr>
                <?php if (!empty($user['fathersname'])): ?>
                    <tr>
                        <td>Отчество клиента</td>
                        <td><?php echo $user['fathersname']; ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>Логин клиента</td>
                    <td><?php echo $user['login']; ?></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <?php if (!empty($user['phone'])): ?>
                    <tr>
                        <td>Телефон</td>
                        <td><?php echo $user['phone']; ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($user['birthdate'])): ?>
                    <tr>
                        <td>Дата рождения</td>
                        <td><?php echo $user['birthdate']; ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($user['city'])): ?>
                    <tr>
                        <td>Город</td>
                        <td><?php echo $user['city']; ?></td>
                    </tr>
                <?php endif; ?>
            </table>

            <a href="/admin/user/" class="btn btn-default back"><i class="icon-arrow-left"></i> Назад</a> <a href="/admin/user/update/<?php echo $user['id']; ?>" class="btn btn-default back"><i class="icon-edit"></i> Обновить права</a>
            <br/><br/>
        </div>
        </div>


</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

