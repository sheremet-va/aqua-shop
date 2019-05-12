<?php include ROOT . '/views/layouts/header_admin.php'; ?>

<section style="margin-top: 30px;">
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a> <span class="divider">/</span></li>
                    <li><a href="/admin/user">Управление пользователями</a> <span class="divider">/</span></li>
                    <li class="active">Редактировать права пользователя</li>
                </ol>
            </div>


	<div class="well admin-well">
            <h4>Обновить статус клиента #<?php echo $id; ?></h4>

            <div class="col-lg-4">
                
            <table class="table-admin-small table-bordered table-striped table">
                <tr>
                    <td>Имя клиента</td>
                    <td><?php echo $user['name']; ?></td>
                </tr>
                <tr>
                    <td>Фамилия клиента</td>
                    <td><?php echo $user['surname']; ?></td>
                </tr>
                <tr>
                    <td>Логин клиента</td>
                    <td><?php echo $user['login']; ?></td>
                </tr>
            </table>
                <div class="login-form">
                    <form action="#" method="post">
                        <div class="span4">
                        <p>Изменить права</p>
                        <select name="rights">
                            <option value="salseman" <?php if ($user['rights_name'] == 'salseman') echo ' selected="selected"'; ?>>Продавец</option>
                            <option value="common_user" <?php if ($user['rights_name'] == 'common_user') echo ' selected="selected"'; ?>>Обычный пользователь</option>
                        </select>
                        <br>
                        <br>
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                        </div>
                    </form>
                </div>
            </div>

        </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer_admin.php'; ?>

